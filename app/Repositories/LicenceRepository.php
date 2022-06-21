<?php


namespace App\Repositories;


use App\Models\Licence;
use Carbon\Carbon;

class LicenceRepository
{

    /**
     * Display the list of licences
     */
    public function getLicences(){
        return Licence::paginate();
    }

    /**
     * Add new licence
     * @param App\Http\Requests\LicenceRequest $request The licence's request
     */
    public function addLicence($request){
        return  Licence::create($request);
    }

    /**
     * Find licence by id
     * @param int $id The licence's id
     */
    public function getLicence($id){
        return  Licence::find($id);
    }

    /**
     * update a specified licence
     * @param int $id The licence's id
     * @param Illuminate\Http\Response $request The licence's request
     */
    public function updateLicence($request,$id){
        $licence = Licence::find($id);
        $licence->update($request->only('startDate', 'endDate'));
        return $licence;
    }

    /**
     * Delete licence
     * @param int $id The licence's id
     */
    public function deleteLicence($id){
        return Licence::destroy($id);
    }

    /**
     * Add prolongation days to licence
     * @param int $hotel_id The hotel's id
     * @param int $number_days Number of days for prolongation
     */
    public function prolongLicence($hotel_id, $number_days){
        $licence = Licence::where('hotel_id', $hotel_id)->first();
        $endDate = new Carbon($licence->endDate);
        $licence->endDate = $endDate->addDays($number_days)->toDateTimeString();
        return $licence->save();
    }

    /**
     * Display the list License by hotel
     */
    public function getLicenseByHotel($request){
        $data = $request->all();
        $hotel_id = isset($data['hotel_id']) ? $data['hotel_id'] : false;
        $licence = Licence::where('hotel_id', $hotel_id)->first();
        return $licence;
        
    }
}
