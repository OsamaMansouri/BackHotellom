<?php

namespace App\Http\Controllers;

use App\Http\Requests\DemmandRequest;
use App\Http\Resources\DemmandResource;
use App\Models\Demmand;
use App\Models\DemmandOption;
use App\Repositories\DemmandRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DemmandController extends Controller
{
    private $demmandRepository;

    public function __construct(DemmandRepository $demmandRepository)
    {
        $this->demmandRepository = $demmandRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $demmands = $this->demmandRepository->getDemmands();
        return DemmandResource::collection($demmands);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DemmandRequest $request)
    {
        $demmand =  $this->demmandRepository->addDemmand($request);
        return response(new DemmandResource($demmand), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Demmand  $demmand
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $demmand = $this->demmandRepository->getDemmand($id);
        return response(new DemmandResource($demmand), Response::HTTP_CREATED);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Demmand  $demmand
     * @return \Illuminate\Http\Response
     */
    public function edit(Demmand $demmand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Demmand  $demmand
     * @return \Illuminate\Http\Response
     */
    public function update(DemmandRequest $request, $id)
    {
        $demmand = $this->demmandRepository->updateDemmand($request,$id);
        return response(new DemmandResource($demmand), Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Demmand  $demmand
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->demmandRepository->deleteDemmand($id);
        return \response(null, Response::HTTP_NO_CONTENT);
    }
}
