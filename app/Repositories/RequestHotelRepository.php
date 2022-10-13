<?php

namespace App\Repositories;

use App\Models\Request_hotel;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class RequestHotelRepository.
 */
class RequestHotelRepository
{
    /**
     * @return string
     *  Return the model
     */


    public function getRequestHotels(){
        //$client_id = Auth::user()->id;
        
        //return Request_hotel::OrderBy('hotel_id')->get();
        $hotel_id = Auth::user()->hotel->id;
        return Request_hotel::where('hotel_id', $hotel_id)->get();

        // return Request_hotel::join('demmands','demmands.id','=','request_hotels.demmand_id')
        // ->where('request_hotels.hotel_id',$hotel_id)->first();
    }

    public function addRequestHotel($request){
        //$request['hotel_id'] = Auth::user()->hotel_id;
        $request_hotel = Request_hotel::create(
            $request->only('hotel_id', 'demmand_id')
        );
        return $request_hotel;
    }

    public function getRequestHotel($id){
       return Request_hotel::where('hotel_id', $id)->get();
    }

    public function updateRequestHotel($request,$id){
        $request_hotel = Request_hotel::findOrFail($id);
        $request_hotel->update($request->only('name', 'sequence'));
        return $request_hotel;
    }

    // public function deleteRequesthotel($id){
    //     $request_hotel = Request_hotel::find($id);
    //     return Request_hotel::destroy($request_hotel); 
    // }
    public function deleteRequesthotel($id)
    {
        return Request_hotel::destroy($id);

    }
}
