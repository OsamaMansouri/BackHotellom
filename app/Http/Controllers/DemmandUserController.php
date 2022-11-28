<?php

namespace App\Http\Controllers;

use App\Http\Requests\DemmandUserRequest;
use App\Http\Resources\DemmandUserResource;
use App\Models\DemmandUser;
use App\Models\Role;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DemmandUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $hotel_id = Auth::user()->hotel_id;
        $demmandUsers = DemmandUser::with('demmand')->whereHas('demmand')->join('demmands','demmands.id','=','demmand_users.demmand_id')->join('request_hotels','request_hotels.demmand_id','=','demmands.id')->where('request_hotels.hotel_id',$hotel_id)->orderBy('demmand_users.id', 'DESC');

        if($request->query('web')){
            return DemmandUserResource::collection($demmandUsers->get());
        }else{
            return DemmandUserResource::collection($demmandUsers->paginate());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DemmandUserRequest $request)
    {
        $request['user_id'] = Auth::user()->id;
        $demmand = DemmandUser::create(
            $request->only('message', 'user_id', 'demmand_id', 'option_id', 'room_id')
            + ['status' => 'pending']
        );

        $this->sendNotif(Auth::user()->hotel_id, $request['user_id'], $request['room_id']);

        return response(new DemmandUserResource($demmand), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DemmandUser  $demmandUser
     * @return \Illuminate\Http\Response
     */
    public function show(DemmandUser $demmandUser)
    {
        return response(new DemmandUserResource($demmandUser), Response::HTTP_CREATED);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DemmandUser  $demmandUser
     * @return \Illuminate\Http\Response
     */
    public function edit(DemmandUser $demmandUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DemmandUser  $demmandUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DemmandUser $demmandUser)
    {
        $request['done_by'] = Auth::user()->id;
        $request['status'] = "done";
        $demmandUser->update($request->only('status', 'done_by'));
        return response(new DemmandUserResource($demmandUser), Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DemmandUser  $demmandUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(DemmandUser $demmandUser)
    {
        return DemmandUser::destroy($demmandUser->id);
    }

    public function sendNotif($hotel_id, $user, $room)
    {
        $client = User::find($user);
        $room = Room::find($room);
        $users = User::with('modelHasRole.role')
                        ->whereHas('modelHasRole.role', function($q){
                                $q->where('name', Role::RECEPTIONIST)->orwhere('name', Role::HOUSEKEEPING);
                            })
                        ->where('hotel_id', $hotel_id)
                        ->where('connected', 1)
                        ->pluck('deviceToken');

        $notif = array(
            "title" => "New Request",
            "body" => "Room : $room->room_number, Client : $client->name",
        );

        $data = array(
            "type" => "notif_request"
        );

        $apiKey = env('FIREBASE_API_KEY');

        $fields = json_encode(array('registration_ids'=> $users, 'notification'=>$notif, 'data'=>$data));

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ($fields));

        $headers = array();
        $headers[] = 'Authorization: key='. $apiKey;
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
    }
}
