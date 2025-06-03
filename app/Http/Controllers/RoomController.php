<?php 

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoomController extends Controller
{
    // Display a listing of rooms
    public function index():JsonResponse     
    {
        return response()->json(Room::all());
    }

    // Store a new room
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:rooms',
        ]);

        $room = Room::create([
            'id' => Str::uuid(),
            'name' => $request->name,
        ]);

       return response()->json(['status' => 'Room created', 'room' => $room], 201);
    }

    // Show a specific room
    public function show($id)
    {
        return Room::findOrFail($id);
    }

    // Update a room
    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:50|unique:rooms,name,' . $room->id,
        ]);

        $room->update([
            'name' => $request->name,
        ]);

        return response()->json($room);
    }

    // Delete a room
    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return response()->json(null, 204);
    }
}
