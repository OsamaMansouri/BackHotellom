<?php


namespace App\Http\Controllers;


use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Statistique;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);die;
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    public function getRoomsByQrCode(){
        $rooms = Room::all();
        foreach ($rooms as $room){
            $qrCode = QrCode::size(300)
                ->format('png')
                ->generate(Room::getRoomByQrCode($room->qrcode));

            $output_file = '/AllRoomsByQrCode/'.$room->qrcode.'-'.$room->room_number.'.'.'png';
            Storage::disk('public')->put($output_file, $qrCode);

        }
        return response()->json($rooms);
       // return view('qrCode')->with(compact('rooms'));
    }

    public function getHotelDetailsByQrCode(){
        $rooms = Room::all();
        foreach ($rooms as $room){
            $qrCode = QrCode::size(300)
                ->format('png')
                ->generate(Hotel::getHotelDetails($room->qrcode));

            $output_file = '/HotelDetails/'.$room->qrcode.'-'.$room->room_number.'.'.'png';
            Storage::disk('public')->put($output_file, $qrCode);

        }
        return response()->json($rooms);
       // return view('hotelDetails')->with(compact('rooms'));
    }

    public function getApkURL(){

        return QrCode::generate("https://play.google.com/store/apps/details?id=com.canva.editor");
        /* return view('qrCode')->with(compact('rooms')); */
    }

    public function getStatistiques(Request $request){
        $hotel_id = $request->query('hotel_id');
        $statistique = Statistique::where('hotel_id', $hotel_id)->first();
        return $statistique;
    }

    public function sendLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user= User::where('email',$request->email)->first();


        if(!$user){
            $status = "You dont have an account with this mail";
        }else{
            Mail::to($request['email'])->send(new \App\Mail\ResetPassword($user,$request['email']));
            $status = "Please check your mail.";

        }

        return response($status);

    }

    public function editPassword($id)
    {
        $user= User::find($id);
        return view('emails.edit-password', compact('user',$user));

    }

    public function updatePassword(Request $request)
    {

        $user= User::where('email',$request->email)->first();
        $user->password = Hash::make($request->password);
        $user->update();

        $status = "You password has been updated successfully";
        return $status;
    }

}
