<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommandResource;
use App\Http\Resources\UserResource;
use App\Models\Command;
use App\Models\User;
use App\Repositories\CommandRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Events\StatistiqueUpdateEvent;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommandController extends Controller
{

    private $commandRepository;

    public function __construct(CommandRepository $commandRepository, UserRepository $userRepository)
    {
        $this->commandRepository = $commandRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @api {get} /commands List of commands
     * @apiName commands_index
     * @apiGroup commands
     * @apiVersion 1.0.0
     *
     * @apiDescription  List all commands. It is possible to add some filters for more accuracy.
     *
     * @apiSuccess  {unsignedBigInteger}         user_id                   user_id of the command.
     * @apiSuccess  {String{..150}}              status                    status of the command.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "user_id": 1,
     *        "user": {
     *        "id": 1,
     *        "lastname": "naciri",
     *        "firstname": "hamza",
     *        "name": "HN",
     *        "email": "hamza@hamza.hamza",
     *        "email_verified_at": null,
     *        "created_at": "2021-05-20T10:04:27.000000Z",
     *         "updated_at": "2021-05-20T10:04:27.000000Z"
     *          },
     *         "articles": [{
     *          "id": 1,
     *          "category_id": 1,
     *          "name": "article name",
     *          "image": "image.png",
     *          "description": "desciption.....",
     *          "price": 20,
     *          "max_options": 2,
     *          "created_at": "2021-05-20T09:12:26.000000Z",
     *          "updated_at": "2021-05-20T09:12:26.000000Z",
     *          "pivot": {
     *          "command_id": 1,
     *          "article_id": 1
     *             },
     *             {
     *          "id": 1,
     *          "category_id": 1,
     *          "name": "article name",
     *          "image": "image.png",
     *          "description": "desciption.....",
     *          "price": 20,
     *          "max_options": 2,
     *          "created_at": "2021-05-20T09:12:26.000000Z",
     *          "updated_at": "2021-05-20T09:12:26.000000Z",
     *          "pivot": {
     *          "command_id": 1,
     *          "article_id": 1
     *             }],
     *          "status" : "InPreparation"
     *      }
     *  ]
     *}
     */
    public function index(Request $request)
    {
        // Get All Command List For API
        $commands = $this->commandRepository->getCommands($request);
        return response()->json($commands,200);
    }

    // Get Command List With Paginate
    public function commandsList(Request $request)
    {
        $commands = $this->commandRepository->getCommandsList($request);
        return response()->json($commands,200);
    }

    /**
     * @api {post} /commands New command
     * @apiName New command
     * @apiGroup commands
     * @apiVersion 1.0.0
     *
     * @apiDescription  Add new command.
     *
     * @apiDescription  List all commands. It is possible to add some filters for more accuracy.
     *
     * @apiSuccess  {unsignedBigInteger}         user_id                   user_id of the command.
     * @apiSuccess  {String{..150}}              status                    status of the command.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "user_id": 1,
     *        "user": {
     *        "id": 1,
     *        "lastname": "naciri",
     *        "firstname": "hamza",
     *        "name": "HN",
     *        "email": "hamza@hamza.hamza",
     *        "email_verified_at": null,
     *        "created_at": "2021-05-20T10:04:27.000000Z",
     *         "updated_at": "2021-05-20T10:04:27.000000Z"
     *          },
     *         "articles": [{
     *          "id": 1,
     *          "category_id": 1,
     *          "name": "article name",
     *          "image": "image.png",
     *          "description": "desciption.....",
     *          "price": 20,
     *          "max_options": 2,
     *          "created_at": "2021-05-20T09:12:26.000000Z",
     *          "updated_at": "2021-05-20T09:12:26.000000Z",
     *          "pivot": {
     *          "command_id": 1,
     *          "article_id": 1
     *             },
     *             {
     *          "id": 1,
     *          "category_id": 1,
     *          "name": "article name",
     *          "image": "image.png",
     *          "description": "desciption.....",
     *          "price": 20,
     *          "max_options": 2,
     *          "created_at": "2021-05-20T09:12:26.000000Z",
     *          "updated_at": "2021-05-20T09:12:26.000000Z",
     *          "pivot": {
     *          "command_id": 1,
     *          "article_id": 1
     *             }],
     *          "status" : "InPreparation"
     *      }
     *  ]
     *}
     */
    public function store(Request $request)
    {
        $command = $this->commandRepository->addCommand($request);
        $request['hotel_id'] = Auth::user()->hotel_id;
        event(new StatistiqueUpdateEvent($request));
        return response()->json($command, 200);
    }

    /**
     * @api {get} /commands/1 Show an command
     * @apiName Show an command
     * @apiGroup commands
     * @apiVersion 1.0.0
     *
     * @apiDescription Show command.
     *
     * @apiSuccess  {unsignedBigInteger}         user_id                   user_id of the command.
     * @apiSuccess  {String{..150}}              status                    status of the command.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "user_id": 1,
     *        "user": {
     *        "id": 1,
     *        "lastname": "naciri",
     *        "firstname": "hamza",
     *        "name": "HN",
     *        "email": "hamza@hamza.hamza",
     *        "email_verified_at": null,
     *        "created_at": "2021-05-20T10:04:27.000000Z",
     *         "updated_at": "2021-05-20T10:04:27.000000Z"
     *          },
     *         "articles": [{
     *          "id": 1,
     *          "category_id": 1,
     *          "name": "article name",
     *          "image": "image.png",
     *          "description": "desciption.....",
     *          "price": 20,
     *          "max_options": 2,
     *          "created_at": "2021-05-20T09:12:26.000000Z",
     *          "updated_at": "2021-05-20T09:12:26.000000Z",
     *          "pivot": {
     *          "command_id": 1,
     *          "article_id": 1
     *             },
     *             {
     *          "id": 1,
     *          "category_id": 1,
     *          "name": "article name",
     *          "image": "image.png",
     *          "description": "desciption.....",
     *          "price": 20,
     *          "max_options": 2,
     *          "created_at": "2021-05-20T09:12:26.000000Z",
     *          "updated_at": "2021-05-20T09:12:26.000000Z",
     *          "pivot": {
     *          "command_id": 1,
     *          "article_id": 1
     *             }],
     *          "status" : "InPreparation"
     *      }
     *  ]
     *}
     */
    public function show($id)
    {
        $commands = $this->commandRepository->getCommand($id);
        return response()->json($commands,200);
    }

    public function getAllCommandeData($id){
        $commands = $this->commandRepository->getAllCommandeData($id);
        return response()->json($commands,200);
    }

    /**
     * @api {put} /commands/1 Update command
     * @apiName Update command
     * @apiGroup commands
     * @apiVersion 1.0.0
     *
     * @apiDescription Update command.
     *
     *
     * @apiSuccess  {unsignedBigInteger}         user_id                   user_id of the command.
     * @apiSuccess  {String{..150}}              status                    status of the command.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "user_id": 1,
     *        "user": {
     *        "id": 1,
     *        "lastname": "naciri",
     *        "firstname": "hamza",
     *        "name": "HN",
     *        "email": "hamza@hamza.hamza",
     *        "email_verified_at": null,
     *        "created_at": "2021-05-20T10:04:27.000000Z",
     *         "updated_at": "2021-05-20T10:04:27.000000Z"
     *          },
     *         "articles": [{
     *          "id": 1,
     *          "category_id": 1,
     *          "name": "article name",
     *          "image": "image.png",
     *          "description": "desciption.....",
     *          "price": 20,
     *          "max_options": 2,
     *          "created_at": "2021-05-20T09:12:26.000000Z",
     *          "updated_at": "2021-05-20T09:12:26.000000Z",
     *          "pivot": {
     *          "command_id": 1,
     *          "article_id": 1
     *             },
     *             {
     *          "id": 1,
     *          "category_id": 1,
     *          "name": "article name",
     *          "image": "image.png",
     *          "description": "desciption.....",
     *          "price": 20,
     *          "max_options": 2,
     *          "created_at": "2021-05-20T09:12:26.000000Z",
     *          "updated_at": "2021-05-20T09:12:26.000000Z",
     *          "pivot": {
     *          "command_id": 1,
     *          "article_id": 1
     *             }],
     *          "status" : "InPreparation"
     *      }
     *  ]
     *}
     */
    public function update(Request $request, $id)
    {
        $command = $this->commandRepository->updateCommand($request,$id);
        return  response()->json($command,200);
    }

     /**
      * @api {delete} /commands/1 DElete command
      * @apiName Delete command
      * @apiGroup commands
      * @apiVersion 1.0.0
      *
      * @apiDescription Delete command.
      *
      *
      * @apiSuccess  {unsignedBigInteger}         user_id                   user_id of the command.
      * @apiSuccess  {String{..150}}              status                    status of the command.
      *
      * @apiSuccessExample {json} Success example
      * 1
      *
      **/
    public function destroy($id)
    {
        $this->commandRepository->deleteCommand($id);
        return  \response(null, Response::HTTP_NO_CONTENT);
    }

    public function nbrCommandeDayByActiveClient(Request $request)
    {
        $hotel_id = $request->query('hotel_id');
        $users = $this->commandRepository->nbrCommandeDayByActiveClient($hotel_id);
        return $users;
    }

    public function nbrCommandeByMonth(Request $request)
    {
        $hotel_id = $request->query('hotel_id');
        $commands = $this->commandRepository->nbrCommandeByMonth($hotel_id);
        return $commands;
    }

    public function nbrCommandeByWeek(Request $request)
    {
        $hotel_id = $request->query('hotel_id');
        $commands = $this->commandRepository->nbrCommandeByWeek($hotel_id);
        return $commands;
    }

    public function topArticles(Request $request)
    {
        $hotel_id = $request->query('hotel_id');
        $commands = $this->commandRepository->topArticles($hotel_id);
        return $commands;
    }

    public function topApiArticles()
    {
        $hotel_id = Auth::user()->hotel_id;
        $commands = $this->commandRepository->topApiArticles($hotel_id);
        $articles = array();
        foreach($commands as $art){
            array_push($articles, new ArticleResource(Article::find($art->id)));
        }
        return $articles;
    }

    public function topClients(Request $request)
    {
        $hotel_id = $request->query('hotel_id');
        $clients = $this->commandRepository->topClients($hotel_id);
        return $clients;
    }

    public function sumCommandeDayByActiveClient(Request $request)
    {
        $hotel_id = $request->query('hotel_id');
        $users = $this->commandRepository->sumCommandeDayByActiveClient($hotel_id);
        return $users;
    }

    public function sumCommandeByMonth(Request $request)
    {
        $hotel_id = $request->query('hotel_id');
        $commands = $this->commandRepository->sumCommandeByMonth($hotel_id);
        return $commands;
    }

    public function sumCommandeByWeek(Request $request)
    {
        $hotel_id = $request->query('hotel_id');
        $commands = $this->commandRepository->sumCommandeByWeek($hotel_id);
        return $commands;
    }

    public function avgCommandeDayByActiveClient(Request $request)
    {
        $hotel_id = $request->query('hotel_id');
        $users = $this->commandRepository->avgCommandeDayByActiveClient($hotel_id);
        return $users;
    }

    public function avgCommandeByMonth(Request $request)
    {
        $hotel_id = $request->query('hotel_id');
        $commands = $this->commandRepository->avgCommandeByMonth($hotel_id);
        return $commands;
    }

    public function avgCommandeByWeek(Request $request)
    {
        $hotel_id = $request->query('hotel_id');
        $commands = $this->commandRepository->avgCommandeByWeek($hotel_id);
        return $commands;
    }

    public function conversionByMonth(Request $request)
    {
        $hotel_id = $request->query('hotel_id');
        $commands = $this->commandRepository->nbrCommandeByMonth($hotel_id);
        $clients = $this->userRepository->nbrActiveUserByMonth($hotel_id);
        $conversion = ($commands[0]->nbrCommande / $clients) * 100 ;
        return $conversion . ' %';
    }

    public function conversionByWeek(Request $request)
    {
        $hotel_id = $request->query('hotel_id');
        $commands = $this->commandRepository->nbrCommandeByWeek($hotel_id);
        $clients = $this->userRepository->nbrActiveUserByWeek($hotel_id);
        $conversion = ($commands[0]->nbrCommande / $clients) * 100 ;
        return $conversion . ' %';
    }

    public function salesChart(Request $request)
    {
        $hotel_id = $request->query('hotel_id');
        $salesChart = $this->commandRepository->salesChart($hotel_id);
        //dd($salesChart);
        return $salesChart;
    }

    public function salesChartLastWeek()
    {
        $salesChart = $this->commandRepository->salesChartLastWeek();
        //dd($salesChart);
        return $salesChart;
    }

}
