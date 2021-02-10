<?php

namespace Starter\Console;

use Illuminate\Console\Command;
use RabeeaAli\LaravelStarter\Presets\FilesCopy;
use RabeeaAli\LaravelStarter\Presets\NpmPackages;

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

        // $this->info('Package scaffolding installed successfully.');

        // $this->line('Display this on the screen');

        // shell_exec('npm install && npm run dev');

        // $this->info('Done');

        // if ($this->confirm('Do you want to remove the package?')) {
        //     shell_exec('composer remove ');
        // }

        $this->info('All scaffolding installed successfully.');
        $this->comment('Please execute the "npm install && npm run dev" command to build your assets.');
    }
}
