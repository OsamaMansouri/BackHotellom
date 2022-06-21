<?php


namespace App\Repositories;

use App\Models\ModelHasRole;
use App\Models\Role;
use App\Models\User;
use RKCreative\LaravelMesiboApi\MesiboApi;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class UserRepository
{
    /**
     * Display the list users
     */
    public function getUsers(){
        return User::paginate();
    }

    /**
     * Add new user
     * @param App\Http\Requests\UserRequest $request The user's request
     */
    public function addUser($request,$password){
        $request['password'] = bcrypt($password);
        return  User::create($request);
    }

    /**
     * Find user by id
     * @param int $id The user's id
     */
    public function getUser($id){
        return  User::find($id);
    }

    /**
     * update a specified user
     * @param int $id The user's id
     * @param App\Http\Requests\Request $request The user's request
     */
    public function updateUser($request,$id){
        $user = User::find($id);
        $image = $user->image;

        if ($request->hasFile('image')) {
            //$image = $request->file('image')->store('clients');
            $filenamewithextensiong = $request->file('image')->getClientOriginalName();
            $filenameg = pathinfo($filenamewithextensiong, PATHINFO_FILENAME);
            $extensiong = $request->file('image')->getClientOriginalExtension();
            $image = 'users/'. $filenameg.'_'.uniqid().'.'.$extensiong;
            Storage::disk('ftp')->put($image, fopen($request->file('image'), 'r+'));
        }

        $user->update(
            $request->only('firstname', 'lastname', 'email', 'phone_number', 'dateNaissance',
                            'gender', 'city', 'country', 'nationality', 'function', 'deviceToken')
                            + ['image' => $image]
        );
        return $user;
    }

    /**
     * update hotel id for a specified user
     * @param App\Http\Requests\Request $request The user's request
     */
    public function linkUserWithHotel($request){
        $userOh = Auth::user();
        $user_id = $userOh->id;
        $user = User::findOrFail($user_id);
        $experation_date = Carbon::now()->addDays($request['experation_date']);
        $user->hotel_id = $request['hotel_id'];
        //$user->deviceToken = $request['deviceToken'];
        $user->experation_date = $experation_date;
        $user->save();
        return $user;
    }

    /**
     * Delete user
     * @param int $id The user's id
     */
    public function deleteUser($id){
       return User::destroy($id);
    }

    /**
     * Get super admin user
     *
     */
    public function getSuperAdmin(){
        $modelHasRole = ModelHasRole::with(['role', 'user'])->whereHas('role', function($q){
            $q->where('name', Role::SUPER_ADMIN);
        })->first();
        $super_admin = $modelHasRole->user;
        return $super_admin;
    }

    /**
     * Add user to mesibo
     * @param App\Models\User $user The user object
     *
     */
    public function addUserToMesibo($user) {
        $messiboUser = Http::get(env('MESIBO_APP_URL'), [
            'token' => env('MESIBO_APP_TOKEN'),
            'op' => 'useradd',
            'addr' => $user->email,
            'appid' => env('MESIBO_CLIENT_ID')
        ]);
        $user->update([
            'mesibo_uid'    => $messiboUser["user"]["uid"],
            'mesibo_token'  => $messiboUser["user"]["token"]
        ]);
    }

    public function addClientToMesibo($user) {
        $messiboUser = Http::get(env('MESIBO_APP_URL'), [
            'token' => env('MESIBO_APP_TOKEN'),
            'op' => 'useradd',
            'addr' => $user->email,
            'appid' => env('MESIBO_HOTEL_ID')
        ]);
        $user->update([
            'mesibo_uid'    => $messiboUser["user"]["uid"],
            'mesibo_token'  => $messiboUser["user"]["token"]
        ]);
    }

    /**
     * Get staffs users of given hotel
     * @param int $hotel_id: The user's id
     *
     */
    public function getHotelStaffs($hotel_id)
    {
        $staffs = User::with('modelHasRole.role')->whereHas('modelHasRole.role', function($q){
            $q->whereIn('name', [Role::RECEPTIONIST, Role::ROOMS_SERVANT, Role::MANAGER, Role::HOUSEKEEPING]);
        })->where('hotel_id', $hotel_id)->where('del', 0)->get();
        return $staffs;
    }

    /**
     * Get staffs users of given hotel
     * @param int $hotel_id: The user's id
     *
     */
    public function nbrActiveUser($hotel_id)
    {
        $clients = User::with('modelHasRole.role')
                        ->whereHas('modelHasRole.role', function($q){
                                $q->where('name', Role::CLIENT);
                            })
                        ->where('hotel_id', $hotel_id)
                        ->whereNotNull('experation_date')
                        ->where('experation_date', '>=', date("Y-m-d h:i:s a", time()))
                        ->count();
        return $clients;
    }

    public function nbrActiveUserByMonth($hotel_id)
    {
        $clients = User::with('modelHasRole.role')
                        ->whereHas('modelHasRole.role', function($q){
                                $q->where('name', Role::CLIENT);
                            })
                        ->where('hotel_id', $hotel_id)
                        ->whereNotNull('experation_date')
                        ->whereRaw('MONTH(experation_date) = MONTH(CURRENT_TIMESTAMP)')
                        ->count();
        return $clients;
    }

    public function nbrActiveUserByWeek($hotel_id)
    {

        $clients = User::with('modelHasRole.role')
                        ->whereHas('modelHasRole.role', function($q){
                                $q->where('name', Role::CLIENT);
                            })
                        ->where('hotel_id', $hotel_id)
                        ->whereNotNull('experation_date')
                        ->whereRaw('WEEK(experation_date) = WEEK(CURRENT_TIMESTAMP)')
                        ->count();
        return $clients;
    }

    public function nbrActiveUserByYear($hotel_id)
    {

        $clients = User::with('modelHasRole.role')
                        ->whereHas('modelHasRole.role', function($q){
                                $q->where('name', Role::CLIENT);
                            })
                        ->where('hotel_id', $hotel_id)
                        ->whereNotNull('experation_date')
                        ->whereRaw('YEAR(experation_date) = YEAR(CURRENT_TIMESTAMP)')
                        ->count();
        return $clients;
    }
}
