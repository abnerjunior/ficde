<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        \Wn\Generators\Commands\ControllerCommand::class,
        \Wn\Generators\Commands\ModelCommand::class,
        \Wn\Generators\Commands\ControllerRestActionsCommand::class,
        \Wn\Generators\Commands\ControllerCommand::class,
        \Wn\Generators\Commands\RouteCommand::class,
        \Wn\Generators\Commands\MigrationCommand::class,
        \Wn\Generators\Commands\ResourceCommand::class,
        \Wn\Generators\Commands\ResourcesCommand::class,
        \Wn\Generators\Commands\PivotTableCommand::class,
        \Wn\Generators\Commands\FactoryCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //
    }
}
