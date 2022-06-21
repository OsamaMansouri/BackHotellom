<?php

namespace App\Http\Controllers;

use App\Http\Requests\HotelRequest;
use App\Http\Resources\HotelResource;
use App\Models\Hotel;
use App\Repositories\HotelRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HotelController extends Controller
{
    private $hotelRepository;

    public function __construct(HotelRepository $hotelRepository)
    {
        $this->hotelRepository = $hotelRepository;
    }

    /**
     * @api {get} /hotels List of hotels
     * @apiName hotels_index
     * @apiGroup hotels
     * @apiVersion 1.0.0
     *
     * @apiDescription  List all hotels. It is possible to add some filters for more accuracy.
     *
     * @apiSuccess  {unsignedBigInteger}         user_id                        user_id of the hotel.
     * @apiSuccess  {String{..150}}              name                           name of the hotel.
     * @apiSuccess  {String{..150}}              country                        country of the hotel.
     * @apiSuccess  {String{..150}}              city                           city of the hotel.
     * @apiSuccess  {String{..150}}              address                        address of the hotel.
     * @apiSuccess  {String{..150}}              status                         status of the hotel.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "user_id": "1",
     *        "name": "name",
     *        "country": "Morocco",
     *        "city": "Marrakech",
     *        "address": "Address",
     *        "status": "1",
     *      }
     *  ]
     *}
     */
    public function index(Request $request)
    {
        $hotels = $this->hotelRepository->getHotels($request);
        return HotelResource::collection($hotels);
    }

    /**
     * @api {post} /hotels New hotel
     * @apiName  New Hotel
     * @apiGroup hotels
     * @apiVersion 1.0.0
     *
     * @apiDescription  Add new hotels.
     *
     * @apiSuccess  {unsignedBigInteger}         user_id                        user_id of the hotel.
     * @apiSuccess  {String{..150}}              name                           name of the hotel.
     * @apiSuccess  {String{..150}}              country                        country of the hotel.
     * @apiSuccess  {String{..150}}              city                           city of the hotel.
     * @apiSuccess  {String{..150}}              address                        address of the hotel.
     * @apiSuccess  {String{..150}}              status                         status of the hotel.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "user_id": "1",
     *        "name": "name",
     *        "country": "Morocco",
     *        "city": "Marrakech",
     *        "address": "Address",
     *        "status": "1",
     *      }
     *  ]
     *}
     *
     */
    public function store(HotelRequest $request)
    {
        $hotel = $this->hotelRepository->addHotel($request);
        return response(new HotelResource($hotel), Response::HTTP_CREATED);
    }

    /**
     * @api {get} /hotels/1 Show a hotel
     * @apiName  Show a hotel
     * @apiGroup hotels
     * @apiVersion 1.0.0
     *
     * @apiDescription  Show a hotel.
     *
     * @apiSuccess  {unsignedBigInteger}         user_id                        user_id of the hotel.
     * @apiSuccess  {String{..150}}              name                           name of the hotel.
     * @apiSuccess  {String{..150}}              country                        country of the hotel.
     * @apiSuccess  {String{..150}}              city                           city of the hotel.
     * @apiSuccess  {String{..150}}              address                        address of the hotel.
     * @apiSuccess  {String{..150}}              status                         status of the hotel.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "user_id": "1",
     *        "name": "name",
     *        "country": "Morocco",
     *        "city": "Marrakech",
     *        "address": "Address",
     *        "status": "1",
     *      }
     *  ]
     *}
     *
     */
    public function show($id)
    {
        $hotel = $this->hotelRepository->getHotel($id);
        return new HotelResource($hotel);
    }

    /**
     * @api {put} /hotels/1 Update hotel
     * @apiName  Update Hotel
     * @apiGroup hotels
     * @apiVersion 1.0.0
     *
     * @apiDescription  Update hotel.
     *
     * @apiSuccess  {unsignedBigInteger}         user_id                        user_id of the hotel.
     * @apiSuccess  {String{..150}}              name                           name of the hotel.
     * @apiSuccess  {String{..150}}              country                        country of the hotel.
     * @apiSuccess  {String{..150}}              city                           city of the hotel.
     * @apiSuccess  {String{..150}}              address                        address of the hotel.
     * @apiSuccess  {String{..150}}              status                         status of the hotel.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "user_id": "1",
     *        "name": "name",
     *        "country": "Morocco",
     *        "city": "Marrakech",
     *        "address": "Address",
     *        "status": "1",
     *      }
     *  ]
     *}
     *
     */
    public function update(HotelRequest $request, $id)
    {
        $hotel = $this->hotelRepository->updateHotel($request,$id);
        return response(new HotelResource($hotel), Response::HTTP_CREATED);
    }

    /**
     * @api {delete} /hotels/1 Delete a hotel
     * @apiName Delete a hotel
     * @apiGroup hotels
     * @apiVersion 1.0.0
     *
     * @apiDescription  Delete a hotel.
     *
     * @apiSuccess  {unsignedBigInteger}         user_id                        user_id of the hotel.
     * @apiSuccess  {String{..150}}              name                           name of the hotel.
     * @apiSuccess  {String{..150}}              country                        country of the hotel.
     * @apiSuccess  {String{..150}}              city                           city of the hotel.
     * @apiSuccess  {String{..150}}              address                        address of the hotel.
     * @apiSuccess  {String{..150}}              status                         status of the hotel.
     *
     * @apiSuccessExample {json} Success example
     * 1
     *
     **/
    public function destroy($id)
    {
        $this->hotelRepository->deleteHotel($id);
        return  \response(null, Response::HTTP_NO_CONTENT);
    }
}
