<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\CommissionRequest;
use App\Http\Resources\CommissionResource;
use App\Models\Commission;
use App\Repositories\CommissionRepository;

class CommissionController extends Controller
{


    private $commissionRepository;

    public function __construct(CommissionRepository $commissionRepository)
    {
        $this->commissionRepository = $commissionRepository;
    }

    /**
     * @api {get} /commissions List of commissions
     * @apiName commissions_index
     * @apiGroup commissions
     * @apiVersion 1.0.0
     *
     * @apiDescription  List all commissions. It is possible to add some filters for more accuracy.
     *
     * @apiSuccess  {String}         percentage                       percentage of the commission.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "percentage": "5%",
     *      }
     *  ]
     *}
     */
    public function index()
    {
        $commission = $this->commissionRepository->getCommissions();
        return CommissionResource::collection($commission);
    }

    /**
     * @api {post} /commissions Store commissions
     * @apiName commissions_index
     * @apiGroup commissions
     * @apiVersion 1.0.0
     *
     * @apiDescription  Add commissions.
     * 
     * @apiParam {String}            percentage             percentage of the Commission.
     *
     * @apiSuccess  {String}         percentage                       percentage of the commission.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "percentage": "5%",
     *      }
     *  ]
     *}
     */
    public function store(CommissionRequest $request)
    {
        $commission =  $this->commissionRepository->addCommission($request);
        return response(new CommissionResource($commission), Response::HTTP_CREATED);
    }

    /**
     * @api {get} /commissions/id List of commissions
     * @apiName commissions_index
     * @apiGroup commissions
     * @apiVersion 1.0.0
     *
     * @apiDescription  get commissions.
     * 
     * @apiParam {Number}            id             Id of the Commission.
     *
     * @apiSuccess  {String}         percentage                       percentage of the commission.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "percentage": "5%",
     *      }
     *  ]
     *}
     */
    public function show($id)
    {
        $commission = $this->commissionRepository->getCommission($id);
        return response(new CommissionResource($commission), Response::HTTP_CREATED);
    }

    /**
     * @api {put} /commissions/2 Update of commissions
     * @apiName commissions_index
     * @apiGroup commissions
     * @apiVersion 1.0.0
     *
     * @apiDescription  update commissions.
     * 
     * @apiParam {Number}            id             Id of the Commission.
     * @apiParam {String}            percentage             percentage of the Commission.
     *
     * @apiSuccess  {String}         percentage                       percentage of the commission.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "percentage": "5%",
     *      }
     *  ]
     *}
     */
    public function update(Request $request, $id)
    {
        $commission = $this->commissionRepository->updateCommission($request,$id);
        return \response(new CommissionResource($commission), Response::HTTP_ACCEPTED);
    }

    /**
     * @api {delete} /commissions/1 Delete a commission
     * @apiName Delete a commission
     * @apiGroup commissions
     * @apiVersion 1.0.0
     *
     * @apiDescription  Delete a commission.
     * 
     * @apiParam {Number}            id             Id of the Commission.
     *
     * @apiSuccessExample {json} Success example
     * 1
     *
     **/
    public function destroy($id)
    {
        $this->commissionRepository->deleteCommission($id);
        return \response(null, Response::HTTP_NO_CONTENT);
    }
}