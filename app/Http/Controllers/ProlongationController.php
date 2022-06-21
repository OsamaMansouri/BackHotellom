<?php

namespace App\Http\Controllers;

use App\Events\NewProlongationNotificationEvent;
use App\Http\Requests\ProlongationRequest;
use App\Http\Resources\ProlongationResource;
use App\Repositories\ProlongationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProlongationController extends Controller
{
    private $prolongationRepository;

    public function __construct(ProlongationRepository $prolongationRepository)
    {
        $this->prolongationRepository = $prolongationRepository;
    }
    /**
     * @api {get} /prolongations List of prolongations
     * @apiName prolongations_index
     * @apiGroup prolongations
     * @apiVersion 1.0.0
     *
     * @apiDescription  List all prolongations. It is possible to add some filters for more accuracy.
     *
     * @apiSuccess  {unsignedBigInteger}         hotel_id                      hotel_id of the prolongation.
     * @apiSuccess  {datetime}                   startDate                     startDate the prolongation.
     * @apiSuccess  {datetime}                   endDate                       endDate of the prolongation.
     *
     * @apiSuccessExample {json} Success example
    {
     *     "data": [
     *        {
     *        "id": 1,
     *        "hotel_id": 1,
     *        "startDate": "2021-04-06T11:52:39.000000Z",
     *        "endDate": "2021-04-06T16:52:39.000000Z"
     *      }
     *  ]
     *}
     */
    public function index(Request $request)
    {
        $prolongations = $this->prolongationRepository->getProlongations($request);
        return ProlongationResource::collection($prolongations);
    }

    /**
     * @api {post} /prolongations New prolongation
     * @apiName New prolongation
     * @apiGroup prolongations
     * @apiVersion 1.0.0
     *
     * @apiDescription  Add new prolongation.
     *
     * @apiSuccess  {unsignedBigInteger}         hotel_id                      hotel_id of the prolongation.
     * @apiSuccess  {datetime}                   startDate                     startDate the prolongation.
     * @apiSuccess  {datetime}                   endDate                       endDate of the prolongation.
     *
     * @apiSuccessExample {json} Success example
    {
     *     "data": [
     *        {
     *        "id": 1,
     *        "hotel_id": 1,
     *        "startDate": "2021-04-06T11:52:39.000000Z",
     *        "endDate": "2021-04-06T16:52:39.000000Z"
     *      }
     *  ]
     *}
     */
    public function store(ProlongationRequest $request)
    {
        $prolongation = $this->prolongationRepository->addProlongation($request);
        if ($prolongation) {
            $admin = Auth::guard('api')->user();
            $admin_name = $admin->firstname . ' ' . $admin->lastname;
            NewProlongationNotificationEvent::dispatch($admin_name);
            return response(new ProlongationResource($prolongation), Response::HTTP_CREATED);
        }
    }

    /**
     * @api {get} /prolongations/1 Show a prolongation
     * @apiName Show a prolongation
     * @apiGroup prolongations
     * @apiVersion 1.0.0
     *
     * @apiDescription  Show a prolongation.
     *
     * @apiSuccess  {unsignedBigInteger}         hotel_id                      hotel_id of the prolongation.
     * @apiSuccess  {datetime}                   startDate                     startDate the prolongation.
     * @apiSuccess  {datetime}                   endDate                       endDate of the prolongation.
     *
     * @apiSuccessExample {json} Success example
    {
     *     "data": [
     *        {
     *        "id": 1,
     *        "hotel_id": 1,
     *        "startDate": "2021-04-06T11:52:39.000000Z",
     *        "endDate": "2021-04-06T16:52:39.000000Z"
     *      }
     *  ]
     *}
     */
    public function show($id)
    {
        $prolongation = $this->prolongationRepository->getProlongation($id);
        return new ProlongationResource($prolongation);
    }

    /**
     * @api {put} /prolongations/1 Update prolongation
     * @apiName Update prolongation
     * @apiGroup prolongations
     * @apiVersion 1.0.0
     *
     * @apiDescription  Update prolongation.
     *
     * @apiSuccess  {unsignedBigInteger}         hotel_id                      hotel_id of the prolongation.
     * @apiSuccess  {datetime}                   startDate                     startDate the prolongation.
     * @apiSuccess  {datetime}                   endDate                       endDate of the prolongation.
     *
     * @apiSuccessExample {json} Success example
    {
     *     "data": [
     *        {
     *        "id": 1,
     *        "hotel_id": 1,
     *        "startDate": "2021-04-06T11:52:39.000000Z",
     *        "endDate": "2021-04-06T16:52:39.000000Z"
     *      }
     *  ]
     *}
     */
    public function update(Request $request, $id)
    {
        $prolongation = $this->prolongationRepository->updateProlongation($request,$id);
        return response(new ProlongationResource($prolongation), Response::HTTP_CREATED);
    }

    /**
     * @api {delete} /prolongations/1 Delete a prolongation
     * @apiName Delete a prolongation
     * @apiGroup prolongations
     * @apiVersion 1.0.0
     *
     * @apiDescription  delete prolongation.
     *
     * @apiSuccess  {unsignedBigInteger}         hotel_id                      hotel_id of the prolongation.
     * @apiSuccess  {datetime}                   startDate                     startDate the prolongation.
     * @apiSuccess  {datetime}                   endDate                       endDate of the prolongation.
     *
     * @apiSuccessExample {json} Success example
     * 1
     *
     */
    public function destroy($id)
    {
        $this->prolongationRepository->deleteProlongation($id);
        return  \response(null, Response::HTTP_NO_CONTENT);
    }
}
