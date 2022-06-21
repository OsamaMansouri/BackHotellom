<?php


namespace App\Repositories;


use App\Models\DefaultLicence;

class DefaultLicenceRepository
{
    /**
     * update a specified default licence
     * @param int $id The default licence's id
     * @param Illuminate\Http\Response $request The default licence's request
     */
    public function updateDefaultLicence($request,$id){
        $defaultLicence = DefaultLicence::find($id);
        $defaultLicence->update($request->only( 'days'));
        return $defaultLicence;
    }
}
