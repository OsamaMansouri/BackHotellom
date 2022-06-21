<?php

namespace App\Http\Controllers;

use App\Events\UserHasRegistredEvent;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use App\Events\ActiveClientsEvent;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends BaseController
{
    // New Client Registration From Social Media And Normal Form
    /**
     * @api {post} /register New Client
     * @apiName  New Client
     * @apiGroup Register
     * @apiVersion 1.0.0
     *
     * @apiDescription  Add new client.
     *
     * @apiParam {String} email Client Email.
     * @apiParam {String} firstname Client Firstname.
     * @apiParam {String} lastname Client Lastname.
     * @apiParam {String} city Client City.
     * @apiParam {String} country Client Country.
     * @apiParam {String} nationality Client Nationality.
     * @apiParam {String} function Client Function.
     * @apiParam {String} gender Client Gender.
     * @apiParam {String} phone_number Client Phone.
     * @apiParam {String} password Client Password.
     * @apiParam {String} avatar Client Avatar.
     * @apiParam {String} socialID Client SocialID.
     *
     * @apiSuccess  {String{..255}}              email                           email of the client.
     * @apiSuccess  {String{..255}}              firstname                           firstname of the client.
     * @apiSuccess  {String{..255}}              lastname                           lastname of the client.
     * @apiSuccess  {String{..255}}              city                           city of the client.
     * @apiSuccess  {String{..255}}              country                           country of the client.
     * @apiSuccess  {String{..255}}              nationality                           nationality of the client.
     * @apiSuccess  {String{..255}}              function                           function of the client.
     * @apiSuccess  {String{..255}}              gender                           gender of the client.
     * @apiSuccess  {String{..255}}              phone_number                           phone_number of the client.
     * @apiSuccess  {String{..255}}              password                      password of the client.
     * @apiSuccess  {String{..255}}              avatar                      Avatar of the client.
     * @apiSuccess  {String{..255}}              socialID                      Socaile ID of the client.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     {
     *       "success": true,
     *       "data": {
     *           "token": "eyB3_erV3inoyqVd8rvNcTLMim6-wBRRHtB3fX6Qw",
     *           "name": "Eddine Salah",
     *           "user": {
     *               "email": "chehbi.se33c1@gmail.com",
     *               "firstname": "Salah",
     *               "lastname": "Eddine",
     *               "avatar": null,
     *               "phone_number": "065231456",
     *               "name": "Eddine Salah",
     *               "updated_at": "2022-01-08T17:44:34.000000Z",
     *               "created_at": "2022-01-08T17:44:34.000000Z",
     *               "id": 49,
     *               "roles": [
     *                   {
     *                       "id": 3,
     *                       "name": "client",
     *                       "guard_name": "web",
     *                       "created_at": null,
     *                       "updated_at": null,
     *                       "pivot": {
     *                           "model_id": 49,
     *                           "role_id": 3,
     *                           "model_type": "App\\Models\\User"
     *                       }
     *                   }
     *               ]
     *           }
     *       },
     *       "message": "User register successfully."
     *   }
     *}
     *
     */
    public function register(Request $request)
    {
        $data = $request->all();
        $provider = isset($data['source']) ? $data['source'] : false;
        $phone_number = isset($data['phone_number']) ? $data['phone_number'] : "";
        $data['phone_number'] = $phone_number;

        if (!$provider) {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6'
                //'password' => 'required|string|min:6|confirmed',
            ]);
            if ($validator->fails())
            {
                return response(['errors'=>$validator->errors()->all()], 422);
            }
        }

        if(in_array($provider, ['facebook', 'google', 'twitter'])) {

            $userSoc = User::whereSocialId($data['socialID'])->first();
            if (!$userSoc) {
                $data = [
                    'firstname' => $data['lastname'],
                    'lastname' => $data['firstname'],
                    'name' => $data['lastname'] . ' ' . $data['firstname'],
                    'email' => $data['email'],
                    'password' => encrypt($data['socialID']),
                    'social_id' => $data['socialID'],
                    'avatar' => $data['avatar']
                ];
                $user = User::create($data);
               /*  $user->hotel_id = 2;
                $user->save(); */
                // Event/Listener To Notify Hotel Admin About New Client Registration And Add The New Client To Mesibo API
                UserHasRegistredEvent::dispatch($user);
                Log::channel('users')->info('new user has benn added');
                $user->assignRole(['client']);
                $success['token'] = $user->createToken('MyApp')->accessToken;
                $success['name'] = $user->name;
                $success['user'] =  new UserResource($user);
                return $this->sendResponse($success, 'User register successfully.');
            } else {
                $success['token'] = $userSoc->createToken('MyApp')->accessToken;
                $success['name'] = $userSoc->name;
                $success['user'] = $userSoc;
                return $this->sendResponse($success, 'User login successfully.');
            }
        }

        if (!$provider) {
            $data['password'] = bcrypt($data['password']);
            $data['name'] = $data['lastname'] . ' ' . $data['firstname'];
        }

        $userExist = User::whereEmail($data['email'])->first();
        if(!$userExist) {
            $user = User::create($data);
            /* $user->hotel_id = 2;
            $user->save(); */
            if ($user) {
                // Event/Listener To Notify Hotel Admin About New Client Registration And Add The New Client To Mesibo API
                UserHasRegistredEvent::dispatch($user);
                Log::channel('users')->info('new user has benn added');
                $user->assignRole(['client']);
                $success['token'] = $user->createToken('MyApp')->accessToken;
                $success['name'] = $user->name;
                $success['user'] =  new UserResource($user);
                return $this->sendResponse($success, 'User register successfully.');
            }
            return $this->sendError('Server error.', ['error'=>'User not created']);

        }else {
            return $this->sendError('Server error.', ['error'=>'User already exists']);
        }
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $data = $request->all();
        $provider = isset($data['source']) ? $data['source'] : false;

        if(in_array($provider, ['facebook', 'google', 'twitter'])) {
            $user = User::whereSocialId($data['socialID'])->first();
            if ($user) {
                $success['token'] = $user->createToken('MyApp')->accessToken;
                $success['name'] = $user->name;
                $success['user'] = new UserResource($user);
                return $this->sendResponse($success, 'Utilisateur est .');
            } else {
                $userExist = User::whereEmail($data['email'])->first();
                if(!$userExist) {
                    $data = [
                        'firstname' => $data['lastname'],
                        'lastname' => $data['firstname'],
                        'name' => $data['lastname'] . ' ' . $data['firstname'],
                        'email' => $data['email'],
                        'password' => encrypt($data['socialID']),
                        'social_id' => $data['socialID'],
                        'avatar' => $data['avatar']
                    ];
                    $user = User::create($data);
                    if ($user) {
                        // Event/Listener To Notify Hotel Admin About New Client Registration And Add The New Client To Mesibo API
                        UserHasRegistredEvent::dispatch($user);
                        Log::channel('users')->info('new user has benn added');
                        $user->assignRole(['client']);
                        $success['token'] = $user->createToken('MyApp')->accessToken;
                        $success['name'] = $user->name;
                        $success['user'] =  new UserResource($user);
                        return $this->sendResponse($success, 'User register successfully.');
                    }
                    return $this->sendError('Server error.', ['error'=>'User not created']);

                }else {
                    return $this->sendError('Server error.', ['error'=>'User already exists']);
                }
            }
        }

        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        // If User Login Successfully
        if(Auth::attempt($loginData)){
            $user = new UserResource(User::find(Auth::id()));

            //event(new ActiveClientsEvent($user['hotel_id']));

            $user['ability'] = [
                 'action' => 'manage',
                 'subject' => 'all',
            ];
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $success['name'] =  $user->name;
            $success['user'] =  new UserResource($user);

            return $this->sendResponse($success, 'User login successfully.');
        }

        return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);

    }

    public function loginStandar(Request $request){

        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        // If User Login Successfully
        $user = User::with('modelHasRole.role')
                        ->whereHas('modelHasRole.role', function($q){
                                $q->where('name', Role::ROOMS_SERVANT)->orWhere('name', Role::RECEPTIONIST);
                            })
                        ->where('email', $request->email)
                        ->first();

        if($user){
            if(Hash::check($request->password, $user->password)){
                $user->update(['connected' => 1]);
                $user = new UserResource(User::find($user->id));

                $success['token'] =  $user->createToken('MyApp')->accessToken;
                $success['name'] =  $user->name;
                $success['user'] =  $user;

                return $this->sendResponse($success, 'User login successfully.');
            }
        }

        return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
    }

    public function logoutStandar(){

        $user = Auth::user();
        $user->tokens->each(function($token, $key) {
            $token->delete();
        });
        $user = User::find($user->id);
        $user->update(["connected" => 0]);
        if($user){
            return $this->sendResponse("True", 'User logout successfully.');
        }

        return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
    }

    public function registerOld(Request $request)
    {
        $data = $request->all();
        $resource = isset($data['resource']) ? $data['resource'] : false;
        $token = isset($data['token']) ? $data['token'] : false;
        $secret = isset($data['secret']) ? $data['secret'] : false;
        $phone_number = isset($data['phone_number']) ? $data['phone_number'] : "";

        if (!$resource) {
            $data['password'] = bcrypt($data['password']);
            $data['name'] = $data['lastname'] . ' ' . $data['firstname'];
        }

        // facebook callback
        if($resource == 'facebook'){
            $userProfile = $this->facebookCallback($token);
            $user = User::whereSocialId($userProfile->id)->first();
            if (!$user) {
                $fullname = explode(' ', $userProfile->name);
                $firstname = $fullname[0];
                $lastname = $fullname[1];
                $username = [
                    'firstname' => $firstname,
                    'lastname' => $lastname
                ] ;
                $data = [
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'name' => $userProfile->name,
                    'email' => $userProfile->email,
                    'password' => encrypt($userProfile->email),
                    'social_id' => $userProfile->id,
                    'avatar' => $data['avatar'],
                    'phone_number' => $phone_number
                ];
            } else {
                $success['token'] = $user->createToken('MyApp')->accessToken;
                $success['name'] = $user->name;
                $success['user'] = $user;

                return $this->sendResponse($success, 'User login successfully.');
            }

        }
        // google callback
        if($resource == 'google') {
            //$userProfile = $this->googleCallBack($token);
            $social_id = '';
            $social_id = $data['social_id'];
            $user = User::whereSocialId($social_id)->first();
            if (!$user) {
                $firstname = $data['firstName'];
                $lastname = $data['lastName'];
                $name = $data['name'];
                $email = $data['email'];
                $data = [
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'name' => $name,
                    'email' => $email,
                    'password' => encrypt($email),
                    'social_id' => $social_id,
                    'avatar' => $data['avatar'],
                    'phone_number' => $phone_number
                ];
            } else {
                $success['token'] = $user->createToken('MyApp')->accessToken;
                $success['name'] = $user->name;
                $success['user'] = $user;

                return $this->sendResponse($success, 'User login successfully.');
            }

        }
        // twitter callback
        if($resource == 'twitter') {
            $userProfile = $this->twitterCallBack($token, $secret);
            //dd($userProfile);
            $user = User::whereSocialId($userProfile->id)->first();
            if (!$user) {
                $firstname = '';
                $lastname = '';
                if(preg_match('/\s/',$userProfile->name)){
                    $fullname = explode(' ', $userProfile->name);
                    $firstname = $fullname[0];
                    $lastname = $fullname[1];
                }
                $email = $userProfile->email ? $userProfile->email : '';
                $username = [
                    'firstname' => $firstname,
                    'lastname' => $lastname
                ] ;
                $data = [
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'name' => $userProfile->name,
                    'email' => $email,
                    'password' => encrypt($userProfile->email),
                    'social_id' => $userProfile->id,
                    'avatar' => $data['avatar'],
                    'phone_number' => $phone_number
                ];
            } else {
                $success['token'] = $user->createToken('MyApp')->accessToken;
                $success['name'] = $user->name;
                $success['user'] = $user;

                return $this->sendResponse($success, 'User login successfully.');
            }

        }

        $userTest = User::whereEmail($data['email'])->first();
        if(!$userTest){
            $user = User::create($data);
            if ($user) {
                // Event/Listener To Notify Hotel Admin About New Client Registration And Add The New Client To Mesibo API
                UserHasRegistredEvent::dispatch($user);
                Log::channel('users')->info('new user has benn added');
                $user->assignRole(['client']);
                $success['token'] = $user->createToken('MyApp')->accessToken;
                $success['name'] = $user->name;
                $success['user'] =  $user;
                return $this->sendResponse($success, 'User register successfully.');
            }
            return $this->sendError('Server error.', ['error'=>'Server error']);
        }else{
            return $this->sendError('Server error.', ['error'=>'User Already Exists']);
        }
    }

    /**
     * Get user data from facebbok callback
     * @param $token
     * @return \Illuminate\Http\Response
     */
    public function facebookCallback($token){

        $profile = Socialite::driver('facebook')->userFromToken($token);
        return $profile;
    }

    /**
     * Get user data from google callback
     * @param $token
     * @return \Illuminate\Http\Response
     */
    public function googleCallBack($token){

        $profile =  Socialite::driver('google')->userFromToken($token);
        return $profile;

    }

    /**
     * Get user data from github callback
     * @param $token
     * @return \Illuminate\Http\Response
     */
    public function githubCallBack($token){

        $profile = Socialite::driver('github')->userFromToken($token);
        return $profile;

    }
    /**
     * Get user data from twitter callback
     * @param $token
     * @param $secret
     * @return \Illuminate\Http\Response
     */
    public function twitterCallBack($token, $secret){

        $profile = Socialite::driver('twitter')->userFromTokenAndSecret($token, $secret);
        return $profile;

    }
}
