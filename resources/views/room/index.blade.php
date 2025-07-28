@extends('adminlte::page')

@section('title', 'Daftar Kamar')

@section('content_header')
    <h1>Daftar Kamar</h1>
@endsection

@section('content')
    <a href="{{ route('room.create') }}" class="btn btn-primary mb-3">Tambah Kamar</a>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Harga/Malam</th>
                        <th>Maksimal Tamu</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rooms as $room)
                        <tr>
                            <td>{{ $room->id }}</td>
                            <td>{{ $room->name }}</td>
                            <td>{{ $room->description }}</td>
                            <td>{{ $room->price_per_night }}</td>
                            <td>{{ $room->max_guest }}</td>
                            <td>
                                @if($room->image_url)
                                    <img src="{{ $room->image_url }}" alt="Gambar Kamar" width="60">
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('room.edit', $room->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection 