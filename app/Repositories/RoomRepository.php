<?php


namespace App\Repositories;


use App\Models\Room;
use Illuminate\Support\Facades\Auth;

class RoomRepository
{
    /**
     * Display the list rooms
     */
    public function getRooms($request){
        $data = $request->all();
        $qrcode= isset($data['qrcode']) ? $data['qrcode'] : false;

        if (!$qrcode){
            $rooms = Room::paginate();
        }else{
            $rooms = Room::where('rooms.qrcode',$qrcode)->paginate();
        }
        return $rooms;
    }

    /**
     * Display the list rooms
     */
    public function getRoomByNumber($request){
        $data = $request->all();
        $room_number = isset($data['room_number']) ? $data['room_number'] : false;
        $rooms = Room::where('hotel_id', $request['hotel_id'])->where('room_number', $room_number)->first();
        return $rooms;
    }

    /**
     * Add new room
     * @param App\Http\Requests\RoomRequest $request The room's request
     */
    public function addRoom($request){
        return  Room::create($request);
    }

    /**
     * Find room by id
     * @param int $id The room's id
     */
    public function getRoom($id){
        return  Room::find($id);
    }

    /**
     * update a specified room
     * @param int $id The room's id
     * @param Illuminate\Http\Response $request The room's request
     */
    public function updateRoom($request,$id){
        $room = Room::find($id);
        $room->update($request->only( 'room_number','qrcode'));
        return $room;
    }

    /**
     * Delete room
     * @param int $id The room's id
     */
    public function deleteRoom($id){
        Room::destroy($id);
    }

    /**
     * Display the list rooms by hotel
     */
    public function getRoomsByHotel($request){
        $data = $request->all();
        //$hotel_id = isset($data['hotel_id']) ? $data['hotel_id'] : false;
        $hotel_id = Auth::user()->hotel_id;

        if($request->query('web')){
            $rooms = Room::where('hotel_id', $hotel_id)->where('del', 0)->get();
        }else{
            $rooms = Room::where('hotel_id', $hotel_id)->where('del', 0)->paginate();
        }
        return $rooms;

    }
}
