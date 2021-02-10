<?php

namespace Starter\Console;

use Starter\Presets\FilesCopy;
use Illuminate\Console\Command;
use Starter\Presets\NpmPackages;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Frontend And Backend With Auth';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        NpmPackages::install();
        FilesCopy::install();

        if ($this->confirm('Do you want to remove the package? Choose yes')) {
            shell_exec('composer remove rabeea/laravel-starter');
        }

        $this->info('All scaffolding installed successfully.');
        $this->comment('Please execute the "npm install && npm run dev" command to build your assets.');
    }
}
