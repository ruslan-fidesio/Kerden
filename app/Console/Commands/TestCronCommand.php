<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\TestCron;

class TestCronCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'un test maison';

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
        $test = TestCron::firstOrCreate(['id'=>1]);
        if( empty($test->nbCount) ) $test->nbCount = 1;
        else $test->nbCount += 1;

        $test->save();
    }
}
