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
} 