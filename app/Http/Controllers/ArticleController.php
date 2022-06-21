<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Choice;
use App\Models\Option;
use App\Repositories\ArticleRepository;
use App\Repositories\ChoiceRepository;
use App\Repositories\OptionRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    private $articleRepository;

    private $optionRepository;

    private $choiceRepository;

    public function __construct(ArticleRepository $articleRepository,OptionRepository $optionRepository,ChoiceRepository $choiceRepository)
    {
        $this->articleRepository   = $articleRepository;
        $this->optionRepository   = $optionRepository;
        $this->choiceRepository   = $choiceRepository;
    }

    /**
     * @api {get} /articles List of articles
     * @apiName articles_index
     * @apiGroup articles
     * @apiVersion 1.0.0
     *
     * @apiDescription  List all articles. It is possible to add some filters for more accuracy.
     *
     * @apiSuccess  {unsignedBigInteger}         category_id                   category_id of the article.
     * @apiSuccess  {String{..150}}              name                          name of the article.
     * @apiSuccess  {String{..150}}              image                         image of the article.
     * @apiSuccess  {String{..150}}              description                   description of the article.
     * @apiSuccess  {String{..150}}              price                         price of the article.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "category_id": 1,
     *        "name": "article name",
     *        "image": "image.jpg",
     *        "description": "description...",
     *        "price": 10.00,
     *      }
     *  ]
     *}
     */
    public function index(Request $request)
    {
        if ($request->has('category_id')) {
            $category_id = $request->query('category_id');
            $articles = $this->articleRepository->getArticlesByCategory($category_id);
        } else {
            $articles = $this->articleRepository->getArticles($request);
        }

        return ArticleResource::collection($articles);
    }

    /**
     * @api {post} /articles New article
     * @apiName New article
     * @apiGroup articles
     * @apiVersion 1.0.0
     *
     * @apiDescription  Add new article.
     *
     * @apiSuccess  {unsignedBigInteger}         category_id                   category_id of the article.
     * @apiSuccess  {String{..150}}              name                          name of the article.
     * @apiSuccess  {String{..150}}              image                         image of the article.
     * @apiSuccess  {String{..150}}              description                   description of the article.
     * @apiSuccess  {String{..150}}              price                         price of the article.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "category_id": 1,
     *        "name": "article name",
     *        "image": "image.jpg",
     *        "description": "description...",
     *        "price": 10.00,
     *      }
     *  ]
     *}
     */
    public function store(ArticleRequest $request)
    {
        $article = $this->articleRepository->addArticle($request);
        if ($article && isset($request['options'])) {
            foreach ($request['options'] as $max_option) {
                $optionData = [
                    'article_id' => $article->id,
                    'name' => $max_option['name'],
                    'max_choice' => $max_option['max_choice']
                ];

                $option = $this->optionRepository->addOption($optionData);

                if ($option && isset($max_option['choices'])) {
                    foreach ($max_option['choices']  as $max_choice) {
                        $choiceData = [
                            'option_id' => $option->id,
                            'name' => $max_choice['name']
                        ];

                        $this->choiceRepository->addChoice($choiceData);
                    }

                } else {
                    // exception
                }

            }
            return response(new ArticleResource($article), Response::HTTP_CREATED);
        }
        else{
            return response(new ArticleResource($article), Response::HTTP_CREATED);
        }
    }

    /**
     * @api {get} /articles/1 Show an article
     * @apiName Show an article
     * @apiGroup articles
     * @apiVersion 1.0.0
     *
     * @apiDescription Show article.
     *
     * @apiSuccess  {unsignedBigInteger}         category_id                   category_id of the article.
     * @apiSuccess  {String{..150}}              name                          name of the article.
     * @apiSuccess  {String{..150}}              image                         image of the article.
     * @apiSuccess  {String{..150}}              description                   description of the article.
     * @apiSuccess  {String{..150}}              price                         price of the article.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "category_id": 1,
     *        "name": "article name",
     *        "image": "image.jpg",
     *        "description": "description...",
     *        "price": 10.00,
     *      }
     *  ]
     *}
     */
    public function show($id)
    {
        $article = $this->articleRepository->getArticle($id);
        return new ArticleResource($article);
    }

    /**
     * @api {put} /articles/1 Update article
     * @apiName Update article
     * @apiGroup articles
     * @apiVersion 1.0.0
     *
     * @apiDescription Update article.
     *
     * @apiSuccess  {unsignedBigInteger}         category_id                   category_id of the article.
     * @apiSuccess  {String{..150}}              name                          name of the article.
     * @apiSuccess  {String{..150}}              image                         image of the article.
     * @apiSuccess  {String{..150}}              description                   description of the article.
     * @apiSuccess  {String{..150}}              price                         price of the article.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "category_id": 1,
     *        "name": "article name",
     *        "image": "image.jpg",
     *        "description": "description...",
     *        "price": 10.00,
     *      }
     *  ]
     *}
     */
    public function update(Request $request, $id)
    {
        $article = $this->articleRepository->updateArticle($request,$id);
        return response(new ArticleResource($article), Response::HTTP_CREATED);


    }

    /**
     * @api {delete} /articles/1 Delete an article
     * @apiName Delete an article
     * @apiGroup articles
     * @apiVersion 1.0.0
     *
     * @apiDescription Delete article.
     *
     * @apiSuccess  {unsignedBigInteger}         category_id                   category_id of the article.
     * @apiSuccess  {String{..150}}              name                          name of the article.
     * @apiSuccess  {String{..150}}              image                         image of the article.
     * @apiSuccess  {String{..150}}              description                   description of the article.
     * @apiSuccess  {String{..150}}              price                         price of the article.
     *
     * @apiSuccessExample {json} Success example
     * 1
     *
     */
    public function destroy($id)
    {
        $this->articleRepository->deleteArticle($id);
        return  \response(null, Response::HTTP_NO_CONTENT);
    }
}
