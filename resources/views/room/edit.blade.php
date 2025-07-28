@extends('adminlte::page')

@section('title', 'Edit Kamar')

@section('content_header')
    <h1>Edit Kamar</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="#" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="name" class="form-control" value="{{ $room->name }}" required>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="description" class="form-control">{{ $room->description }}</textarea>
                </div>
                <div class="form-group">
                    <label>Harga per Malam</label>
                    <input type="number" name="price_per_night" class="form-control" value="{{ $room->price_per_night }}" required>
                </div>
                <div class="form-group">
                    <label>Maksimal Tamu</label>
                    <input type="number" name="max_guest" class="form-control" value="{{ $room->max_guest }}" required>
                </div>
                <div class="form-group">
                    <label>URL Gambar</label>
                    <input type="text" name="image_url" class="form-control" value="{{ $room->image_url }}">
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection 