<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommandOfferResource;
use App\Models\CommandOffer;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommandOfferController extends Controller
{

    public function index(Request $request)
    {
        $hotel_id = Auth::user()->hotel_id;
        $offers = CommandOffer::with('offer')->whereHas('offer', function($q) use($hotel_id) {
            $q->where('hotel_id', $hotel_id);
        })->orderBy('id');

        if($request->query('web')){
            return CommandOfferResource::collection($offers->get());
        }else{
            return CommandOfferResource::collection($offers->paginate());
        }
    }

    public function getCommandeOfferData($id)
    {
        $user = Auth::user();
        $hotel_id = $user->hotel_id;
        $offer = CommandOffer::with('offer')->where('id', $id)->whereHas('offer', function($q) use($hotel_id) {
            $q->where('hotel_id', $hotel_id);
        })->first();
        return new CommandOfferResource($offer);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $request['user_id'] = $user->id;
        $offer = CommandOffer::create($request->only('user_id', 'total', 'quantity', 'offer_id', 'room_id', 'comment', 'orderStatus'));
        if($offer){
            $off = Offer::findOrFail($request['offer_id']);
            $off->orders = $off->orders + 1;
            $off->save();
        }
        return new CommandOfferResource($offer);
    }

    public function update(Request $request, $id)
    {
        $request['orderStatus'] = 'delivered';
        $offer = CommandOffer::find($id);
        $offer->update($request->only('orderStatus'));
        return new CommandOfferResource($offer);
    }

    public function getCommandOffersByClient(Request $request){
        $user = Auth::user();
        $user_id = $user->id;
        $hotel_id = $user->hotel_id;
        $offers = CommandOffer::with('offer')->Where('user_id', $user_id)->whereHas('offer', function($q) use($hotel_id) {
            $q->where('hotel_id', $hotel_id);
        });
        if($request->query('web')){
            return CommandOfferResource::collection($offers->get());
        }else{
            return CommandOfferResource::collection($offers->paginate());
        }
    }

}
