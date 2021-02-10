<?php

namespace Starter;

use Starter\Console\InstallCommand;
use Illuminate\Support\ServiceProvider;

class MainServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands(InstallCommand::class);
    }
}
