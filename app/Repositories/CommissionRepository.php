<?php


namespace App\Repositories;


use App\Models\Commission;

class CommissionRepository
{
    private $upload;

    public function __construct(UploadRepository $upload)
    {
        $this->upload = $upload;
    }

    /**
     * Display the list of commissions
     */
    public function getCommissions(){
        return Commission::paginate();
    }

    /**
     * Add new commission
     * @param App\Http\Requests\CommissionRequest $request The commission's request
     */
    public function addCommission($request){
        return  Commission::create($request->only('percentage'));
    }

    /**
     * Find commission by id
     * @param int $id The commission's id
     */
    public function getCommission($id){
        return  Commission::findOrFail($id);
    }

    /**
     * update a specified commission
     * @param int $id The commission's id
     * @param Illuminate\Http\Response $request The commission's request
     */
    public function updateCommission($request,$id){
        $commission = Commission::find($id);
        $commission->update($request->only('percentage'));
        return $commission;
    }

    /**
     * Delete commission
     * @param int $id The commission's id
     */
    public function deleteCommission($id){
        return Commission::destroy($id);
    }
}