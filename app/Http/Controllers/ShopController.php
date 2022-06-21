<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopRequest;
use App\Http\Resources\ShopResource;
use App\Models\Shop;
use App\Repositories\ShopRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShopController extends Controller
{
    private $shopRepository;

    public function __construct(ShopRepository $shopRepository)
    {
        $this->shopRepository = $shopRepository;
    }

    /**
     * @api {get} /shops List of shops
     * @apiName shops_index
     * @apiGroup shops
     * @apiVersion 1.0.0
     *
     * @apiDescription  List all shops. It is possible to add some filters for more accuracy.
     *
     * @apiSuccess  {unsignedBigInteger}         hotel_id                       hotel_id of the shop.
     * @apiSuccess  {String{..150}}              name                           name of the shop.
     * @apiSuccess  {unsignedBigInteger}         type_id                           type of the shop.
     * @apiSuccess  {String{..150}}              color                           type of the shop.
     * @apiSuccess  {String{..150}}              pdf_file                           type of the shop.
     * @apiSuccess  {String{..150}}              menu                           menu of the shop.
     * @apiSuccess  {time}                       startTime                      startTime of the shop.
     * @apiSuccess  {time}                       endTime                        endTime of the shop.
     * @apiSuccess  {String{..150}}              description                    description of the shop.
     * @apiSuccess  {String{..150}}              sequence                       sequence of the shop.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "hotel_id": "1",
     *        "name": "shop name",
     *        "type_id": "4",
     *        "color": "gold",
     *        "pdf_file": "menu.pdf",
     *        "menu": "shop menu",
     *        "startTime": "09:00:00",
     *        "endTime": "16:00:00",
     *        "description": "shop description",
     *        "sequence": "1",
     *      }
     *  ]
     *}
     */
    public function index(Request $request)
    {
        $shop = $this->shopRepository->getShops($request);
        return ShopResource::collection($shop);

    }

    /**
     * @api {post} /shops New shop
     * @apiName New shop
     * @apiGroup shops
     * @apiVersion 1.0.0
     *
     * @apiDescription  Add new shop.
     *
     * @apiSuccess  {unsignedBigInteger}         hotel_id                       hotel_id of the shop.
     * @apiSuccess  {String{..150}}              name                           name of the shop.
     * @apiSuccess  {unsignedBigInteger}         type_id                           type of the shop.
     * @apiSuccess  {String{..150}}              color                           type of the shop.
     * @apiSuccess  {String{..150}}              pdf_file                           type of the shop.
     * @apiSuccess  {String{..150}}              menu                           menu of the shop.
     * @apiSuccess  {time}                       startTime                      startTime of the shop.
     * @apiSuccess  {time}                       endTime                        endTime of the shop.
     * @apiSuccess  {String{..150}}              description                    description of the shop.
     * @apiSuccess  {String{..150}}              sequence                       sequence of the shop.
     * @apiSuccess  {String{..150}}              size                    size of the shop.
     * @apiSuccess  {Boolean}              isRoomService                       room service test of the shop.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "hotel_id": "1",
     *        "name": "shop name",
     *        "type_id": "4",
     *        "color": "gold",
     *        "pdf_file": "menu.pdf",
     *        "menu": "shop menu",
     *        "startTime": "09:00:00",
     *        "endTime": "16:00:00",
     *        "description": "shop description",
     *        "sequence": "1",
     *      }
     *  ]
     *}
     */
    public function store(ShopRequest $request)
    {
        $shop = $this->shopRepository->addShop($request);
        return response(new ShopResource($shop), Response::HTTP_CREATED);
    }

    /**
     * @api {get} /shops/1 Show a shop
     * @apiName Show a shop
     * @apiGroup shops
     * @apiVersion 1.0.0
     *
     * @apiDescription  Show a shop.
     *
     * @apiSuccess  {unsignedBigInteger}         hotel_id                       hotel_id of the shop.
     * @apiSuccess  {String{..150}}              name                           name of the shop.
     * @apiSuccess  {unsignedBigInteger}         type_id                           type of the shop.
     * @apiSuccess  {String{..150}}              color                           type of the shop.
     * @apiSuccess  {String{..150}}              pdf_file                           type of the shop.
     * @apiSuccess  {String{..150}}              menu                           menu of the shop.
     * @apiSuccess  {time}                       startTime                      startTime of the shop.
     * @apiSuccess  {time}                       endTime                        endTime of the shop.
     * @apiSuccess  {String{..150}}              description                    description of the shop.
     * @apiSuccess  {String{..150}}              sequence                       sequence of the shop.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "hotel_id": "1",
     *        "name": "shop name",
     *        "type_id": "4",
     *        "color": "gold",
     *        "pdf_file": "menu.pdf",
     *        "menu": "shop menu",
     *        "startTime": "09:00:00",
     *        "endTime": "16:00:00",
     *        "description": "shop description",
     *        "sequence": "1",
     *      }
     *  ]
     *}
     */
    public function show($id)
    {
        $shop = $this->shopRepository->getShop($id);
        return new ShopResource($shop);

    }

    /**
     * @api {put} /shops/1 Update shop
     * @apiName Update shop
     * @apiGroup shops
     * @apiVersion 1.0.0
     *
     * @apiDescription  Update shop.
     *
     * @apiSuccess  {unsignedBigInteger}         hotel_id                       hotel_id of the shop.
     * @apiSuccess  {String{..150}}              name                           name of the shop.
     * @apiSuccess  {unsignedBigInteger}         type_id                           type of the shop.
     * @apiSuccess  {String{..150}}              color                           type of the shop.
     * @apiSuccess  {String{..150}}              pdf_file                           type of the shop.
     * @apiSuccess  {String{..150}}              menu                           menu of the shop.
     * @apiSuccess  {time}                       startTime                      startTime of the shop.
     * @apiSuccess  {time}                       endTime                        endTime of the shop.
     * @apiSuccess  {String{..150}}              description                    description of the shop.
     * @apiSuccess  {String{..150}}              sequence                       sequence of the shop.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "hotel_id": "1",
     *        "name": "shop name",
     *        "type_id": "4",
     *        "color": "gold",
     *        "pdf_file": "menu.pdf",
     *        "menu": "shop menu",
     *        "startTime": "09:00:00",
     *        "endTime": "16:00:00",
     *        "description": "shop description",
     *        "sequence": "1",
     *      }
     *  ]
     *}
     */
    public function update(Request $request, $id)
    {
        $shop = $this->shopRepository->updateShop($request,$id);
        return \response(new ShopResource($shop), Response::HTTP_ACCEPTED);
    }

    /**
     * @api {delete} /shops/1 Delete a shop
     * @apiName Delete a shop
     * @apiGroup shops
     * @apiVersion 1.0.0
     *
     * @apiDescription  Delete a shop.
     *
     * @apiSuccess  {unsignedBigInteger}         hotel_id                       hotel_id of the shop.
     * @apiSuccess  {String{..150}}              name                           name of the shop.
     * @apiSuccess  {unsignedBigInteger}         type_id                           type of the shop.
     * @apiSuccess  {String{..150}}              color                           type of the shop.
     * @apiSuccess  {String{..150}}              pdf_file                           type of the shop.
     * @apiSuccess  {String{..150}}              menu                           menu of the shop.
     * @apiSuccess  {time}                       startTime                      startTime of the shop.
     * @apiSuccess  {time}                       endTime                        endTime of the shop.
     * @apiSuccess  {String{..150}}              description                    description of the shop.
     * @apiSuccess  {String{..150}}              sequence                       sequence of the shop.
     *
     * @apiSuccessExample {json} Success example
     * 1
     *
     */
    public function destroy($id)
    {
        $this->shopRepository->deleteShop($id);
        return \response(null, Response::HTTP_NO_CONTENT);
    }
}
