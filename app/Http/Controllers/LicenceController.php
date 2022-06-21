<?php

namespace App\Http\Controllers;

use App\Http\Requests\LicenceRequest;
use App\Http\Resources\LicenceResource;
use App\Models\Licence;
use App\Repositories\LicenceRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LicenceController extends Controller
{
    private $licenceRepository;

    public function __construct(LicenceRepository $licenceRepository)
    {
        $this->licenceRepository = $licenceRepository;
    }

    /**
     * @api {get} /licences List of licences
     * @apiName licences_index
     * @apiGroup licences
     * @apiVersion 1.0.0
     *
     * @apiDescription  List all licences. It is possible to add some filters for more accuracy.
     *
     * @apiSuccess  {unsignedBigInteger}         hotel_id                       hotel_id of the licence.
     * @apiSuccess  {datetime}                   startDate                      startDate of the licence.
     * @apiSuccess  {datetime}                   endDate                        endDate of the licence.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "hotel_id": "1",
     *        "startDate": "2021-04-06T11:52:39.000000Z",
     *        "endDate": "2021-04-06T16:52:39.000000Z"
     *      }
     *  ]
     *}
     */
    public function index()
    {
        $licences = $this->licenceRepository->getLicences();
        return LicenceResource::collection($licences);
    }

    /**
     * @api {post} /licences New licence
     * @apiName  New Licence
     * @apiGroup licences
     * @apiVersion 1.0.0
     *
     * @apiDescription  Add new licences.
     *
     *
     * @apiSuccess  {unsignedBigInteger}         hotel_id                       hotel_id of the licence.
     * @apiSuccess  {datetime}                   startDate                      startDate of the licence.
     * @apiSuccess  {datetime}                   endDate                        endDate of the licence.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "hotel_id": "1",
     *        "startDate": "2021-04-06T11:52:39.000000Z",
     *        "endDate": "2021-04-06T16:52:39.000000Z"
     *      }
     *  ]
     *}
     *
     */
    public function store(LicenceRequest $request)
    {
        $licence = $this->licenceRepository->addLicence($request);
        return response(new LicenceResource($licence), Response::HTTP_CREATED);
    }

    /**
     * @api {get} /licences/1 Show a licence
     * @apiName  Show a licence
     * @apiGroup licences
     * @apiVersion 1.0.0
     *
     * @apiDescription  Show a licence.
     *
     * @apiSuccess  {unsignedBigInteger}         hotel_id                       hotel_id of the licence.
     * @apiSuccess  {datetime}                   startDate                      startDate of the licence.
     * @apiSuccess  {datetime}                   endDate                        endDate of the licence.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "hotel_id": "1",
     *        "startDate": "2021-04-06T11:52:39.000000Z",
     *        "endDate": "2021-04-06T16:52:39.000000Z"
     *      }
     *  ]
     *}
     *
     */
    public function show($id)
    {
        $licence = $this->licenceRepository->getLicence($id);
        return new LicenceResource($licence);
    }

    /**
     * @api {put} /licences/1 Update licence
     * @apiName  Update licence
     * @apiGroup licences
     * @apiVersion 1.0.0
     *
     * @apiDescription  Update licence.
     *
     * @apiSuccess  {unsignedBigInteger}         hotel_id                       hotel_id of the licence.
     * @apiSuccess  {datetime}                   startDate                      startDate of the licence.
     * @apiSuccess  {datetime}                   endDate                        endDate of the licence.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "hotel_id": "1",
     *        "startDate": "2021-04-06T11:52:39.000000Z",
     *        "endDate": "2021-04-06T16:52:39.000000Z"
     *      }
     *  ]
     *}
     *
     */
    public function update(Request $request, $id)
    {
        $licence = $this->licenceRepository->updateLicence($request,$id);
        return \response(new LicenceResource($licence), Response::HTTP_ACCEPTED);
    }

    /**
     * @api {delete} /licences/1 Delete a licence
     * @apiName Delete a licence
     * @apiGroup licences
     * @apiVersion 1.0.0
     *
     * @apiDescription  Delete a licence.
     *
     * @apiSuccess  {unsignedBigInteger}         hotel_id                       hotel_id of the licence.
     * @apiSuccess  {datetime}                   startDate                      startDate of the licence.
     * @apiSuccess  {datetime}                   endDate                        endDate of the licence.
     *
     * @apiSuccessExample {json} Success example
     * 1
     *
     */
    public function destroy($id)
    {
        $this->licenceRepository->deleteLicence($id);
        return \response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @api {get} /licences/1 Show a licence
     * @apiName  Show a licence By Hotel
     * @apiGroup licences
     * @apiVersion 1.0.0
     *
     * @apiDescription  Show a licence.
     *
     * @apiSuccess  {unsignedBigInteger}         hotel_id                       hotel_id of the licence.
     * @apiSuccess  {datetime}                   startDate                      startDate of the licence.
     * @apiSuccess  {datetime}                   endDate                        endDate of the licence.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "hotel_id": "1",
     *        "startDate": "2021-04-06T11:52:39.000000Z",
     *        "endDate": "2021-04-06T16:52:39.000000Z"
     *      }
     *  ]
     *}
     *
     */
    public function getLicenseByHotel(Request $request)
    {
        $license = $this->licenceRepository->getLicenseByHotel($request);
        return new LicenceResource($license);
        
    }
}
