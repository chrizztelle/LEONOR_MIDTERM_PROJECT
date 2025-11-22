<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomType;
use App\Models\Room;

class RoomTypeController extends Controller
{
    public function index()
    {
        $rooms = Room::latest()->get();
        $types = RoomType::all();

        return view('types', compact('rooms', 'types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_type' => 'required|string|max:50|unique:room_types,room_type',
            'description' => 'nullable|string|max:1000'
        ]);
        
        RoomType::create($validated);
        return redirect()->back()->with('success', 'Room type created successfully.');
    }

    public function update(Request $request, RoomType $type)
    {
        $validated = $request->validate([
            'room_type' => 'required|string|max:50',
            'description' => 'nullable|string|max:1000'
        ]);

        $type->update($validated);
        return redirect()->back()->with('success', 'Room type updated successfully.');
    }

    public function destroy(RoomType $type)
    {
        $type->delete();
        return redirect()->back()->with('success', 'Room type deleted successfully.');
    }
}
