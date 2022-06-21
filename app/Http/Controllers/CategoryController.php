<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @api {get} /Categories List of categories
     * @apiName categories_index
     * @apiGroup categories
     * @apiVersion 1.0.0
     *
     * @apiDescription  List all categories. It is possible to add some filters for more accuracy.
     *
     * @apiParam {String} token User Token.
     *
     * @apiSuccess  {unsignedBigInteger}         id                             id of the category.
     * @apiSuccess  {unsignedBigInteger}         hotel_id                       hotel_id of the category.
     * @apiSuccess  {String{..150}}              name                           name of the category.
     * @apiSuccess  {String{..150}}              icon                           icon of the category.
     * @apiSuccess  {time}                       startTime                      startTime of the category.
     * @apiSuccess  {time}                       endTime                        endDate of the category.
     * @apiSuccess  {String{..150}}              Sequence                       Sequence of the category.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *           "id": 1,
     *           "hotel_id": "1",
     *           "name": "Category1",
     *           "icon": "icon_1619185986.jpeg",
     *           "startTime": "08:30:00",
     *           "endTime": "18:30:00",
     *           "Sequence": "1",
     *        },
     *        {
     *           "id": 1,
     *           "hotel_id": "1",
     *           "name": "Category1",
     *           "icon": "icon_1619185986.jpeg",
     *           "startTime": "08:30:00",
     *           "endTime": "18:30:00",
     *           "Sequence": "1",
     *        }
     *     ]
     *     "links": {
     *           "first": "http://127.0.0.1:8000/categories?page=1",
     *           "last": "http://127.0.0.1:8000/categories?page=1",
     *           "prev": null,
     *           "next": null
     *       },
     *       "meta": {
     *           "current_page": 1,
     *           "from": 1,
     *           "last_page": 1,
     *           "links": [
     *               {
     *                   "url": null,
     *                   "label": "&laquo; Previous",
     *                   "active": false
     *               },
     *               {
     *                   "url": "http://127.0.0.1:8000/categories?page=1",
     *                   "label": "1",
     *                   "active": true
     *               },
     *               {
     *                   "url": null,
     *                   "label": "Next &raquo;",
     *                   "active": false
     *               }
     *           ],
     *           "path": "http://127.0.0.1:8000/categories",
     *           "per_page": 50,
     *           "to": 13,
     *           "total": 13
     *       }
     *}
     */
    public function index(Request $request)
    {
        $category = $this->categoryRepository->getCategories($request);
        return CategoryResource::collection($category);
    }

    /**
     * @api {post} /categories New category
     * @apiName  New Category
     * @apiGroup categories
     * @apiVersion 1.0.0
     *
     * @apiDescription  Add new categories.
     *
     *
     * @apiSuccess  {unsignedBigInteger}         id                             id of the category.
     * @apiSuccess  {unsignedBigInteger}         hotel_id                       hotel_id of the category.
     * @apiSuccess  {String{..150}}              name                           name of the category.
     * @apiSuccess  {String{..150}}              icon                           icon of the category.
     * @apiSuccess  {time}                       startTime                      startTime of the category.
     * @apiSuccess  {time}                       endTime                         endTime of the category.
     * @apiSuccess  {String{..150}}              Sequence                       Sequence of the category.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "hotel_id": "1",
     *        "name": "Category1",
     *        "icon": "icon_1619185986.jpeg",
     *        "startTime": "08:30:00",
     *        "endTime": "18:30:00",
     *        "Sequence": "1",
     *      }
     *  ]
     *}
     *
     */
    public function store(CategoryRequest $request)
    {
        $category =  $this->categoryRepository->addCategory($request);
        return response(new CategoryResource($category), Response::HTTP_CREATED);
    }

    /**
     * @api {get} /categories/1 Show a category
     * @apiName  Show a category
     * @apiGroup categories
     * @apiVersion 1.0.0
     *
     * @apiDescription  Show a category.
     *
     * @apiParam {Number} id Category unique ID.
     *
     * @apiSuccess  {unsignedBigInteger}         id                             id of the category.
     * @apiSuccess  {unsignedBigInteger}         hotel_id                       hotel_id of the category.
     * @apiSuccess  {String{..150}}              name                           name of the category.
     * @apiSuccess  {String{..150}}              icon                           icon of the category.
     * @apiSuccess  {time}                       startTime                      startTime of the category.
     * @apiSuccess  {time}                       endTime                         endTime of the category.
     * @apiSuccess  {String{..150}}              Sequence                       Sequence of the category.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *           "id": 1,
     *           "hotel_id": "1",
     *           "name": "Category1",
     *           "icon": "icon_1619185986.jpeg",
     *           "startTime": "08:30:00",
     *           "endTime": "18:30:00",
     *           "Sequence": "1",
     *        }
     *     ]
     *}
     *
     */
    public function show($id)
    {
        $category = $this->categoryRepository->getCategory($id);
        return response(new CategoryResource($category), Response::HTTP_CREATED);
    }

    /**
     * @api {put} /categories/1 Update category
     * @apiName  Update Category
     * @apiGroup categories
     * @apiVersion 1.0.0
     *
     * @apiDescription  Update categories.
     *
     * @apiParam {Number} id Category unique ID.
     * @apiParam {String} name Category Name.
     * @apiParam {String} icon Category Icon.
     * @apiParam {Number} Sequence Category Sequence.
     * @apiParam {Time} endTime Category EndTime.
     * @apiParam {Time} sequence Category StartTime.
     *
     * @apiSuccess  {unsignedBigInteger}         id                             id of the category.
     * @apiSuccess  {unsignedBigInteger}         hotel_id                       hotel_id of the category.
     * @apiSuccess  {String{..150}}              name                           name of the category.
     * @apiSuccess  {String{..150}}              icon                           icon of the category.
     * @apiSuccess  {time}                       startTime                      startTime of the category.
     * @apiSuccess  {time}                       endTime                         endTime of the category.
     * @apiSuccess  {String{..150}}              Sequence                       Sequence of the category.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "hotel_id": "1",
     *        "name": "Category1",
     *        "icon": "icon_1619185986.jpeg",
     *        "startTime": "08:30:00",
     *        "endTime": "18:30:00",
     *        "Sequence": "1",
     *      }
     *  ]
     *}
     *
     */
    public function update(Request $request, $id)
    {
        $category = $this->categoryRepository->updateCategory($request,$id);
        return \response(new CategoryResource($category), Response::HTTP_ACCEPTED);
    }

    /**
     * @api {delete} /categories/1 Delete a category
     * @apiName Delete a category
     * @apiGroup categories
     * @apiVersion 1.0.0
     *
     * @apiDescription  Delete a category.
     *
     * @apiParam {Number} id Category unique ID.
     *
     * @apiSuccessExample {json} Success example
     * 1
     *
     **/
    public function destroy($id)
    {
        $this->categoryRepository->deleteCategory($id);
        return \response(null, Response::HTTP_NO_CONTENT);
    }
}
