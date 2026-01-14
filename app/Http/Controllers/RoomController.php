<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Support\Facades\Storage;
use Dompdf\Dompdf;

class RoomController extends Controller
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
        return view('rooms', compact('rooms', 'types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|max:10',
            'rooms_type_id' => 'required|exists:room_types,id',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1|max:20',
            'description' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('room_photos', 'public');
            $validated['photo'] = $photoPath;
        }

        Room::create($validated);
        return redirect()->back()->with('success', 'Room created successfully.');
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|max:10',
            'rooms_type_id' => 'required|exists:room_types,id',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1|max:20',
            'description' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if($room->photo) {
                Storage::disk('public')->delete($room->photo);
            }

            $photoPath = $request->file('photo')->store('room_photos', 'public');
            $validated['photo'] = $photoPath;
        }

        $room->update($validated);
        return redirect()->back()->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.trash')->with('success', 'Room deleted successfully.');
    }
    
    public function trash()
    {
        $rooms = Room::onlyTrashed()->with('type')->latest('deleted_at')->get();
        $types = RoomType::all();

        return view('trash', compact('rooms', 'types'));
    }

    public function restore($id)
    {
        $rooms = Room::withTrashed()->findOrFail($id);
        $rooms->restore();

        return redirect()->route('rooms.index')->with('success', 'Room restored successfully!');
    }

    public function forceDelete($id)
    {
        $room = Room::withTrashed()->findOrFail($id);

        if ($room->photo) {
            Storage::disk('public')->delete($room->photo);
        }

        $room->forceDelete();
        
        return redirect()->route('rooms.trash')->with('success', 'Room permanently deleted successfully');
    }

    public function export(Request $request)
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
            $query->where('room_type_id', $request->type_filter);
        }

        $rooms = $query->latest()->get();

        $filename = 'rooms_export_' . date('Y-m-d_His') . '.pdf';

        $html = '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Rooms Export</title>
            <style>
                body {
                    font-family: "Helvetica", Arial, sans-serif;
                    background: #f5f5f4; /* stone-50 */
                    margin: 0;
                    padding: 30px;
                    color: #27272a; /* stone-900 */
                }

                .container {
                    max-width: 1100px;
                    margin: auto;
                    background: #fafafa; /* stone-100 */
                    padding: 32px;
                    border-radius: 10px;
                    border: 1px solid #d4d4d4; /* stone-300 */
                }

                .header {
                    text-align: center;
                    margin-bottom: 30px;
                }

                .header h1 {
                    margin: 0;
                    font-size: 26px;
                    letter-spacing: 0.5px;
                    color: #27272a; /* stone-900 */
                }

                .header p {
                    margin-top: 8px;
                    font-size: 14px;
                    color: #71717a; /* stone-500 */
                }

                .divider {
                    height: 2px;
                    background: #d4d4d4; /* stone-300 */
                    margin: 25px 0;
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                    font-size: 14px;
                }

                th {
                    background: #f4f4f5; /* stone-50 */
                    color: #27272a; /* stone-900 */
                    padding: 12px 10px;
                    text-align: left;
                    font-weight: 600;
                    border-bottom: 1px solid #d4d4d4; /* stone-300 */
                }

                td {
                    padding: 10px;
                    border-bottom: 1px solid #d4d4d4; /* stone-300 */
                    vertical-align: top;
                    color: #52525b; /* stone-600 */
                }

                tr:nth-child(even) {
                    background: #f5f5f4; /* stone-50 */
                }

                .badge {
                    display: inline-block;
                    padding: 4px 10px;
                    font-size: 12px;
                    border-radius: 999px;
                    background: #fef3c7; /* amber-100 */
                    color: #b45309; /* amber-700 */
                    font-weight: 600;
                }

                .price {
                    font-weight: bold;
                    color: #78350f; /* amber-800 */
                }

                .capacity {
                    font-weight: bold;
                    color: #78350f; /* amber-800 */
                }

                .footer {
                    margin-top: 30px;
                    text-align: center;
                    font-size: 13px;
                    color: #71717a; /* stone-500 */
                }

                @media print {
                    body {
                        background: white;
                        padding: 0;
                    }
                    .container {
                        border-radius: 0;
                        border: none;
                    }
                }
            </style>
        </head>
        <body>
            <div class="container">

                <div class="header">
                    <h1>Room Inventory Report</h1>
                    <p>
                        Exported on ' . date('F d, Y \\a\\t h:i A') . '<br>
                        Total Rooms: ' . $rooms->count() . '
                    </p>
                </div>

                <div class="divider"></div>

                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Room Number</th>
                            <th>Room Type</th>
                            <th>Price Per Night</th>
                            <th>Capacity</th>
                            <th>Description</th>
                            <th>Added</th>
                        </tr>
                    </thead>
                    <tbody>';

        $number = 1;
        foreach ($rooms as $room) {
            $html .= '<tr>
                <td>' . $number++ . '</td>
                <td>' . htmlspecialchars($room->room_number) . '</td>
                <td><span class="badge">' . htmlspecialchars($room->type ? $room->type->room_type : 'N/A') . '</span></td>
                <td class="price">' . number_format($room->price_per_night, 2) . '</td>
                <td class="capacity">' . htmlspecialchars($room->capacity) . '</td>
                <td>' . htmlspecialchars($room->description ?? '-') . '</td>
                <td>' . $room->created_at->format('Y-m-d H:i:s') . '</td>
            </tr>';
        }

        $html .= '</tbody>
                </table>
                <div class="footer">
                    Total Rooms: ' . $rooms->count() . '<br/>
                    © ' . date('Y') . ' Room Management System. All rights reserved.
                </div>
            </div>
        </body>
        </html>';

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return $dompdf->stream($filename, ['Attachment' => true]);
    }
}
