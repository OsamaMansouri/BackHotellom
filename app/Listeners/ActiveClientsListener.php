<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Repositories\CommandRepository;
use App\Repositories\UserRepository;
use App\Events\ActiveClientsEvent;
use App\Models\Statistique;

class ActiveClientsListener
{
    private $commandRepository;
    private $userRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(CommandRepository $commandRepository, UserRepository $userRepository)
    {
        $this->commandRepository = $commandRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ActiveClientsEvent $event)
    {
        // Nbr Commandes By Day
        $commandDay = $this->commandRepository->nbrCommandeDayByActiveClient($event->hotel);//nbrCommandeByDay
        // Nbr Commandes By Week
        $commandWeek = $this->commandRepository->nbrCommandeByWeek($event->hotel);//nbrCommande
        // Nbr Commandes By Month
        $commandMonth = $this->commandRepository->nbrCommandeByMonth($event->hotel);//nbrCommande
        // Nbr Commandes By Year
        $commandYear = $this->commandRepository->nbrCommandeByYear($event->hotel);//nbrCommande

        // Summ By Day
        $sumCommandeDayByActiveClient = $this->commandRepository->sumCommandeDayByActiveClient($event->hotel);//sumCommandeByDay
        $salesDay = $sumCommandeDayByActiveClient[0]->sumCommandeByDay == null ? 0 : $sumCommandeDayByActiveClient[0]->sumCommandeByDay;
        // Sum By Week
        $sumCommandeByWeek = $this->commandRepository->sumCommandeByWeek($event->hotel);//sumCommandes
        $salesWeek = $sumCommandeByWeek[0]->sumCommandes == null ? 0 : $sumCommandeByWeek[0]->sumCommandes;
        // Sum By Month
        $sumCommandeByMonth = $this->commandRepository->sumCommandeByMonth($event->hotel);//sumCommandes
        $salesMonth = $sumCommandeByMonth[0]->sumCommandes == null ? 0 : $sumCommandeByMonth[0]->sumCommandes;
        // Sum By Year
        $sumCommandeByYear = $this->commandRepository->sumCommandeByYear($event->hotel);//sumCommandes
        $salesYear = $sumCommandeByYear[0]->sumCommandes == null ? 0 : $sumCommandeByYear[0]->sumCommandes;

        // Profit By Day
        $sumCommandeprofitDayByActiveClient = $this->commandRepository->sumCommandeProfitDayByActiveClient($event->hotel);//sumCommandeByDay
        $profitDay = $sumCommandeprofitDayByActiveClient[0]->sumCommandeProfitByDay == null ? 0 : $sumCommandeprofitDayByActiveClient[0]->sumCommandeProfitByDay;
        // Profit By Week
        $sumCommandeprofitByWeek = $this->commandRepository->sumCommandeProfitByWeek($event->hotel);//sumCommandes
        $profitWeek = $sumCommandeprofitByWeek[0]->sumCommandesProfit == null ? 0 : $sumCommandeprofitByWeek[0]->sumCommandesProfit;
        // Profit By Month
        $sumCommandeprofitByMonth = $this->commandRepository->sumCommandeProfitByMonth($event->hotel);//sumCommandes
        $profitMonth = $sumCommandeprofitByMonth[0]->sumCommandesProfit == null ? 0 : $sumCommandeprofitByMonth[0]->sumCommandesProfit;
        // Profit By Year
        $sumCommandeprofitByYear = $this->commandRepository->sumCommandeProfitByYear($event->hotel);//sumCommandes
        $profitYear = $sumCommandeprofitByYear[0]->sumCommandesProfit == null ? 0 : $sumCommandeprofitByYear[0]->sumCommandesProfit;

        // Average By Day
        $avgCommandeDayByActiveClient = $this->commandRepository->avgCommandeDayByActiveClient($event->hotel);//avgCommandeByDay
        $avgDay = $avgCommandeDayByActiveClient[0]->avgCommandeByDay == null ? 0 : $avgCommandeDayByActiveClient[0]->avgCommandeByDay;
        // Average By Week
        $avgCommandeByWeek = $this->commandRepository->avgCommandeByWeek($event->hotel);//avgCommandes
        $avgWeek = $avgCommandeByWeek[0]->avgCommandes == null ? 0 : $avgCommandeByWeek[0]->avgCommandes;
        // Average By Month
        $avgCommandeByMonth = $this->commandRepository->avgCommandeByMonth($event->hotel);//avgCommandes
        $avgMonth = $avgCommandeByMonth[0]->avgCommandes == null ? 0 : $avgCommandeByMonth[0]->avgCommandes;
        // Average By Year
        $avgCommandeByYear = $this->commandRepository->avgCommandeByYear($event->hotel);//avgCommandes
        $avgYear = $avgCommandeByYear[0]->avgCommandes == null ? 0 : $avgCommandeByYear[0]->avgCommandes;

        // Active Clients By Week
        $clientsWeek = $this->userRepository->nbrActiveUserByWeek($event->hotel);
        // Active Clients By Month
        $clientsMonth = $this->userRepository->nbrActiveUserByMonth($event->hotel);
        // Active Clients By Year
        $clientsYear = $this->userRepository->nbrActiveUserByYear($event->hotel);

        // Conversion By Week
        $conversionByWeek = $clientsWeek == 0 ? 0 : ($commandWeek[0]->nbrCommande / $clientsWeek) * 100 ;
        // Conversion By Month
        $conversionByMonth = $clientsMonth == 0 ? 0 : ($commandMonth[0]->nbrCommande / $clientsMonth) * 100 ;
        // Conversion By Week
        $conversionByYear = $clientsYear == 0 ? 0 : ($commandYear[0]->nbrCommande / $clientsYear) * 100 ;

        // Active Clients By Day
        $clientsDay = $this->userRepository->nbrActiveUser($event->hotel);

        $statistique = Statistique::where('hotel_id', $event->hotel)->first();

        $statistique->update([
            "activeClients"=>$clientsDay,
            "activeClientsWeek"=>$clientsWeek,
            "activeClientsMonth"=>$clientsMonth,
            "activeClientsYear"=>$clientsYear,
            "commandsDay"=>$commandDay[0]->nbrCommandeByDay,
            "commandsWeek"=>$commandWeek[0]->nbrCommande,
            "commandsMonth"=>$commandMonth[0]->nbrCommande,
            "commandsYear"=>$commandYear[0]->nbrCommande,
            "salesDay"=>$salesDay,
            "salesWeek"=> $salesWeek,
            "salesMonth"=> $salesMonth,
            "salesYear"=> $salesYear,
            "avgDay"=>$avgDay,
            "avgWeek"=> $avgWeek,
            "avgMonth"=> $avgMonth,
            "avgYear"=> $avgYear,
            "conversionWeek"=>$conversionByWeek,
            "conversionMonth"=>$conversionByMonth,
            "conversionYear"=>$conversionByYear,
            "commandsProfitDay"=>$profitDay,
            "commandsProfitWeek"=>$profitWeek,
            "commandsProfitMonth"=>$profitMonth,
            "commandsProfitYear"=>$profitYear
        ]);
    }
}
