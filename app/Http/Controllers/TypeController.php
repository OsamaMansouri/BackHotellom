<?php

namespace App\Http\Controllers;

use App\Http\Requests\TypeRequest;
use App\Http\Resources\TypeResource;
use App\Models\Type;
use App\Repositories\TypeRepository;
use App\Repositories\UploadRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class TypeController extends Controller
{

    private $typeRepository;

    public function __construct(TypeRepository $typeRepository)
    {
        $this->typeRepository = $typeRepository;
    }

    /**
     * @api {get} /types List of types
     * @apiName types_index
     * @apiGroup types
     * @apiVersion 1.0.0
     *
     * @apiDescription  List all types. It is possible to add some filters for more accuracy.
     *
     * @apiSuccess  {unsignedBigInteger}         hotel_id                       hotel_id of the type.
     * @apiSuccess  {String{..150}}              name                           name of the type.
     * @apiSuccess  {String{..150}}              gold_img                           gold_img of the type.
     * @apiSuccess  {String{..150}}              purple_img                       purple_img of the type.
     *
     * @apiSuccessExample {json} Success example
    *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "hotel_id": "1",
     *        "name": "Type1",
     *        "gold_img": "icon_1619185986.jpeg",
     *        "purple_img": "icon_161917585986.jpeg",
     *      }
     *  ]
     *}
     */
    public function index(Request $request)
    {
        $type = $this->typeRepository->getTypes($request);
        return TypeResource::collection($type);
    }

    /**
     * @api {post} /types store type
     * @apiName types_index
     * @apiGroup types
     * @apiVersion 1.0.0
     *
     * @apiDescription  List all types. It is possible to add some filters for more accuracy.
     *
     * @apiSuccess  {unsignedBigInteger}         hotel_id                       hotel_id of the type.
     * @apiSuccess  {String{..150}}              name                           name of the type.
     * @apiSuccess  {String{..150}}              gold_img                           gold_img of the type.
     * @apiSuccess  {String{..150}}              purple_img                       purple_img of the type.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "hotel_id": "1",
     *        "name": "Type1",
     *        "gold_img": "icon_1619185986.jpeg",
     *        "purple_img": "icon_161917585986.jpeg",
     *      }
     *  ]
     *}
     */
    public function store(TypeRequest $request)
    {
        $type =  $this->typeRepository->addType($request);
        return response(new TypeResource($type), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $type = $this->typeRepository->getType($id);
        return response(new TypeResource($type), Response::HTTP_CREATED);
    }

    /**
     * @api {put} /types/1 update type
     * @apiName types_index
     * @apiGroup types
     * @apiVersion 1.0.0
     *
     * @apiDescription  List all types. It is possible to add some filters for more accuracy.
     *
     * @apiSuccess  {unsignedBigInteger}         hotel_id                       hotel_id of the type.
     * @apiSuccess  {String{..150}}              name                           name of the type.
     * @apiSuccess  {String{..150}}              gold_img                           gold_img of the type.
     * @apiSuccess  {String{..150}}              purple_img                       purple_img of the type.
     *
     * @apiSuccessExample {json} Success example
    *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "hotel_id": "1",
     *        "name": "Type1",
     *        "gold_img": "icon_1619185986.jpeg",
     *        "purple_img": "icon_161917585986.jpeg",
     *      }
     *  ]
     *}
     */
    public function update(Request $request, $id)
    {
        $type = $this->typeRepository->updateType($request,$id);
        return \response(new TypeResource($type), Response::HTTP_ACCEPTED);
    }

        /**
     * @api {delete} /types/1 Delete a category
     * @apiName Delete a type
     * @apiGroup types
     * @apiVersion 1.0.0
     *
     * @apiDescription  Delete a type.
     *
     * @apiSuccess  {unsignedBigInteger}         hotel_id                       hotel_id of the type.
     * @apiSuccess  {String{..150}}              name                           name of the type.
     * @apiSuccess  {String{..150}}              gold_img                           gold_img of the type.
     * @apiSuccess  {String{..150}}              purple_img                       purple_img of the type.
     *
     * @apiSuccessExample {json} Success example
     * 1
     *
     **/
    public function destroy($id)
    {
        $this->typeRepository->deleteType($id);
        return \response(null, Response::HTTP_NO_CONTENT);
    }
}
