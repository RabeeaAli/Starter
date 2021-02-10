<?php

namespace Starter\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

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
        $this->updateNodePackages(function ($packages) {
            return [
                '@tailwindcss/forms' => '^0.2.1',
                'alpinejs' => '^2.7.3',
                'autoprefixer' => '^10.1.0',
                'postcss' => '^8.2.1',
                'postcss-import' => '^12.0.1',
                'tailwindcss' => '^2.0.2',
            ] + $packages;
        });;

        (new Filesystem)->delete(resource_path('views/welcome.blade.php'));

        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/app/Http/Controllers/Frontend', app_path('Http/Controllers/Frontend'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/app/Http/Controllers/Backend', app_path('Http/Controllers/Backend'));

        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/app/Http/Requests/Auth', app_path('Http/Requests/Auth'));

        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/resources/views', resource_path('views'));
        copy(__DIR__ . '/../../stubs/resources/css/app.css', resource_path('css/app.css'));
        copy(__DIR__ . '/../../stubs/resources/js/app.js', resource_path('js/app.js'));

        copy(__DIR__ . '/../../stubs/routes/web.php', base_path('routes/web.php'));
        copy(__DIR__ . '/../../stubs/routes/auth.php', base_path('routes/auth.php'));
        copy(__DIR__ . '/../../stubs/routes/admin.php', base_path('routes/admin.php'));
        copy(__DIR__ . '/../../stubs/routes/user.php', base_path('routes/user.php'));

        copy(__DIR__ . '/../../stubs/app/Providers/RouteServiceProvider.php', app_path('Providers/RouteServiceProvider.php'));

        copy(__DIR__ . '/../../stubs/app/Http/Middleware/admin.php', app_path('Http/Middleware/admin.php'));

        copy(__DIR__ . '/../../stubs/app/Models/User.php', app_path('Models/User.php'));

        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/app/View/Components', app_path('View/Components'));

        copy(__DIR__ . '/../../stubs/database/migrations/2014_10_12_000000_create_users_table.php', database_path('migrations/2014_10_12_000000_create_users_table.php'));

        copy(__DIR__ . '/../../stubs/app/Http/Kernel.php', app_path('Http/Kernel.php'));

        copy(__DIR__ . '/../../stubs/tailwind.config.js', base_path('tailwind.config.js'));
        copy(__DIR__ . '/../../stubs/webpack.mix.js', base_path('webpack.mix.js'));

        $this->put_permanent_env('DB_DATABASE', 'fresher');
        $this->put_permanent_env('DB_PASSWORD', 'password');

        $this->info('All scaffolding installed successfully.');
        $this->comment('Please execute the "npm install && npm run dev" command to build your assets.');
    }

    protected function updateNodePackages(callable $callback, $dev = true)
    {
        if (!file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL
        );
    }


    public function put_permanent_env($key, $value)
    {
        $path = base_path('.env');

        $escaped = preg_quote('=' . env($key), '/');

        file_put_contents($path, preg_replace(
            "/^{$key}{$escaped}/m",
            "{$key}={$value}",
            file_get_contents($path)
        ));
    }
}
