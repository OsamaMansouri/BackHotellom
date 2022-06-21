<?php


namespace App\Repositories;

use App\Models\Hotel;

class HotelRepository
{
    /**
     * Display the list hotels
     */
    public function getHotels($request){
        if($request->query('web')){
            return Hotel::where('id', '>', 1)->get();
        }else{
            return Hotel::where('id', '>', 1)->paginate();
        }
    }

    /**
     * Add new hotel
     * @param App\Http\Requests\HotelRequest $request The hotel's request
     */
    public function addHotel($request){
       return  Hotel::create($request);
    }

    /**
     * Find hotel by id
     * @param int $id The hotel's id
     */
    public function getHotel($id){
       return  Hotel::find($id);
    }

    /**
     * update a specified hotel
     * @param int $id The hotel's id
     * @param App\Http\Requests\HotelRequest $request The hotel's request
     */
    public function updateHotel($request,$id){
        $hotel = Hotel::find($id);
        //$hotel->update($request->only('user_id','name','country', 'city','address','status'));
        $hotel->update($request->only('name','country', 'city','address','status','ice','rib','rc','idf','reason','comment'));
        return $hotel;
    }

    public function getHotelByCode($code){

        $hotel = Hotel::where('code', $code)->first();
        return $hotel;
    }

    /**
     * Delete hotel
     * @param int $id The hotel's id
     */
    public function deleteHotel($id){
        Hotel::destroy($id);
    }
}
