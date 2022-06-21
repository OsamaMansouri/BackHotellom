<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChoiceRequest;
use App\Http\Resources\ChoiceResource;
use App\Repositories\ChoiceRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChoiceController extends Controller
{
    private $choiceRepository;

    public function __construct(ChoiceRepository $choiceRepository)
    {
        $this->choiceRepository = $choiceRepository;
    }

    /**
     * @api {get} /choices List of choices
     * @apiName choices_index
     * @apiGroup choices
     * @apiVersion 1.0.0
     *
     * @apiDescription  List all choice. It is possible to add some filters for more accuracy.
     *
     * @apiSuccess  {unsignedBigInteger}         option_id                     option_id of the choice.
     * @apiSuccess  {String{..150}}              name                          name of the choice.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "option_id": 1,
     *        "name": "option name",
     *      }
     *  ]
     *}
     */
    public function index()
    {
        $choices = $this->choiceRepository->getChoices();
        return ChoiceResource::collection($choices);
    }

    /**
     * @api {post} /choices New choice
     * @apiName New choice
     * @apiGroup choices
     * @apiVersion 1.0.0
     *
     * @apiDescription  Add new choice.
     *
     * @apiSuccess  {unsignedBigInteger}         option_id                     option_id of the choice.
     * @apiSuccess  {String{..150}}              name                          name of the choice.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "option_id": 1,
     *        "name": "option name",
     *      }
     *  ]
     *}
     */
    public function store(ChoiceRequest $request)
    {
        $choice = $this->choiceRepository->addChoice($request);
        return response(new ChoiceResource($choice), Response::HTTP_CREATED);
    }

    /**
     * @api {get} /choices/1 Show a choice
     * @apiName Show a choice
     * @apiGroup choices
     * @apiVersion 1.0.0
     *
     * @apiDescription  Show a choice.
     *
     * @apiSuccess  {unsignedBigInteger}         option_id                     option_id of the choice.
     * @apiSuccess  {String{..150}}              name                          name of the choice.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "option_id": 1,
     *        "name": "option name",
     *      }
     *  ]
     *}
     */
    public function show($id)
    {
        $choice = $this->choiceRepository->getChoice($id);
        return new ChoiceResource($choice);
    }

    /**
     * @api {put} /choices/1 Update choice
     * @apiName Update choice
     * @apiGroup choices
     * @apiVersion 1.0.0
     *
     * @apiDescription  Update choice.
     *
     * @apiSuccess  {unsignedBigInteger}         option_id                     option_id of the choice.
     * @apiSuccess  {String{..150}}              name                          name of the choice.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "option_id": 1,
     *        "name": "option name",
     *      }
     *  ]
     *}
     */
    public function update(Request $request, $id)
    {
        $choice = $this->choiceRepository->updateChoice($request,$id);
        return response(new ChoiceResource($choice), Response::HTTP_CREATED);
    }

    /**
     * @api {delete} /choices/1 Delete a choice
     * @apiName Delete a choice
     * @apiGroup choices
     * @apiVersion 1.0.0
     *
     * @apiDescription  Delete choice.
     *
     * @apiSuccess  {unsignedBigInteger}         option_id                     option_id of the choice.
     * @apiSuccess  {String{..150}}              name                          name of the choice.
     *
     * @apiSuccessExample {json} Success example
     * 1
     *
     */
    public function destroy($id)
    {
        $this->choiceRepository->deleteChoice($id);
        return  \response(null, Response::HTTP_NO_CONTENT);
    }
}
