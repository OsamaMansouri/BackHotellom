<?php

namespace App\Http\Controllers;

use App\Http\Resources\MessageResource;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $messages = Message::with(['user', 'demmand'])->where('user_id',$user->id)->where('hotel_id', $user->hotel_id)->orderBy('id', 'DESC')->paginate(50);
        return MessageResource::collection($messages);
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
    public function store(Request $request)
    {
        $user = Auth::user();
        //$request['user_id'] = $user->id;
        $request['hotel_id'] = $user->hotel_id;
        $request['conversation_id'] = 1;

        $conversation = Conversation::where('user_id',$request['user_id'])->where('hotel_id', $user->hotel_id)->first();
        if(!$conversation){
            $conversation = Conversation::create(
                $request->only('room_id', 'user_id', 'hotel_id')
            );
        }
        $request['conversation_id'] = $conversation->id;
        $message = Message::create(
            $request->only('content', 'user_id', 'demmand_id', 'hotel_id', 'type', 'conversation_id', 'fromManager')
        );
        $st = 0;
        isset($request['fromManager']) ? $st = 1 : $st = 0;
        $conversation = Conversation::find($request['conversation_id']);
        $conversation->update(['status' => $st, 'room_id' => $request['room_id'], 'lastMsg' => $message->id]);
        if($request['fromManager'] == "1"){
            $this->sendManagerNotif($user->hotel_id, $user, $request['user_id'], $message);
        }else{
            $this->sendClientNotif($user->hotel_id,  $request['user_id'], $message);
        }

        return response(new MessageResource($message), Response::HTTP_CREATED);
    }

    public function getMessagesByConversation($conversation_id){
        $user = Auth::user();
        $conversation = Conversation::find($conversation_id);
        $conversation->update(['status' => 1]);
        $messages = Message::with(['user', 'demmand'])->where('conversation_id',$conversation_id)->where('hotel_id', $user->hotel_id)->orderBy('id', 'DESC')->paginate(50);
        return MessageResource::collection($messages);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }

    public function sendClientNotif($hotel_id, $user, $message)
    {
        $client = User::find($user);
        $users = User::with('modelHasRole.role')
                        ->whereHas('modelHasRole.role', function($q){
                                $q->where('name', Role::RECEPTIONIST)->orwhere('name', Role::HOUSEKEEPING);
                            })
                        ->where('hotel_id', $hotel_id)
                        ->where('connected', 1)
                        ->pluck('deviceToken');

        $notif = array(
            "title" => "New Message",
            "body" => "Guest : $client->name",
        );

        $data = array(
            "type" => "chat",
            "message" => new MessageResource($message)
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

    public function sendManagerNotif($hotel_id, $user, $client_id, $message)
    {
        $manager = User::find($user->id);
        $users = User::with('modelHasRole.role')
                        ->whereHas('modelHasRole.role', function($q){
                                $q->where('name', Role::CLIENT);
                            })
                        ->where('hotel_id', $hotel_id)
                        ->where('id', $client_id)
                        ->pluck('deviceToken');

        $notif = array(
            "title" => "New Message",
            "body" => "Guest : $manager->name",
        );

        $data = array(
            "type" => "chat",
            "message" => new MessageResource($message)
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
