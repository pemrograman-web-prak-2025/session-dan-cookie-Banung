@extends('layouts.app')

@section('title', 'Tambah Kata Baru')

@section('content')
<div class="form-container" style="max-width: 800px; margin: 0 auto;">
    <div class="form-header">
        <h2>Tambah Kata Baru</h2>
        <p>Tambahkan kata baru ke dalam kamus</p>
    </div>

    <form method="POST" action="{{ route('words.store') }}">
        @csrf
        <div class="form-group">
            <label for="kata">Kata</label>
            <input type="text" id="kata" name="kata" class="form-control" value="{{ old('kata') }}" required autofocus>
            @error('kata')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="definisi">Definisi</label>
            <textarea id="definisi" name="definisi" class="form-control" rows="4" required>{{ old('definisi') }}</textarea>
            @error('definisi')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="contoh">Contoh Penggunaan</label>
            <textarea id="contoh" name="contoh" class="form-control" rows="3" required>{{ old('contoh') }}</textarea>
            @error('contoh')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="tags">Tag (pisahkan dengan koma)</label>
            <input type="text" id="tags" name="tags" class="form-control" placeholder="contoh: teknologi, IT, modern" value="{{ old('tags') }}" required>
            @error('tags')
            <div class="text-danger">{{ $message }}</div>
            @enderror
            <small class="text-muted">Tag akan membantu dalam pencarian kata</small>
        </div>

        <div class="form-footer">
            <a href="{{ route('words.index') }}" class="btn btn-outline">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan Kata</button>
        </div>
    </form>
</div>
@endsection