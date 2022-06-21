<?php

namespace App\Http\Controllers;

use App\Http\Resources\DefaultLicenceResource;
use App\Models\DefaultLicence;
use App\Repositories\DefaultLicenceRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultLicenceController extends Controller
{
    private $defaultLicence;

    public function __construct(DefaultLicenceRepository $defaultLicence)
    {
        $this->defaultLicence = $defaultLicence;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * @api {put} /defaultLicences/1 update default licence
     * @apiName update default licence
     * @apiGroup default licences
     * @apiVersion 1.0.0
     *
     * @apiDescription  update default licence.
     *
     * @apiSuccess  {integer}              days                          days of the choice.
     *
     * @apiSuccessExample {json} Success example
    {
     *     "data": [
     *        {
     *        "id": 1,
     *        "days": 1,
     *      }
     *  ]
     *}
     */
    public function update(Request $request, $id)
    {
        $defaultLicence = $this->defaultLicence->updateDefaultLicence($request,$id);
        return response(new DefaultLicenceResource($defaultLicence), Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
