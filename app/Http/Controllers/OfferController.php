<?php

namespace App\Http\Controllers;

use App\Http\Requests\OffersRequest;
use App\Http\Resources\OffersResource;
use App\Repositories\OfferRepository;
use App\Events\PromotionAddedEvent;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OfferController extends Controller
{
    private $offerRepository;

    public function __construct(OfferRepository $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }

    /**
     * @api {get} /offers List of Offers
     * @apiName offers_index
     * @apiGroup offers
     * @apiVersion 1.0.0
     *
     * @apiDescription  List all offers. It is possible to add some filters for more accuracy.
     *
     * @apiParam {Number}            hotel_id             Hotel_id of the Offer.
     *
     * @apiSuccess  {String}             titre                          Titre of the offer.
     * @apiSuccess  {String}             image                          Image of the offer.
     * @apiSuccess  {Text}               description                    Description of the offer.
     * @apiSuccess  {float}              prix                          Prix of the offer.
     * @apiSuccess  {integer}            Frequency                      Frequency of the offer.
     * @apiSuccess  {float}              discount                    Discount of the offer.
     * @apiSuccess  {float}              prix                          PrixFinal of the offer.
     * @apiSuccess  {float}              profit                          Profit of the offer.
     * @apiSuccess  {integer}            status                      Status of the offer.
     * @apiSuccess  {integer}            orders                      Orders of the offer.
     * @apiSuccess  {dateTime}           startDate                           date of the offer.
     * @apiSuccess  {dateTime}           endDate                           date of the offer.
     * @apiSuccess  {Objet}            hotel                       Hotel of the offer.
     * @apiSuccess  {Objet}            type                       Type of the offer.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *       {
     *          "id": 1,
     *           "titre": "titre",
     *           "description": "desc",
     *           "prix": 100,
     *           "Frequency": 4,
     *           "startDate": null,
     *           "endDate": null,
     *           "image": "http://localhost/img/offers/EiUO2ilhl8G6Y6GiEh3K0GOK44CkGhNs93C9OXNJ.jpg",
     *           "profit": 0,
     *           "discount": 0,
     *           "prixFinal": 0,
     *           "status": 0,
     *           "orders": 0,
     *           "hotel": {
     *               "id": 1,
     *               "user_id": null,
     *               "name": "SEC Hotel",
     *               "country": "Morocco",
     *               "city": "Marrakech",
     *               "address": "Guiliz",
     *               "status": "test",
     *               "categories": [
     *                   {
     *                       "id": 1,
     *                       "hotel_id": 1,
     *                       "name": "Categorie",
     *                       "icon": "categories/mStlbQFRuKDlpEBk6EGkRP0YlHbO4eNTELdQLYoI.jpg",
     *                       "startTime": "07:00:00",
     *                       "endTime": "23:00:00",
     *                       "Sequence": 2,
     *                       "created_at": "2021-08-30T10:40:16.000000Z",
     *                       "updated_at": "2021-08-30T10:40:16.000000Z"
     *                   }
     *               ]
     *           },
     *           "type": {
     *               "id": 2,
     *               "hotel_id": 1,
     *               "name": "La Terrasse Restaurant",
     *               "gold_img": "http://localhost/img/types/terrasserestaurantgoldimage.png",
     *               "purple_img": "http://localhost/img/types/terrasserestaurantpurpleimage.png"
     *           }
     *       }
     *   ],
     *}
     */
    public function index(Request $request)
    {
        $offers = $this->offerRepository->getOffers($request);
        return OffersResource::collection($offers);
    }

    /**
     * @api {post} /offers New offers
     * @apiName  New offer
     * @apiGroup offers
     * @apiVersion 1.0.0
     *
     * @apiDescription  Add new offers.
     *
     * @apiParam {integer}            hotel_id             hotel_id of the Offer.
     * @apiParam {integer}            type_id             type_id of the Offer.
     * @apiParam {float}              prix             prix of the Offer.
     * @apiParam {float}              profit             profit of the Offer.
     * @apiParam {float}              discount             discount of the Offer.
     * @apiParam {float}              prixFinal             prixFinal of the Offer.
     * @apiParam {integer}             frequency             frequency of the Offer.
     * @apiParam {String}             titre             titre of the Offer.
     * @apiParam {String}             image             image of the Offer.
     * @apiParam {integer}             orders             orders of the Offer.
     * @apiParam {integer}             status             status of the Offer.
     * @apiParam {Text}             description             description of the Offer.
     * @apiParam {dateTime}           startDate                           startDate of the offer.
     * @apiParam {dateTime}           endDate                           endDate of the offer.
     *
     * @apiSuccess  {String}             titre                          Titre of the offer.
     * @apiSuccess  {String}             image                          Image of the offer.
     * @apiSuccess  {Text}               description                    Description of the offer.
     * @apiSuccess  {float}              prix                          Prix of the offer.
     * @apiSuccess  {integer}            Frequency                      Frequency of the offer.
     * @apiSuccess  {float}              discount                    Discount of the offer.
     * @apiSuccess  {float}              prix                          PrixFinal of the offer.
     * @apiSuccess  {float}              profit                          Profit of the offer.
     * @apiSuccess  {integer}            status                      Status of the offer.
     * @apiSuccess  {integer}            orders                      Orders of the offer.
     * @apiSuccess  {dateTime}           startDate                           startDate of the offer.
     * @apiSuccess  {dateTime}           endDate                           endDate of the offer.
     * @apiSuccess  {Objet}            hotel                       Hotel of the offer.
     * @apiSuccess  {Objet}            type                       Type of the offer.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *       {
     *          "id": 1,
     *           "titre": "titre",
     *           "description": "desc",
     *           "prix": 100,
     *           "Frequency": 4,
     *           "startDate": null,
     *           "endDate": null,
     *           "image": "http://localhost/img/offers/EiUO2ilhl8G6Y6GiEh3K0GOK44CkGhNs93C9OXNJ.jpg",
     *           "profit": 0,
     *           "discount": 0,
     *           "prixFinal": 0,
     *           "status": 0,
     *           "orders": 0,
     *           "hotel": {
     *               "id": 1,
     *               "user_id": null,
     *               "name": "SEC Hotel",
     *               "country": "Morocco",
     *               "city": "Marrakech",
     *               "address": "Guiliz",
     *               "status": "test",
     *               "categories": [
     *                   {
     *                       "id": 1,
     *                       "hotel_id": 1,
     *                       "name": "Categorie",
     *                       "icon": "categories/mStlbQFRuKDlpEBk6EGkRP0YlHbO4eNTELdQLYoI.jpg",
     *                       "startTime": "07:00:00",
     *                       "endTime": "23:00:00",
     *                       "Sequence": 2,
     *                       "created_at": "2021-08-30T10:40:16.000000Z",
     *                       "updated_at": "2021-08-30T10:40:16.000000Z"
     *                   }
     *               ]
     *           },
     *           "type": {
     *               "id": 2,
     *               "hotel_id": 1,
     *               "name": "La Terrasse Restaurant",
     *               "gold_img": "http://localhost/img/types/terrasserestaurantgoldimage.png",
     *               "purple_img": "http://localhost/img/types/terrasserestaurantpurpleimage.png"
     *           }
     *       }
     *   ],
     *}
     */
    public function store(OffersRequest $request)
    {
        $offer =  $this->offerRepository->addOffer($request);
        return response(new OffersResource($offer), Response::HTTP_CREATED);

    }

    /**
     * @api {get} /offers/1 Show an offer
     * @apiName  Show an offer
     * @apiGroup offers
     * @apiVersion 1.0.0
     *
     * @apiDescription  Show an offer.
     *
     * @apiParam {Number}            id             id of the Offer.
     *
     * @apiSuccess  {String}             titre                          Titre of the offer.
     * @apiSuccess  {String}             image                          Image of the offer.
     * @apiSuccess  {Text}               description                    Description of the offer.
     * @apiSuccess  {float}              prix                          Prix of the offer.
     * @apiSuccess  {integer}            Frequency                      Frequency of the offer.
     * @apiSuccess  {float}              discount                    Discount of the offer.
     * @apiSuccess  {float}              prix                          PrixFinal of the offer.
     * @apiSuccess  {float}              profit                          Profit of the offer.
     * @apiSuccess  {integer}            status                      Status of the offer.
     * @apiSuccess  {integer}            orders                      Orders of the offer.
     * @apiSuccess  {dateTime}           startDate                           date of the offer.
     * @apiSuccess  {dateTime}           endDate                           date of the offer.
     * @apiSuccess  {Objet}            hotel                       Hotel of the offer.
     * @apiSuccess  {Objet}            type                       Type of the offer.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *       {
     *          "id": 1,
     *           "titre": "titre",
     *           "description": "desc",
     *           "prix": 100,
     *           "Frequency": 4,
     *           "startDate": null,
     *           "endDate": null,
     *           "image": "http://localhost/img/offers/EiUO2ilhl8G6Y6GiEh3K0GOK44CkGhNs93C9OXNJ.jpg",
     *           "profit": 0,
     *           "discount": 0,
     *           "prixFinal": 0,
     *           "status": 0,
     *           "orders": 0,
     *           "hotel": {
     *               "id": 1,
     *               "user_id": null,
     *               "name": "SEC Hotel",
     *               "country": "Morocco",
     *               "city": "Marrakech",
     *               "address": "Guiliz",
     *               "status": "test",
     *               "categories": [
     *                   {
     *                       "id": 1,
     *                       "hotel_id": 1,
     *                       "name": "Categorie",
     *                       "icon": "categories/mStlbQFRuKDlpEBk6EGkRP0YlHbO4eNTELdQLYoI.jpg",
     *                       "startTime": "07:00:00",
     *                       "endTime": "23:00:00",
     *                       "Sequence": 2,
     *                       "created_at": "2021-08-30T10:40:16.000000Z",
     *                       "updated_at": "2021-08-30T10:40:16.000000Z"
     *                   }
     *               ]
     *           },
     *           "type": {
     *               "id": 2,
     *               "hotel_id": 1,
     *               "name": "La Terrasse Restaurant",
     *               "gold_img": "http://localhost/img/types/terrasserestaurantgoldimage.png",
     *               "purple_img": "http://localhost/img/types/terrasserestaurantpurpleimage.png"
     *           }
     *       }
     *   ],
     *}
     */
    public function show($id)
    {
        $offer = $this->offerRepository->getOffer($id);
        return response(new OffersResource($offer), Response::HTTP_CREATED);
    }

    /**
     * @api {put} /offer/1 Update offer
     * @apiName  Update Offer
     * @apiGroup offers
     * @apiVersion 1.0.0
     *
     * @apiDescription  Update offers.
     *
     * @apiParam {integer}            id             id of the Offer.
     * @apiParam {integer}            hotel_id             hotel_id of the Offer.
     * @apiParam {integer}            type_id             type_id of the Offer.
     * @apiParam {float}              prix             prix of the Offer.
     * @apiParam {float}              profit             profit of the Offer.
     * @apiParam {float}              discount             discount of the Offer.
     * @apiParam {float}              prixFinal             prixFinal of the Offer.
     * @apiParam {integer}             frequency             frequency of the Offer.
     * @apiParam {String}             titre             titre of the Offer.
     * @apiParam {String}             image             image of the Offer.
     * @apiParam {integer}             orders             orders of the Offer.
     * @apiParam {integer}             status             status of the Offer.
     * @apiParam {Text}             description             description of the Offer.
     * @apiParam {dateTime}           startDate                           startDate of the offer.
     * @apiParam {dateTime}           endDate                           endDate of the offer.
     *
     * @apiSuccess  {String}             titre                          Titre of the offer.
     * @apiSuccess  {String}             image                          Image of the offer.
     * @apiSuccess  {Text}               description                    Description of the offer.
     * @apiSuccess  {float}              prix                          Prix of the offer.
     * @apiSuccess  {integer}            Frequency                      Frequency of the offer.
     * @apiSuccess  {float}              discount                    Discount of the offer.
     * @apiSuccess  {float}              prix                          PrixFinal of the offer.
     * @apiSuccess  {float}              profit                          Profit of the offer.
     * @apiSuccess  {integer}            status                      Status of the offer.
     * @apiSuccess  {integer}            orders                      Orders of the offer.
     * @apiSuccess  {dateTime}           startDate                           startDate of the offer.
     * @apiSuccess  {dateTime}           endDate                           endDate of the offer.
     * @apiSuccess  {Objet}            hotel                       Hotel of the offer.
     * @apiSuccess  {Objet}            type                       Type of the offer.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *       {
     *          "id": 1,
     *           "titre": "titre",
     *           "description": "desc",
     *           "prix": 100,
     *           "Frequency": 4,
     *           "startDate": null,
     *           "endDate": null,
     *           "image": "http://localhost/img/offers/EiUO2ilhl8G6Y6GiEh3K0GOK44CkGhNs93C9OXNJ.jpg",
     *           "profit": 0,
     *           "discount": 0,
     *           "prixFinal": 0,
     *           "status": 0,
     *           "orders": 0,
     *           "hotel": {
     *               "id": 1,
     *               "user_id": null,
     *               "name": "SEC Hotel",
     *               "country": "Morocco",
     *               "city": "Marrakech",
     *               "address": "Guiliz",
     *               "status": "test",
     *               "categories": [
     *                   {
     *                       "id": 1,
     *                       "hotel_id": 1,
     *                       "name": "Categorie",
     *                       "icon": "categories/mStlbQFRuKDlpEBk6EGkRP0YlHbO4eNTELdQLYoI.jpg",
     *                       "startTime": "07:00:00",
     *                       "endTime": "23:00:00",
     *                       "Sequence": 2,
     *                       "created_at": "2021-08-30T10:40:16.000000Z",
     *                       "updated_at": "2021-08-30T10:40:16.000000Z"
     *                   }
     *               ]
     *           },
     *           "type": {
     *               "id": 2,
     *               "hotel_id": 1,
     *               "name": "La Terrasse Restaurant",
     *               "gold_img": "http://localhost/img/types/terrasserestaurantgoldimage.png",
     *               "purple_img": "http://localhost/img/types/terrasserestaurantpurpleimage.png"
     *           }
     *       }
     *   ],
     *}
     */
    public function update(OffersRequest $request, $id)
    {
        $offer = $this->offerRepository->updateOffer($request,$id);
        return \response(new OffersResource($offer), Response::HTTP_ACCEPTED);
    }

    /**
     * @api {delete} /offers/1 Delete an offer
     * @apiName Delete an offer
     * @apiGroup offers
     * @apiVersion 1.0.0
     *
     * @apiDescription  Delete an offer.
     *
     * @apiSuccessExample {json} Success example
     * 1
     *
     **/
    public function destroy($id)
    {
        $this->offerRepository->deleteOffer($id);
        return \response(null, Response::HTTP_NO_CONTENT);
    }

    public function getActiveOffers(){
        $hotel_id = Auth::user()->hotel_id;
        $offers = Offer::where('hotel_id', $hotel_id)->whereRaw('(now() between startDate and endDate)')->get();
        return OffersResource::collection($offers);
    }
}
