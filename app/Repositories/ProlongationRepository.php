<?php


namespace App\Repositories;

use App\Events\AcceptProlongationEvent;
use App\Models\Licence;
use App\Models\Prolongation;
use Illuminate\Support\Facades\App;

class ProlongationRepository
{
    /**
     * Display the list prolongations
     */
    public function getProlongations($request){
        if ($request->has('hotel_id')){
            $hotel_id = $request->query('hotel_id');
            $prolongations = Prolongation::where('hotel_id', $hotel_id)->paginate();
        }else{
            $prolongations = Prolongation::paginate();
        }
        return $prolongations;
    }

    /**
     * Add new prolongation
     * @param App\Http\Requests\ProlongationRequest $request The prolongation's request
     */
    public function addProlongation($request){
        $prolongation = Prolongation::create($request->only( 'hotel_id','number_days'));
        return $prolongation;
    }

    /**
     * Find prolongation by id
     * @param int $id The prolongation's id
     */
    public function getProlongation($id){
        return  Prolongation::find($id);
    }

    /**
     * update a specified prolongation
     * @param int $id The prolongation's id
     * @param Illuminate\Http\Response $request The prolongation's request
     */
    public function updateProlongation($request, $id){
        $prolongation = Prolongation::with('hotel.admin')->find($id);
        $prolongation_status = $prolongation->status;
        $prolongation->update($request->only('number_days', 'status'));
        // Prolong licence of this user
        if ($request->has('status') && $request->input('status') == Licence::IS_VALID && $prolongation_status == Licence::IN_PROCESS) {
            $LicenceRepo = App::make(LicenceRepository::class);
            $LicenceRepo->prolongLicence($prolongation->hotel_id, $prolongation->number_days);
            AcceptProlongationEvent::dispatch($prolongation->hotel->admin);
        }
        return $prolongation;
    }

    /**
     * Delete prolongation
     * @param int $id The prolongation's id
     */
    public function deleteProlongation($id){
        Prolongation::destroy($id);
    }
}
