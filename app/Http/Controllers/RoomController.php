<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomType;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('type')->latest()->get();
        $types = RoomType::all();
        return view('rooms', compact('rooms', 'types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|max:10|unique:rooms,room_number',
            'rooms_type_id' => 'required|exists:room_types,id',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1|max:20',
            'description' => 'nullable|string|max:1000'
        ]);

        Room::create($validated);
        return redirect()->back()->with('success', 'Room created successfully.');
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|max:10|unique:rooms,room_number',
            'rooms_type_id' => 'required|exists:room_types,id',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1|max:2',
            'description' => 'nullable|string|max:1000'
        ]);

        $room->update($validated);
        return redirect()->back()->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->back()->with('success', 'Room deleted successfully.');
    }
    
}
