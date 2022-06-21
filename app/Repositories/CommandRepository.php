<?php


namespace App\Repositories;

use App\Models\Article;
use App\Models\Command;
use App\Models\CommandArticle;
use App\Models\CommandChoice;
use App\Models\CommandOption;
use App\Models\Role;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommandRepository
{
    /**
     * Display the list commands
     */
    public function getCommands($request) {
        $hotel_id = Auth::user()->hotel_id;
        //$hotel_id = $request->get('hotel_id', 1);
        //$request['user_id'] = Auth::user()->id;
        $user_id = 0;
        $commands = Command::with([
            'user',
            'room',
            'commandArticles.article',
            'commandArticles.commandOptions.option',
            'commandArticles.commandOptions.commandChoices.choice'
        ])->where('hotel_id', $hotel_id);

        if($request->query('user_id')){
            //$user_id = $request->query('user_id');
            $user_id = Auth::user()->id;
            $commands->where('user_id', $user_id);
        }
        $commands->orderBy('id', 'desc');

        if($request->query('web')){
            return $commands->get();
        }else{
            return $commands->paginate();
        }
    }

    /**
     * Display the command list with pagination
     */
    public function getCommandsList($request) {
        $hotel_id = $request->get('hotel_id', 1);
        $commands = Command::with([
                'user',
                'room',
                'commandArticles.article',
                'commandArticles.commandOptions.option',
                'commandArticles.commandOptions.commandChoices.choice'
            ])->where('hotel_id', $hotel_id)
            ->orderBy('id', 'desc')
            ->get();

        return $commands;
    }

    /**
     * Add new command
     * @param \Illuminate\Http\Request $request The command's request
     */
    public function addCommand($request){
        $input = $request->all();
        $input['hotel_id'] = Auth::user()->hotel_id;
        $input['user_id'] = Auth::user()->id;
        //dd($input);
        $command = Command::create($input);
        $total = 0;
        $profit = 0;

        if ($command && isset($input['articles'])) {
            foreach ($input['articles'] as $article) {
                $article_infos = Article::find($article['id']);
                $article_total = $article_infos->price * $article['quantity'];
                $article_profit = $article_infos->profit * $article['quantity'];
                $total += $article_total;
                $profit += $article_profit;

                $command_article_data = [
                    "article_id"    => $article['id'],
                    "command_id"    => $command->id,
                    "quantity"      => $article['quantity'],
                    "total"         => $article_total,
                    "comment"       => $article['comment']
                ];
                $command_article = CommandArticle::create($command_article_data);


                if ($command_article && isset($article['options'])) {
                    foreach ($article['options'] as $option) {
                        $command_option_data = [
                            'command_article_id'    => $command_article->id,
                            'option_id'             => $option['id']
                        ];
                        $command_option = CommandOption::create($command_option_data);

                        if ($command_option && isset($option['choices'])) {
                            foreach ($option['choices'] as $choice){
                                $command_choice_data = [
                                    'command_option_id' => $command_option->id,
                                    'choice_id'         => $choice
                                ];
                                $command_choice = CommandChoice::create($command_choice_data);
                            }
                        }
                    }
                }
            }
        }
        $command->update(['total' => $total, 'profit' => $profit]);

        $this->sendNotif($command, $input['hotel_id'], $input['user_id'], $input['room_id']);

        return $command;
    }

    /**
     * Find command by id
     * @param int $id The command's id
     */
    public function getCommand($id){
        $command = Command::where('id',$id)->first();
        $commandData[] = ['id' => $command['id'], 'user' => $command['user'],'status' => $command['status']];
        return $commandData;
    }

    public function getAllCommandeData($id){
        $command = Command::where('id',$id)->first();
        return $command->commandArticles;
    }

    /**
     * update a specified command
     * @param int $id The command's id
     * @param Illuminate\Http\Response $request The command's request
     */
    public function updateCommand($request,$id)
    {
        $command = Command::find($id);
        $command->update($request->all());
        return $command;
    }

    /**
     * Delete command
     * @param int $id The command's id
     */
    public function deleteCommand($id){
        Command::destroy($id);
    }

    /**
     * Get staffs users of given hotel
     * @param int $hotel_id: The user's id
     *
     */
    public function nbrCommandeDayByActiveClient($hotel_id)
    {
        $command = DB::select( DB::raw("SELECT COUNT(c.id) as 'nbrCommandeByDay' FROM commands c, users u
                                WHERE c.user_id = u.id AND c.hotel_id = :hotel_id AND MONTH(c.created_at) = MONTH(CURRENT_TIMESTAMP)
                                 AND u.experation_date >= CURRENT_TIMESTAMP AND u.experation_date IS NOT NULL"),
                            array(
                                'hotel_id' => $hotel_id,
                            ));
        return $command;
    }

    /**
     * Get command users of given hotel
     * @param int $hotel_id: The user's id
     *
     */
    public function nbrCommandeByMonth($hotel_id)
    {
        $command = DB::select( DB::raw("SELECT COUNT(*) as 'nbrCommande' FROM `commands`
                                WHERE hotel_id = :hotel_id AND MONTH(created_at) = MONTH(CURRENT_TIMESTAMP)"),
                            array(
                                'hotel_id' => $hotel_id,
                            ));
        return $command;
    }

    public function nbrCommandeByWeek($hotel_id)
    {
        $command = DB::select( DB::raw("SELECT COUNT(*) as 'nbrCommande' FROM `commands`
                                WHERE hotel_id = :hotel_id AND WEEK(created_at) = WEEK(CURRENT_TIMESTAMP)"),
                            array(
                                'hotel_id' => $hotel_id,
                            ));
        return $command;
    }

    public function nbrCommandeByYear($hotel_id)
    {
        $command = DB::select( DB::raw("SELECT COUNT(*) as 'nbrCommande' FROM `commands`
                                WHERE hotel_id = :hotel_id AND YEAR(created_at) = YEAR(CURRENT_TIMESTAMP)"),
                            array(
                                'hotel_id' => $hotel_id,
                            ));
        return $command;
    }

    /**
     * Get staffs users of given hotel
     * @param int $hotel_id: The user's id
     *
     */
    public function topArticles($hotel_id)
    {
        $command = DB::select( DB::raw("SELECT COUNT(*) as 'nbr_command',SUM(ca.quantity) as 'sum_qtt',a.name, a.price, c.name as 'cat', a.id as 'id' FROM command_articles ca, articles a, categories c
                             WHERE ca.article_id = a.id AND c.id = a.category_id AND c.hotel_id =:hotel_id
                             GROUP BY ca.article_id,a.name,a.price,c.name,a.id ORDER BY COUNT(*) DESC LIMIT 7"),
                            array(
                                'hotel_id' => $hotel_id,
                            ));
        return $command;
    }
    public function topApiArticles($hotel_id)
    {
        $command = DB::select( DB::raw("SELECT a.id as 'id' FROM command_articles ca, articles a, categories c
                             WHERE ca.article_id = a.id AND c.id = a.category_id AND c.hotel_id =:hotel_id
                             GROUP BY a.id ORDER BY COUNT(*) DESC LIMIT 15"),
                            array(
                                'hotel_id' => $hotel_id,
                            ));
        return $command;
    }

    public function topClients($hotel_id)
    {
        $clients = DB::select( DB::raw("SELECT COUNT(c.user_id) as 'nbr_commandes_client',SUM(c.total) as 'total',u.name FROM commands c, users u
                             WHERE c.user_id = u.id AND u.experation_date IS NOT NULL AND c.hotel_id =:hotel_id
                             GROUP BY c.user_id,u.name ORDER BY COUNT(c.user_id) DESC LIMIT 7"),
                            array(
                                'hotel_id' => $hotel_id,
                            ));
        return $clients;
    }

    /**
     * Get staffs users of given hotel
     * @param int $hotel_id: The user's id
     *
     */
    public function sumCommandeDayByActiveClient($hotel_id)
    {
        $command = DB::select( DB::raw("SELECT SUM(c.total) as 'sumCommandeByDay' FROM commands c, users u
                                WHERE c.user_id = u.id AND c.hotel_id = :hotel_id AND MONTH(c.created_at) = MONTH(CURRENT_TIMESTAMP)
                                 AND u.experation_date >= CURRENT_TIMESTAMP AND u.experation_date IS NOT NULL"),
                            array(
                                'hotel_id' => $hotel_id,
                            ));
        return $command;
    }

    /**
     * Get command users of given hotel
     * @param int $hotel_id: The user's id
     */
    public function sumCommandeByMonth($hotel_id)
    {
        $command = DB::select( DB::raw("SELECT SUM(total) as 'sumCommandes' FROM `commands`
                                WHERE hotel_id = :hotel_id AND MONTH(created_at) = MONTH(CURRENT_TIMESTAMP)"),
                            array(
                                'hotel_id' => $hotel_id,
                            ));
        return $command;
    }

    public function sumCommandeByWeek($hotel_id)
    {
        $command = DB::select( DB::raw("SELECT SUM(total) as 'sumCommandes' FROM `commands`
                                WHERE hotel_id = :hotel_id AND WEEK(created_at) = WEEK(CURRENT_TIMESTAMP)"),
                            array(
                                'hotel_id' => $hotel_id,
                            ));
        return $command;
    }

    public function sumCommandeByYear($hotel_id)
    {
        $command = DB::select( DB::raw("SELECT SUM(total) as 'sumCommandes' FROM `commands`
                                WHERE hotel_id = :hotel_id AND YEAR(created_at) = YEAR(CURRENT_TIMESTAMP)"),
                            array(
                                'hotel_id' => $hotel_id,
                            ));
        return $command;
    }

    public function sumCommandeProfitDayByActiveClient($hotel_id)
    {
        $command = DB::select( DB::raw("SELECT SUM(c.profit) as 'sumCommandeProfitByDay' FROM commands c, users u
                                WHERE c.user_id = u.id AND c.hotel_id = :hotel_id AND MONTH(c.created_at) = MONTH(CURRENT_TIMESTAMP)
                                 AND u.experation_date >= CURRENT_TIMESTAMP AND u.experation_date IS NOT NULL"),
                            array(
                                'hotel_id' => $hotel_id,
                            ));
        return $command;
    }

    public function sumCommandeProfitByWeek($hotel_id)
    {
        $command = DB::select( DB::raw("SELECT SUM(profit) as 'sumCommandesProfit' FROM `commands`
                                WHERE hotel_id = :hotel_id AND WEEK(created_at) = WEEK(CURRENT_TIMESTAMP)"),
                            array(
                                'hotel_id' => $hotel_id,
                            ));
        return $command;
    }

    public function sumCommandeProfitByMonth($hotel_id)
    {
        $command = DB::select( DB::raw("SELECT SUM(profit) as 'sumCommandesProfit' FROM `commands`
                                WHERE hotel_id = :hotel_id AND MONTH(created_at) = MONTH(CURRENT_TIMESTAMP)"),
                            array(
                                'hotel_id' => $hotel_id,
                            ));
        return $command;
    }

    public function sumCommandeProfitByYear($hotel_id)
    {
        $command = DB::select( DB::raw("SELECT SUM(profit) as 'sumCommandesProfit' FROM `commands`
                                WHERE hotel_id = :hotel_id AND YEAR(created_at) = YEAR(CURRENT_TIMESTAMP)"),
                            array(
                                'hotel_id' => $hotel_id,
                            ));
        return $command;
    }

    /**
     * Get command users of given hotel
     * @param int $hotel_id: The user's id
     */
    public function avgCommandeByMonth($hotel_id)
    {
        $command = DB::select( DB::raw("SELECT AVG(total) as 'avgCommandes' FROM `commands`
                                WHERE hotel_id = :hotel_id AND MONTH(created_at) = MONTH(CURRENT_TIMESTAMP)"),
                            array(
                                'hotel_id' => $hotel_id,
                            ));
        return $command;
    }

    public function avgCommandeByWeek($hotel_id)
    {
        $command = DB::select( DB::raw("SELECT AVG(total) as 'avgCommandes' FROM `commands`
                                WHERE hotel_id = :hotel_id AND WEEK(created_at) = WEEK(CURRENT_TIMESTAMP)"),
                            array(
                                'hotel_id' => $hotel_id,
                            ));
        return $command;
    }

    public function avgCommandeByYear($hotel_id)
    {
        $command = DB::select( DB::raw("SELECT AVG(total) as 'avgCommandes' FROM `commands`
                                WHERE hotel_id = :hotel_id AND YEAR(created_at) = YEAR(CURRENT_TIMESTAMP)"),
                            array(
                                'hotel_id' => $hotel_id,
                            ));
        return $command;
    }

    /**
     * Get staffs users of given hotel
     * @param int $hotel_id: The user's id
     *
     */
    public function avgCommandeDayByActiveClient($hotel_id)
    {
        $command = DB::select( DB::raw("SELECT AVG(c.total) as 'avgCommandeByDay' FROM commands c, users u
                                WHERE c.user_id = u.id AND c.hotel_id = :hotel_id AND MONTH(c.created_at) = MONTH(CURRENT_TIMESTAMP)
                                 AND u.experation_date >= CURRENT_TIMESTAMP AND u.experation_date IS NOT NULL"),
                            array(
                                'hotel_id' => $hotel_id,
                            ));
        return $command;
    }

    public function salesChart($hotel_id)
    {
        $curentYear = date('Y');
        $salesChart = DB::select(DB::raw('SELECT SUM(c.total) as `total`,monthname(created_at) as `mois` FROM commands c
                        WHERE c.hotel_id = :hotel_id AND YEAR(c.created_at) = :curentYear
                         GROUP BY MONTH(created_at),monthname(created_at)'),
                         array(
                                'hotel_id' => $hotel_id,
                                'curentYear' => $curentYear,
                         ));

        return $salesChart;
    }

    public function salesChartLastWeek()
    {
        $hotel_id = Auth::user()->hotel_id;
        $salesChart = DB::select(DB::raw('SELECT SUM(`total`) AS "total", DAYNAME(`created_at`) AS day FROM commands
                        WHERE `created_at` <= CURDATE() AND `created_at` > DATE_SUB(NOW(), INTERVAL 7 DAY) AND `hotel_id` = :hotel_id
                        GROUP BY day ORDER BY day DESC'),
                         array(
                                'hotel_id' => $hotel_id
                         ));

        return $salesChart;
    }

    public function sendNotif($command, $hotel_id, $user, $room)
    {
        $client = User::find($user);
        $room = Room::find($room);
        $users = User::with('modelHasRole.role')
                        ->whereHas('modelHasRole.role', function($q){
                                $q->where('name', Role::ROOMS_SERVANT);
                            })
                        ->where('hotel_id', $hotel_id)
                        ->where('connected', 1)
                        ->pluck('deviceToken');

        $notif = array(
            "title" => "New command",
            "body" => "Room : $room->room_number, Client : $client->name , Total : $command->total MAD",
        );

        $data = array(
            "type" => "notif_command"
        );

        $apiKey = env('FIREBASE_API_KEY');

        $fields = json_encode(array('registration_ids'=> $users, 'notification'=>$notif, 'data'=>$data));

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ($fields));

        $headers = array();
        $headers[] = 'Authorization: key='. $apiKey;
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
    }
}
