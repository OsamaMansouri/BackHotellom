<?php

namespace App\Http\Controllers;

use App\Events\UserHasBeenAddedEvent;
use App\Events\UserPassHasBeenUpdatedEvent;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\DefaultLicence;
use App\Models\Permission;
use App\Models\Room;
use App\Models\User;
use App\Models\Hotel;
use App\Models\ModelHasRole;
use App\Models\GeneralSetting;
use App\Models\Statistique;
use App\Repositories\HotelRepository;
use App\Repositories\LicenceRepository;
use App\Repositories\ProlongationRepository;
use App\Repositories\RoomRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Events\StatistiqueUpdateEvent;
use App\Http\Resources\UserApiResource;
use App\Models\Role;
use App\Models\Type;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use function Psy\debug;

class UserController extends BaseController
{

    private $userRepository;

    private $hotelRepository;

    private $licenceRepository;

    private $roomRepository;

    public function __construct(UserRepository $userRepository,HotelRepository $hotelRepository, RoomRepository $roomRepository, LicenceRepository $licenceRepository)
    {
        $this->userRepository   = $userRepository;
        $this->hotelRepository   = $hotelRepository;
        $this->licenceRepository = $licenceRepository;
        $this->roomRepository    = $roomRepository;
    }

    /**
     * @api {get} /users List of users
     * @apiName users_index
     * @apiGroup Users
     * @apiVersion 1.0.0
     *
     * @apiDescription  List all users. It is possible to add some filters for more accuracy.
     *
     * @apiSuccess  {String{..150}}              firstname                     firstname of the user.
     * @apiSuccess  {String{..150}}              lastname                      lastname of the user.
     * @apiSuccess  {String{..150}}              email                         email of the user.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "firstname": "Azzeddine",
     *        "lastname": "Lubowitz",
     *        "email": "usern@gmail.com",
     *        "role": {
     *        "id": 1,
     *        "name": "User",
     *        "created_at": "2021-04-06T11:52:39.000000Z",
     *        "updated_at": "2021-04-06T11:52:39.000000Z"
     *      }
     *  ]
     *}
     */
    public function index(Request $request)
    {
        if ($request->has('hotel_id')) {
            $hotel_id = $request->query('hotel_id');
            $users = $this->userRepository->getHotelStaffs($hotel_id);
        } else {
            $users = $this->userRepository->getUsers();
        }

        return UserResource::collection($users);
    }

