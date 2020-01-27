<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FillDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:fill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill database with random data.';

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
        $users = factory('App\User', 50)->create();
        $channels = factory('App\Channel', 10)->create();
        $threads = factory('App\Thread', 100)->create(['user_id'=>$users->random()->id, 'channel_id'=> $channels->random()->id]);
        $replies = factory('App\Reply', 2500)->create(['user_id'=>$users->random()->id, 'thread_id'=>$threads->random()->id]);
        $activity = factory('App\Activity', 50)->create();
    }
}
