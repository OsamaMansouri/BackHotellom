<?php

namespace App\Repositories;

use App\Models\Offer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OfferRepository
{
    private $upload;

    public function __construct(UploadRepository $upload)
    {
        $this->upload = $upload;
    }

    /**
     * Display the list offers
     */
    public function getOffers($request){
        $data = $request->all();
        //$hotel= isset($data['hotel_id']) ? $data['hotel_id'] : false;
        $hotel= Auth::user()->hotel_id;
        if (!$hotel){
            $offers = Offer::orderBy('id', 'desc')->paginate();
        }else if($request->query('web')){
            $offers = Offer::where('hotel_id',$hotel)->orderBy('id', 'desc')->get();
        }else{
            $offers = Offer::where('hotel_id',$hotel)->whereRaw('(now() between startDate and endDate)')->orderBy('id', 'desc')->paginate();
        }
        return $offers;
    }

    /**
     * Add new offers
     * @param App\Http\Requests\OfferRequest $request The offer's request
     */
    public function addOffer($request){

        $image = $request['image'];

        $imageName = Str::random('30').'.'.'png';

        $exploded = explode(',', $image);
        $base64 = $exploded[1];
        $data = base64_decode($base64);

        //Storage::disk('offers')->put($imageName, $data);
        $imageName = 'offers/'.Str::random('30').'_'.uniqid().'.png';
        //Upload File to external server
        Storage::disk('ftp')->put($imageName, $data);
        $request['hotel_id'] = Auth::user()->hotel_id;
        $prixFinal = $request['prix'] * ( (100 - $request['discount']) / 100 );
        return  Offer::create(
            $request->only('hotel_id', 'description','prix',
                            'startDate','endDate','profit','startTime',
                            'type_id','discount','titre','orders','status')
                            + ['prixFinal' => $prixFinal]
                            + ['image' => $imageName]
        );
    }

    /**
     * Find offer by id
     * @param int $id The offer's id
     */
    public function getOffer($id){
        return  Offer::findOrFail($id);
    }

    /**
     * update a specified offer
     * @param int $id The offer's id
     * @param Illuminate\Http\Response $request The offer's request
     */
    public function updateOffer($request,$id){
        $offer = Offer::find($id);
        $filenametostore = $offer->image;
        if ($request->hasFile('image')) {
            /* if (File::exists(public_path('storage/'.$path))) {
                File::delete(public_path('storage/'.$path));
            }
            $path = $request->file('image')->store('offers'); */
            Storage::disk('ftp')->delete($filenametostore);
            $filenamewithextension = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $filenametostore = 'offers/'. $filename.'_'.uniqid().'.'.$extension;
            Storage::disk('ftp')->put($filenametostore, fopen($request->file('image'), 'r+'));
        }

        $prixFinal = $request['prix'] * ( (100 - $request['discount']) / 100 );

        $offer->update($request->only('description','prix',
                        'startDate','endDate','profit','startTime',
                        'type_id','discount','titre','orders','status')
                        + ['prixFinal' => $prixFinal, 'image' => $filenametostore]
        );
        /* $offer->update($request->only('hotel_id', 'description','price','Frequency','date')
            + ['image' => $this->upload->upload($request,$file='image',$type='Offer',$path='Offers')]
        ); */
        return $offer;
    }

    /**
     * Delete offer
     * @param int $id The offer's id
     */
    public function deleteOffer($id){
        $offer = Offer::find($id);
        $path = $offer->image;
        Storage::disk('ftp')->delete($path);
        /* if (File::exists(public_path('storage/'.$path))) {
            File::delete(public_path('storage/'.$path));
        } */
        Offer::destroy($id);
    }
}
