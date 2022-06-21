<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomRequest;
use App\Http\Resources\RoomResource;
use App\Models\Room;
use App\Repositories\RoomRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Symfony\Component\HttpFoundation\Response;

class RoomController extends Controller
{
    private $roomRepository;

    public function __construct(RoomRepository $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }
    /**
     * @api {get} /rooms List of rooms
     * @apiName rooms_index
     * @apiGroup rooms
     * @apiVersion 1.0.0
     *
     * @apiDescription  List all rooms. It is possible to add some filters for more accuracy.
     *
     * @apiSuccess  {unsignedBigInteger}         hotel_id                      hotel_id of the room.
     * @apiSuccess  {Integer}                    room_number                   room_number the room.
     * @apiSuccess  {String{..150}}              qrcode                        qrcode of the room.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "hotel_id": 1,
     *        "room_number": 1,
     *        "qrcode": "url",
     *      }
     *  ]
     *}
     */
    public function index(Request $request)
    {
        $rooms = $this->roomRepository->getRooms($request);
        return RoomResource::collection($rooms);
    }

    /**
     * @api {post} /rooms New room
     * @apiName New room
     * @apiGroup rooms
     * @apiVersion 1.0.0
     *
     * @apiDescription  Add new Room.
     *
     * @apiSuccess  {unsignedBigInteger}         hotel_id                      hotel_id of the room.
     * @apiSuccess  {Integer}                    room_number                   room_number the room.
     * @apiSuccess  {String{..150}}              qrcode                        qrcode of the room.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "hotel_id": 1,
     *        "room_number": 1,
     *        "qrcode": "url",
     *      }
     *  ]
     *}
     */
    public function store(RoomRequest $request)
    {
        $rooms = $this->roomRepository->addRoom($request);
        return response(new RoomResource($rooms), Response::HTTP_CREATED);
    }

    /**
     * @api {get} /rooms/1 Show a room
     * @apiName Show a room
     * @apiGroup rooms
     * @apiVersion 1.0.0
     *
     * @apiDescription  Show a Room.
     *
     * @apiSuccess  {unsignedBigInteger}         hotel_id                      hotel_id of the room.
     * @apiSuccess  {Integer}                    room_number                   room_number the room.
     * @apiSuccess  {String{..150}}              qrcode                        qrcode of the room.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "hotel_id": 1,
     *        "room_number": 1,
     *        "qrcode": "url",
     *      }
     *  ]
     *}
     */
    public function show($id)
    {
        $room = $this->roomRepository->getRoom($id);
        return new RoomResource($room);
    }

    /**
     * @api {put} /rooms/1 Update room
     * @apiName Update room
     * @apiGroup rooms
     * @apiVersion 1.0.0
     *
     * @apiDescription  Update Room.
     *
     * @apiSuccess  {unsignedBigInteger}         hotel_id                      hotel_id of the general settings.
     * @apiSuccess  {Integer}                    room_number                   room_number the room.
     * @apiSuccess  {String{..150}}              qrcode                        qrcode of the room.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "hotel_id": 1,
     *        "room_number": 1,
     *        "qrcode": "url",
     *      }
     *  ]
     *}
     */
    public function update(Request $request, $id)
    {
        $room = $this->roomRepository->updateRoom($request,$id);
        return response(new RoomResource($room), Response::HTTP_CREATED);
    }

    /**
     * @api {delete} /rooms/1 Delete a room
     * @apiName Delete a room
     * @apiGroup rooms
     * @apiVersion 1.0.0
     *
     * @apiDescription  Delete a room.
     *
     * @apiSuccess  {unsignedBigInteger}         hotel_id                      hotel_id of the room.
     * @apiSuccess  {Integer}                    room_number                   room_number the room.
     * @apiSuccess  {String{..150}}              qrcode                        qrcode of the room.
     *
     * @apiSuccessExample {json} Success example
     * 1
     *
     */
    public function destroy($id)
    {
        //$this->roomRepository->deleteRoom($id);
        $room = Room::find($id);
        $room->del = 1;
        $room->save();
        return  \response(null, Response::HTTP_NO_CONTENT);
    }

    public function scanQrCode(Request $request){

        foreach ($request['rooms'] as $room){

           $qrCode = QrCode::size(300)
                ->format('png')
                ->generate(Room::getRoomByQrCode($room['qrcode']));


            $file_name = $room['qrcode'].'-'.$room['room_number'].'.'.'png';
            Storage::disk('public')->put('/RoomsByQrCode/'.$file_name, $qrCode);
            $url = asset(config('app.img_url').$file_name);
            $result[] = ['room_number' => $room['id'] , 'qrCode' => $room['qrcode'],'url' =>$url];
        }
        return response()->json($result);

    }

    /**
     * @api {get} /getRoomsByHotel/1 Show a room
     * @apiName Show Rooms By Hotel
     * @apiGroup rooms
     * @apiVersion 1.0.0
     *
     * @apiDescription  Show Rooms By Hotel.
     *
     * @apiSuccess  {unsignedBigInteger}         hotel_id                      hotel_id of the room.
     * @apiSuccess  {Integer}                    room_number                   room_number the room.
     * @apiSuccess  {String{..150}}              qrcode                        qrcode of the room.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "hotel_id": 1,
     *        "room_number": 1,
     *        "qrcode": "url",
     *      }
     *  ]
     *}
     */
    public function getRoomsByHotel(Request $request)
    {
        $rooms = $this->roomRepository->getRoomsByHotel($request);
        return RoomResource::collection($rooms);

    }
}
