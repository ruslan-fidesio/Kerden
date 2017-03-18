<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CronController;


class CompleteReservation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservation:complete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute transferts and payouts for confirmed and passed reservations';

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
     * @return mixed
     */
    public function handle()
    {
        $ctrl = new CronController();
        $ctrl->schedule();
    }
}
