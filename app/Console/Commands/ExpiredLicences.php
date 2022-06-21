<?php

namespace App\Console\Commands;

use App\Models\Licence;
use Illuminate\Console\Command;

class ExpiredLicences extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'day:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will be check expired licence and change here status';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Licence $licence)
    {
         $licence->getExpiredLicences();
    }
}
