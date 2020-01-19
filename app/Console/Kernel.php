<?php

namespace App\Console;

use App\Console\Commands\RepositoryMakeCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\RepositoryMakeCommand::class,
        Commands\JkdMakeCommand::class,
        Commands\demo\AddBladeMakeCommand::class,
        Commands\demo\IndexBladeMakeCommand::class,
        Commands\demo\JsMakeCommand::class,
        Commands\demo\TableMakeCommand::class,
        Commands\demo\ControllerMakeCommand::class,
        Commands\demo\RepositoryMakeCommand::class,
        Commands\demo\ModelMakeCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