    /**
     * @api {post} /users New user
     * @apiName New user
     * @apiGroup Users
     * @apiVersion 1.0.0
     *
     * @apiDescription  Add new user.
     *
     * @apiSuccess  {String{..150}}              firstname                     firstname of the user.
     * @apiSuccess  {String{..150}}              lastname                      lastname of the user.
     * @apiSuccess  {String{..150}}              email                         email of the user.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "firstname": "Azzeddine",
     *        "lastname": "Lubowitz",
     *        "email": "usern@gmail.com",
     *        "role": {
     *        "id": 1,
     *        "name": "User",
     *        "created_at": "2021-04-06T11:52:39.000000Z",
     *        "updated_at": "2021-04-06T11:52:39.000000Z"
     *      }
     *  ]
     *}
     */
    public function store(UserRequest $request)
    {
        $isHotel = $request->source ? true : false;

        if ($isHotel) {
            $lastHotelId = Hotel::orderby('id','DESC')->first();
            $request['hotelFormData'] = array_merge($request['hotelFormData'],
                [
                    'status'  => "active",
                    'country' => "Morocco",
                    'reference' => $lastHotelId->id + 106,
                    'code' => $this->generateRandomString() . ($lastHotelId->id + 106)
                ]
            );
            $hotel = $this->hotelRepository->addHotel($request['hotelFormData']);    // Create Hotel

            if ($hotel) {
                //Generate QR-Code For Hotel
                $file = QrCode::format('png')->size(399)->color(40,40,40)->generate(Hotel::where('id', $hotel->id)->get(['id','name']));
                //$imageName = 'hotel-'. $hotel->reference .'.png';
                //Storage::disk('hotels')->put($imageName, $file);
                $imageName = 'hotels/hotel-'. $hotel->reference .'.png';
                Storage::disk('ftp')->put($imageName, $file);
                // Add Hotel To Mesibo
                $messiboUser = Http::get(env('MESIBO_APP_URL'), [
                    'token' => env('MESIBO_APP_TOKEN'),
                    'op' => 'useradd',
                    'addr' => $hotel->id,
                    'appid' => env('MESIBO_APP_ID')
                ]);
                $hotel->update([
                    'mesibo_uid'    => $messiboUser["user"]["uid"],
                    'mesibo_token'  => $messiboUser["user"]["token"]
                ]);
                // Create General Setting Table
                GeneralSetting::create(['hotel_id' =>  $hotel->id, 'tax' =>  20, 'timer' =>  10, 'licence_days' => 30]);
                // Create Statistique Table
                Statistique::create(['hotel_id' =>  $hotel->id]);
                // Create Default Room Service Type For Hotel
                //Type::create(['hotel_id' => $hotel->id, 'name' => 'Room Service', 'gold_img' => 'types/ROOM SERVICE_61d2ef1927547.png', 'purple_img' => 'types/ROOM SERVICE_61d2ef1928fa1.png' ]);
                $password = Str::random('8');
                // Create User
                $user = $this->userRepository->addUser($request->all(), $password);
                if ($user){
                    $user->hotel()->associate($hotel);
                    $user->assignRole(['admin']);
                    $user->givePermissionTo(Permission::DEFAULT_PERMISSIONS);
                    // Event/Listener To Notify Super Admin About New Hotel Registration And Send Email To User With Welcome Message And password
                    UserHasBeenAddedEvent::dispatch($user, $password);
                    // Log
                    Log::channel('users')->info("new user has benn added $user->id");
                } else {
                    //Exception
                }

                /* if ($request['hotelStaffs']) {
                    // Add the receptionist
                    if ($request['hotelStaffs']['receptionist_email']) {
                        $password = Str::random('8');
                        $data = [
                            'email' => $request['hotelStaffs']['receptionist_email']
                        ];
                        $receptionist_user = $this->userRepository->addUser($data, $password);
                        $receptionist_user->assignRole(['receptionist']);
                        $receptionist_user->hotel()->associate($hotel);
                        UserHasBeenAddedEvent::dispatch($receptionist_user, $password);
                    }
                    // Add the receptionist
                    if ($request['hotelStaffs']['room_services_email']) {
                        $password = Str::random('8');
                        $data = [
                            'email' => $request['hotelStaffs']['room_services_email']
                        ];
                        $room_services_user = $this->userRepository->addUser($data, $password);
                        $room_services_user->assignRole(['rooms-servant']);
                        $room_services_user->hotel()->associate($hotel);
                        UserHasBeenAddedEvent::dispatch($room_services_user, $password);
                    }
                } */

                //Create Rooms
                foreach ($request['roomsData'] as $room) {
                    $qrcode = Room::newQrCode();
                    $roomData = [
                        'hotel_id'    => $hotel->id,
                        'room_number' => $room['number'],
                        'qrcode'      => $qrcode
                    ];
                    if ($room['number']) {
                        $this->roomRepository->addRoom($roomData);
                    }

                }

                //Create Licence
                $licenceDays = DefaultLicence::getLicenceDays();
                $now = Carbon::now();
                $curentDate = $now->toDateTimeString();
                $endDate = $now->addDays($licenceDays)->toDateTimeString();
                $licence = [
                    'hotel_id'   => $hotel->id,
                    'startDate'  => $curentDate,
                    'endDate'    => $endDate
                ];

                $this->licenceRepository->addLicence($licence);
            } else {
                //Exception
            }
        }

        return response(new UserResource($user), Response::HTTP_CREATED);
    }

    /**
     * @api {get} /users/1 Show a user
     * @apiName Show a user
     * @apiGroup Users
     * @apiVersion 1.0.0
     *
     * @apiDescription  Show a user.
     *
     * @apiSuccess  {String{..150}}              firstname                     firstname of the user.
     * @apiSuccess  {String{..150}}              lastname                      lastname of the user.
     * @apiSuccess  {String{..150}}              email                         email of the user.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "firstname": "Azzeddine",
     *        "lastname": "Lubowitz",
     *        "email": "usern@gmail.com",
     *        "role": {
     *        "id": 1,
     *        "name": "User",
     *        "created_at": "2021-04-06T11:52:39.000000Z",
     *        "updated_at": "2021-04-06T11:52:39.000000Z"
     *      }
     *  ]
     *}
     */
    public function show($id)
    {
        $user = $this->userRepository->getUser($id);
        return new UserResource($user);
    }

