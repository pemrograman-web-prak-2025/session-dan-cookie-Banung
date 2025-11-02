<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class DictionaryController extends Controller
{
    public function index()
    {
        return view('dictionary.index');
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        if (empty($query)) {
            return response()->json([
                'success' => false,
                'message' => 'Query parameter is required'
            ]);
        }

        // Debug: Log the search query
        Log::info('Searching for: ' . $query);

        // Try simpler search approach first
        $words = Word::where('kata', 'like', '%' . $query . '%')
            ->orWhere('definisi', 'like', '%' . $query . '%')
            ->orWhere('tags', 'like', '%' . $query . '%')
            ->orderBy('kata')
            ->limit(50)
            ->get();

        // If no results with simple search, try fulltext search
        if ($words->isEmpty()) {
            try {
                $words = Word::whereRaw("MATCH(kata, definisi, tags) AGAINST(? IN NATURAL LANGUAGE MODE)", [$query])
                    ->orderBy('kata')
                    ->limit(50)
                    ->get();
            } catch (\Exception $e) {
                Log::error('Fulltext search error: ' . $e->getMessage());
                // If fulltext search fails, return empty results
                $words = collect([]);
            }
        }

        // Debug: Log the results
        Log::info('Found ' . $words->count() . ' results');

        return response()->json([
            'success' => true,
            'data' => $words
        ]);
    }

    public function suggestions(Request $request)
    {
        $query = $request->input('q');

        if (empty($query)) {
            return response()->json([
                'success' => false,
                'message' => 'Query parameter is required'
            ]);
        }

        $suggestions = Word::where('kata', 'like', $query . '%')
            ->orderBy('kata')
            ->limit(5)
            ->get(['kata', 'definisi']);

        return response()->json([
            'success' => true,
            'data' => $suggestions
        ]);
    }

    public function store(Request $request)
    {
        try {
            // Validate input
            $data = $request->validate([
                'kata' => 'required|string|max:100',
                'definisi' => 'required|string',
                'contoh' => 'required|string',
                'tags' => 'required|string|max:255',
            ]);

            // Debug: Log the data being saved
            Log::info('Saving word: ' . json_encode($data));

            // Create word
            $word = Word::create([
                'kata' => $data['kata'],
                'definisi' => $data['definisi'],
                'contoh' => $data['contoh'],
                'tags' => $data['tags'],
                'user_id' => Auth::id(),
            ]);

            // Debug: Log the created word
            Log::info('Created word with ID: ' . $word->id);

            return response()->json([
                'success' => true,
                'message' => 'Kata berhasil ditambahkan',
                'data' => $word
            ]);
        } catch (\Exception $e) {
            Log::error('Error saving word: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambah kata: ' . $e->getMessage()
            ], 500);
        }
    }
}
