<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomType;
use App\Models\Room;

class DashboardController extends Controller
{
    public function index()
    {
        $rooms = Room::latest()->get();
        $types = RoomType::all();

        return view('dashboard', compact('rooms', 'types'));
    }
}