    /**
     * @api {put} /users/1 Update user
     * @apiName Update a user
     * @apiGroup Users
     * @apiVersion 1.0.0
     *
     * @apiDescription  Update user.
     *
     * @apiSuccess  {String{..150}}              firstname                     firstname of the user.
     * @apiSuccess  {String{..150}}              lastname                      lastname of the user.
     * @apiSuccess  {String{..150}}              email                         email of the user.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "firstname": "Azzeddine",
     *        "lastname": "Lubowitz",
     *        "email": "usern@gmail.com",
     *        "role": {
     *        "id": 1,
     *        "name": "User",
     *        "created_at": "2021-04-06T11:52:39.000000Z",
     *        "updated_at": "2021-04-06T11:52:39.000000Z"
     *      }
     *  ]
     *}
     */
    public function update(Request $request, $id)
    {
        $user = $this->userRepository->updateUser($request,$id);
        return response(new UserResource($user), Response::HTTP_CREATED);
    }

    public function linkUserWithHotel(Request $request)
    {
        $hotel = $this->hotelRepository->getHotelByCode(strtolower($request['code']));
        if(!$hotel){
            return $this->sendError('Error.', ['error'=>'Please Check Your Hotel Code']);
        } else {

            $request['hotel_id'] = $hotel->id;
            // Get Room By Room_Number
            $room = $this->roomRepository->getRoomByNumber($request);
            if(!$room){
                return $this->sendError('Error.', ['error'=>'The Room Number Does Not Exist']);
            } else {
                // Link User With Hotel
                $user = $this->userRepository->linkUserWithHotel($request);
                $success['user'] = new UserResource($user);
                $success['room'] =  $room;
                return response($success, Response::HTTP_CREATED);
            }
        }

    }

