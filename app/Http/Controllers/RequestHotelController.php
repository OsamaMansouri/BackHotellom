<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestHotelRequest;
use App\Http\Resources\RequestHotelResource;
use App\Models\Request_hotel;
use App\Repositories\RequestHotelRepository;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use LDAP\Result;

class RequestHotelController extends Controller
{
    
    private $requesthotelRepository;
    public function __construct(RequestHotelRepository $requesthotelRepository)
    {
        $this->requesthotelRepository = $requesthotelRepository;
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $requesthotel = $this->requesthotelRepository->getRequestHotels();
        return RequestHotelResource::collection($requesthotel);
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(RequestHotelRequest $request)
    {
        $requesthotel =  $this->requesthotelRepository->addRequestHotel($request);
        return response(new RequestHotelResource($requesthotel),Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $requesthotel = $this->requesthotelRepository->getRequestHotel($id);
        return response(new RequestHotelResource($requesthotel), Response::HTTP_CREATED);
    }

    public function update(RequestHotelRequest $request, $id)
    {
        $requesthotel = $this->requesthotelRepository->updateRequestHotel($request,$id);
        return response(new RequestHotelResource($requesthotel), Response::HTTP_CREATED);
    }
   

    public function destroyi($id)
    {
        $this->requestHotelRepository->deleteRequesthotel($id);
        return \response(null, Response::HTTP_NO_CONTENT);
    }

    public function destroy($id)
    {

        $requesthotel = Request_hotel::find($id);

        // $user->del = 1;
        // $user->save();
        // //$this->userRepository->deleteUser($id);
        // return \response(null, Response::HTTP_NO_CONTENT);
        if($requesthotel)
        {
            $requesthotel->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Request Hotel Deleted Successfully',
            ]);
        }
    }
    
}
