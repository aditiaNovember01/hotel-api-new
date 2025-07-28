<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomViewController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return view('room.index', compact('rooms'));
    }

    public function create()
    {
        return view('room.create');
    }

    public function edit($id)
    {
        $room = Room::findOrFail($id);
        return view('room.edit', compact('room'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'price_per_night' => 'required|numeric',
            'max_guest' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('rooms', 'public');
            $data['image_url'] = '/storage/' . $imagePath;
        }

        Room::create($data);
        return redirect()->route('room.index')->with('success', 'Kamar berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);
        $data = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'price_per_night' => 'required|numeric',
            'max_guest' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('rooms', 'public');
            $data['image_url'] = '/storage/' . $imagePath;
        }

        $room->update($data);
        return redirect()->route('room.index')->with('success', 'Kamar berhasil diupdate!');
    }
} 