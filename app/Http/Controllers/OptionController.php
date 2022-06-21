<?php

namespace App\Http\Controllers;

use App\Http\Requests\OptionRequest;
use App\Http\Resources\OptionResource;
use App\Models\Option;
use App\Repositories\OptionRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OptionController extends Controller
{
    private $optionRepository;

    public function __construct(OptionRepository $optionRepository)
    {
        $this->optionRepository = $optionRepository;
    }

    /**
     * @api {get} /options List of options
     * @apiName options_index
     * @apiGroup options
     * @apiVersion 1.0.0
     *
     * @apiDescription  List all options. It is possible to add some filters for more accuracy.
     *
     * @apiSuccess  {unsignedBigInteger}         article_id                    article_id of the room.
     * @apiSuccess  {String{..150}}              name                          name of the room.
     * @apiSuccess  {Integer}                    max_choice                    max_choice the room.
     *
     * @apiSuccessExample {json} Success example
    {
     *     "data": [
     *        {
     *        "id": 1,
     *        "article_id": 1,
     *        "name": "option name",
     *        "max_choice": 5
     *      }
     *  ]
     *}
     */
    public function index()
    {
        $options = $this->optionRepository->getOptions();
        return OptionResource::collection($options);
    }

    /**
     * @api {post} /options New option
     * @apiName New option
     * @apiGroup options
     * @apiVersion 1.0.0
     *
     * @apiDescription  Add new option.
     *
     * @apiSuccess  {unsignedBigInteger}         article_id                    article_id of the room.
     * @apiSuccess  {String{..150}}              name                          name of the room.
     * @apiSuccess  {Integer}                    max_choice                    max_choice the room.
     *
     * @apiSuccessExample {json} Success example
    {
     *     "data": [
     *        {
     *        "id": 1,
     *        "article_id": 1,
     *        "name": "option name",
     *        "max_choice": 5
     *      }
     *  ]
     *}
     */
    public function store(OptionRequest $request)
    {
        $options = $this->optionRepository->addOption($request);
        return response(new OptionResource($options), Response::HTTP_CREATED);
    }

    /**
     * @api {get} /options/1 Show an option
     * @apiName Show an option
     * @apiGroup options
     * @apiVersion 1.0.0
     *
     * @apiDescription  Show an option.
     *
     * @apiSuccess  {unsignedBigInteger}         article_id                    article_id of the room.
     * @apiSuccess  {String{..150}}              name                          name of the room.
     * @apiSuccess  {Integer}                    max_choice                    max_choice the room.
     *
     * @apiSuccessExample {json} Success example
    {
     *     "data": [
     *        {
     *        "id": 1,
     *        "article_id": 1,
     *        "name": "option name",
     *        "max_choice": 5
     *      }
     *  ]
     *}
     */
    public function show($id)
    {
        $option = $this->optionRepository->getOption($id);
        return new OptionResource($option);
    }

    /**
     * @api {put} /options/1 Update option
     * @apiName Update option
     * @apiGroup options
     * @apiVersion 1.0.0
     *
     * @apiDescription  Update option.
     *
     * @apiSuccess  {unsignedBigInteger}         article_id                    article_id of the room.
     * @apiSuccess  {String{..150}}              name                          name of the room.
     * @apiSuccess  {Integer}                    max_choice                    max_choice the room.
     *
     * @apiSuccessExample {json} Success example
    {
     *     "data": [
     *        {
     *        "id": 1,
     *        "article_id": 1,
     *        "name": "option name",
     *        "max_choice": 5
     *      }
     *  ]
     *}
     */
    public function update(Request $request, $id)
    {
        $option = $this->optionRepository->updateOption($request,$id);
        return response(new OptionResource($option), Response::HTTP_CREATED);
    }

    /**
     * @api {delete} /options/1 Delete an option
     * @apiName Delete an option
     * @apiGroup options
     * @apiVersion 1.0.0
     *
     * @apiDescription  Delete an option.
     *
     * @apiSuccess  {unsignedBigInteger}         article_id                    article_id of the room.
     * @apiSuccess  {String{..150}}              name                          name of the room.
     * @apiSuccess  {Integer}                    max_choice                    max_choice the room.
     *
     * @apiSuccessExample {json} Success example
     * 1
     *
     */
    public function destroy($id)
    {
        $this->optionRepository->deleteOption($id);
        return  \response(null, Response::HTTP_NO_CONTENT);
    }
}
