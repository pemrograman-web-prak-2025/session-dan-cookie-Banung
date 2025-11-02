@extends('layouts.app')

@section('title', 'Kelola Kata')

@section('content')
<div class="words-management">
  <div class="page-header">
    <h2>Kata Anda</h2>
    <a href="{{ route('words.create') }}" class="btn btn-primary">
      Tambah Kata Baru
    </a>
  </div>

  <!-- Success Message -->
  @if (session('success'))
  <div class="alert alert-success">
    {{ session('success') }}
  </div>
  @endif

  <!-- Error Message -->
  @if (session('error'))
  <div class="alert alert-danger">
    {{ session('error') }}
  </div>
  @endif

  <!-- Words Table -->
  <div class="words-table-container">
    @if ($words->count() > 0)
    <table class="words-table">
      <thead>
        <tr>
          <th>Kata</th>
          <th>Definisi</th>
          <th>Tags</th>
          <th>Dibuat</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($words as $word)
        <tr>
          <td class="word-cell">{{ $word->kata }}</td>
          <td class="definition-cell">{{ \Illuminate\Support\Str::limit($word->definisi, 100) }}</td>
          <td class="tags-cell">
            @foreach (explode(',', $word->tags) as $tag)
            <span class="tag">#{{ trim($tag) }}</span>
            @endforeach
          </td>
          <td class="date-cell">{{ $word->created_at ? $word->created_at->format('d/m/Y') : '-' }}</td>
          <td class="actions-cell">
            <a href="{{ route('words.edit', $word) }}" class="btn btn-sm btn-outline">
              Edit
            </a>
            <!-- Form untuk hapus kata -->
            <form method="POST" action="{{ route('words.destroy', $word) }}" style="display: inline;">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kata ini?')">
                Hapus
              </button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <!-- Pagination -->
    <div class="custom-pagination">
      <div class="pagination-info">
        Showing {{ $words->firstItem() }} to {{ $words->lastItem() }} of {{ $words->total() }} results
      </div>
      <div class="pagination-links">
        @if ($words->onFirstPage())
        <span class="pagination-link disabled">« Previous</span>
        @else
        <a href="{{ $words->previousPageUrl() }}" class="pagination-link">« Previous</a>
        @endif

        @if ($words->hasMorePages())
        <a href="{{ $words->nextPageUrl() }}" class="pagination-link">Next »</a>
        @else
        <span class="pagination-link disabled">Next »</span>
        @endif
      </div>
    </div>
    @else
    <div class="empty-state">
      <h3>Belum ada kata</h3>
      <p>Anda belum menambahkan kata apapun</p>
    </div>
    @endif
  </div>
</div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Tidak perlu JavaScript untuk delete karena sudah menggunakan form biasa
  });
</script>


@endpush