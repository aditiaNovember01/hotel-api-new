@extends('adminlte::page')

@section('title', 'Tambah Kamar')

@section('content_header')
    <h1>Tambah Kamar</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="#" method="POST">
                @csrf
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label>Harga per Malam</label>
                    <input type="number" name="price_per_night" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Maksimal Tamu</label>
                    <input type="number" name="max_guest" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>URL Gambar</label>
                    <input type="text" name="image_url" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection 