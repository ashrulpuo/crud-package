<?php

namespace Ashrul\Generator;

use App\Console\Commands\GenerateCommand;
use Illuminate\Support\ServiceProvider;

class GeneratorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->commands([
            Console\GenerateCommand::class,
        ]);

        $this->loadViewsFrom(__DIR__ . '/resources/views', 'views');
    }

    public function register()
    {

    }
}