    /**
     * @api {delete} /users/1 Delete user
     * @apiName  Delete user
     * @apiGroup Users
     * @apiVersion 1.0.0
     *
     * @apiDescription  Delete user.
     *
     * @apiSuccess  {String{..150}}              firstname                     firstname of the user.
     * @apiSuccess  {String{..150}}              lastname                      lastname of the user.
     * @apiSuccess  {String{..150}}              email                         email of the user.
     *
     * @apiSuccessExample {json} Success example
     * 1
     *
     */
    public function destroy($id)
    {

        $user = User::find($id);
        if($user)
        {
            $user->delete();
            return response()->json([
                'status' => 200,
                'message' => 'user Deleted Successfully',
            ]);
        }
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            $success['name'] =  $user->name;

            return $this->sendResponse($success, 'User login successfully.');
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function nbrActiveUser(Request $request)
    {
        $hotel_id = $request->query('hotel_id');
        // Get Active Client Count
        $users = $this->userRepository->nbrActiveUser($hotel_id);
        return $users;
    }

    public function addStaff(UserRequest $request)
    {
        $password = Str::random('8');
        $role = $request['role'] == "0" ? "receptionist" : $request['role'];
        $user = User::create(['name' => $request['name'],'email' => $request['email'],'password' => bcrypt($password),'etat' => $request['etat']]);
        $user->hotel_id = Auth::user()->hotel_id;
        $user->save();
        $user->assignRole([$role]);

        UserHasBeenAddedEvent::dispatch($user, $password);

        return response(new UserResource($user), Response::HTTP_CREATED);
    }

    public function addManager(UserRequest $request)
    {
        $password = Str::random('8');
        $user = User::create(['name' => $request['name'],'email' => $request['email'],'password' => bcrypt($password),'etat' => 'active','is_manager' => 1]);
        $user->hotel_id = $request['hotel_id'];
        $user->save();
        $user->assignRole(["admin"]);
        $user->givePermissionTo(Permission::DEFAULT_PERMISSIONS);

        UserHasBeenAddedEvent::dispatch($user, $password);

        return response(new UserResource($user), Response::HTTP_CREATED);
    }


    public function updateStaff(Request $request)
    {
        $user = User::find($request['user_id']);
        $role = $request['role'] == "" ? "4" : $request['role'];
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->etat = $request['etat'];
        $user->save();
        ModelHasRole::where('model_id',$request['user_id'])->delete();
        ModelHasRole::create(['model_id' => $user->id, 'role_id' => $role, 'model_type' => 'App\Models\User']);

        return response(new UserResource($user), Response::HTTP_CREATED);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $user = User::findOrFail($user->id);
        $user->firstname = $request['firstname'];
        $user->lastname = $request['lastname'];
        $user->name = $request['firstname'] . ' ' . $request['lastname'];
        $user->email = $request['email'];
        $user->phone_number = $request['phone_number'];
        $user->save();

        return response(new UserResource($user), Response::HTTP_CREATED);
    }

    public function resetPassStaff(Request $request)
    {
        $user = User::find($request['user_id']);
        $password = Str::random('8');
        $user->password = $password;
        $user->save();

        UserPassHasBeenUpdatedEvent::dispatch($user, $password);

        return response(new UserResource($user), Response::HTTP_CREATED);
    }

    public function archiveStaff($id)
    {
        dd($id);
        $user = User::find($request['user_id']);
        $user->del = 1;
        $user->save();

        return response(new UserResource($user), Response::HTTP_CREATED);
    }

    public function registerHotel(UserRequest $request)
    {
        $data = $request->all();
        $lastHotelId = Hotel::orderby('id','DESC')->first();

        $data = [
            'name' => $data['name'],
            'email' => $data['email'],
            'rc' => $data['rc'],
            'ice' => $data['ice'],
            'if' => $data['if'],
            'rib' => $data['rib'],
            'address' => $data['address'],
            'city' => $data['city'],
            'status'  => "active",
            'country' => "Morocco",
            'reference' => $lastHotelId->id + 106,
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email']
        ];

        $hotel = $this->hotelRepository->addHotel($data);    // Create Hotel

        if ($hotel) {

            //Generate QR-Code For Hotel
            /* $file = QrCode::format('png')->size(399)->color(40,40,40)->generate(Hotel::where('id', $hotel->id)->get(['id','name']));
            $imageName = 'hotels/hotel-'. $hotel->reference .'.png';
            Storage::disk('ftp')->put($imageName, $file); */

            // Add Hotel To Mesibo
            $messiboUser = Http::get(env('MESIBO_APP_URL'), [
                'token' => env('MESIBO_APP_TOKEN'),
                'op' => 'useradd',
                'addr' => $hotel->id,
                'appid' => env('MESIBO_APP_ID')
            ]);
            $hotel->update([
                'mesibo_uid'    => $messiboUser["user"]["uid"],
                'mesibo_token'  => $messiboUser["user"]["token"]
            ]);

            // Create General Setting Table
            GeneralSetting::create(['hotel_id' =>  $hotel->id, 'tax' =>  20, 'timer' =>  10, 'licence_days' => 30]);

            // Create Statistique Table
            Statistique::create(['hotel_id' =>  $hotel->id]);
            $password = encrypt($request['password']);
            // Create User
            $data = [
                'email' => $data['email'],
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'name' => $data['lastname'] . ' ' . $data['firstname'],
            ];
            $user = $this->userRepository->addUser($data, $password);
            if ($user){
                $user->hotel()->associate($hotel);
                $user->assignRole(['admin']);
                $user->givePermissionTo(Permission::DEFAULT_PERMISSIONS);
                // Event/Listener To Notify Super Admin About New Hotel Registration And Send Email To User With Welcome Message And password
                UserHasBeenAddedEvent::dispatch($user, $request['password']);
                // Log
                Log::channel('users')->info("new user has benn added $user->id");
            } else {
                //Exception
            }

            //Create Licence
            $licenceDays = DefaultLicence::getLicenceDays();
            $now = Carbon::now();
            $curentDate = $now->toDateTimeString();
            $endDate = $now->addDays($licenceDays)->toDateTimeString();
            $licence = [
                'hotel_id'   => $hotel->id,
                'startDate'  => $curentDate,
                'endDate'    => $endDate
            ];

            $this->licenceRepository->addLicence($licence);
        } else {
            //Exception
        }

        return response(new UserResource($user), Response::HTTP_CREATED);
    }

    public function getActiveHotelUsers($role){

        $hotel_id = Auth::user()->hotel_id;
        $query = User::with('modelHasRole.role');
        if ($role === 'room'){
            $query->whereHas('modelHasRole.role', function($q){
                $q->where('name', Role::ROOMS_SERVANT);
            });
        } else {
            $query->whereHas('modelHasRole.role', function($q){
                $q->where('name', Role::RECEPTIONIST);
            });
        }
        $users = $query->where('hotel_id', $hotel_id)->where('connected', 1)->get();
        return UserApiResource::collection($users);
    }

    public function getHotellomManagers(){
        $users = User::where('is_manager', 1)->get();
        return UserResource::collection($users);
    }

    public function generateRandomString() {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 2; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
