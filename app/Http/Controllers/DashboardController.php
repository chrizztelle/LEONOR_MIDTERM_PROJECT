<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomType;
use App\Models\Room;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::with('type');

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('room_number', 'like', "%{$searchTerm}%")
                    ->orWhere('price_per_night', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->filled('type_filter') && $request->type_filter != '') {
            $query->where('rooms_type_id', $request->type_filter);
        }

        $rooms = $query->latest()->get();
        $types = RoomType::all();

        return view('dashboard', compact('rooms', 'types'));
    }
}
