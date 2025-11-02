<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WordController extends Controller
{
    public function index()
    {
        $words = Word::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('words.index', compact('words'));
    }

    public function create()
    {
        return view('words.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kata' => 'required|string|max:100|unique:words,kata,NULL,id,user_id,' . Auth::id(),
            'definisi' => 'required|string',
            'contoh' => 'required|string',
            'tags' => 'required|string|max:255',
        ]);

        Word::create([
            'kata' => $validated['kata'],
            'definisi' => $validated['definisi'],
            'contoh' => $validated['contoh'],
            'tags' => $validated['tags'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('words.index')
            ->with('success', 'Kata berhasil ditambahkan!');
    }

    public function edit(Word $word)
    {
        // Check if the word belongs to the current user
        if ($word->user_id !== Auth::id()) {
            return redirect()->route('words.index')
                ->with('error', 'Anda tidak memiliki izin untuk mengedit kata ini!');
        }

        return view('words.edit', compact('word'));
    }

    public function update(Request $request, Word $word)
    {
        // Check if the word belongs to the current user
        if ($word->user_id !== Auth::id()) {
            return redirect()->route('words.index')
                ->with('error', 'Anda tidak memiliki izin untuk mengupdate kata ini!');
        }

        $validated = $request->validate([
            'kata' => 'required|string|max:100|unique:words,kata,' . $word->id . ',id,user_id,' . Auth::id(),
            'definisi' => 'required|string',
            'contoh' => 'required|string',
            'tags' => 'required|string|max:255',
        ]);

        $word->update($validated);

        return redirect()->route('words.index')
            ->with('success', 'Kata berhasil diperbarui!');
    }

    public function destroy(Word $word)
    {
        // Check if the word belongs to the current user
        if ($word->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki izin untuk menghapus kata ini!'
            ], 403);
        }

        $word->delete();

        return redirect()->route('words.index')
            ->with('success', 'Kata berhasil dihapus!');
    }
}
