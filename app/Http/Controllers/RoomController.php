<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\GuestRoom;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomsUrl;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Support\Facades\Log;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with(['roomUrl' => function ($query) {
            $query->where('status', 'active');
        }])->get();

        // return $rooms;

        return view('used.room-grid', compact('rooms'));
    }

    public function show($id)
    {
        $room = Room::find($id);
        return response()->json([
            'status' => 'Success',
            'data' => $room
        ], 200);
    }

    public function store(Request $request)
    {
        $createRoom = new Room();
        $createRoom->name = $request->name;
        $createRoom->status = $request->status;

        if (!$createRoom->save()) {
            return response()->json([
                'status' => 'Failed',
                'error' => 'Failed to save room'
            ], 500);
        }

        if ($createRoom->status === 'active') {
            RoomsUrl::create([
                'room_id' => $createRoom->id,
                'url' => Str::random(10),
                'status' => 'active'
                // Add other necessary fields for the chat channel
            ]);
        }

        return response()->json([
            'status' => 'Success',
            'data' => $createRoom
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $room = Room::find($id);
        $room->name = $request->name;
        $room->status = $request->status;

        if (!$room->save()) {
            return response()->json([
                'status' => 'Failed',
                'error' => 'Failed to update room'
            ], 500);
        }

        if ($room->status === 'active') {
            // Check if there is an existing active RoomsUrl
            $existingUrl = RoomsUrl::where('room_id', $room->id)->where('status', 'active')->first();

            if (!$existingUrl) {
                // If no existing active URL, create a new one
                RoomsUrl::create([
                    'room_id' => $room->id,
                    'url' => Str::random(10),
                    'status' => 'active'
                    // Add other necessary fields for the chat channel
                ]);
            }
        } else {
            // If the room is deactivated, deactivate the existing RoomsUrl
            RoomsUrl::where('room_id', $room->id)->where('status', 'active')->update(['status' => 'inactive']);
        }


        return response()->json([
            'status' => 'Success',
            'data' => $room
        ], 200);
    }

    public function destroy($id)
    {
        $room = Room::find($id);

        if (!$room->delete()) {
            return response()->json([
                'status' => 'Failed',
                'error' => 'Failed to delete room'
            ], 500);
        }

        return response()->json([
            'status' => 'Success',
            'message' => 'Room deleted successfully'
        ], 200);
    }


    public function join($id)
    {

        $checkingRoomExist = RoomsUrl::where('url', $id)->where('status', 'active')->first();

        if (!$checkingRoomExist) {
            $data = [
                'status'  => 'Failed',
                'message' => 'Room Chanel Sudah Tutup'
            ];
            return response()->json($data, 404);
        }

        $roomId =  $checkingRoomExist->room_id;
        $url =  $checkingRoomExist->url;


        return view('used.chat-public', compact('roomId','url'));
    }


    public function guestJoinMakeSession(Request $request)
    {
        $name = $request->name;
        $url = $request->url;

        // Retrieve active room based on URL
        $getRoom = RoomsUrl::where('url', $url)->where('status', 'active')->first();

        if (!$getRoom) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Room not found or inactive'
            ], 404);
        }

        // Create guest record
        $guest = Guest::create([
            'name' => $name,
            'join_at' => Carbon::now()
        ]);

        // Store guest ID and name in session
        Session::put('guest_id', $guest->id);
        Session::put('guest_name', $guest->name);
        Session::put('room_id', $getRoom->room_id);
        Session::put('guest_joined', true);

        // Record guest's participation in the room
        GuestRoom::create([
            'guest_id' => $guest->id,
            'room_id' => $getRoom->id
        ]);

        return response()->json([
            'status' => 'Success',
            'message' => 'Session successfully created'
        ], 200);
    }

    public function sendMessage(Request $request)
{
    $roomId = Session::get('room_id');
    $guestId = Session::get('guest_id');
    $message = $request->input('content');
    $messageType = $request->input('message_type');
    $guestName = Session::get('guest_name');

    Log::info([
        'a' => $roomId,
        'b' => $guestId,
        'c' => $message,
        'd' => $messageType,
        'e' => $guestName
    ]);

    $storeMessage = Message::create([
        'room_id' => $roomId,
        'guest_id' => $guestId,
        'content' => $message,
        'message_type' => $messageType
    ]);

    // Broadcast event
    // MessageSent::dispatch($guestName, $roomId, $message);
    broadcast(new MessageSent($guestName, $roomId, $message))->toOthers();
    // event(new MessageSent($guestName, $roomId, $message));

    return response()->json(['status' => 'success'],200);
}

    public function tet()
    {


        return view('used.chat-public');
    }
}
