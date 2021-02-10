<?php

namespace Starter\Presets;

use Illuminate\Filesystem\Filesystem;

class FilesCopy
{
    public static function install()
    {
        static::deleteWelcomePage();
        static::controllers();
        static::requests();
        static::resources();
        static::routes();
        static::providers();
        static::middleware();
        static::models();
        static::viewComponents();
        static::migrations();
        static::updateKernel();
        static::tailwindAndWebpack();
        static::database();
    }

    public static function deleteWelcomePage()
    {
        (new Filesystem)->delete(resource_path('views/welcome.blade.php'));
    }

    public static function controllers()
    {
        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/App/Http/Controllers/Frontend', app_path('Http/Controllers/Frontend'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/App/Http/Controllers/Backend', app_path('Http/Controllers/Backend'));
    }

    public static function requests()
    {
        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/App/Http/Requests/Auth', app_path('Http/Requests/Auth'));
    }

    public static function resources()
    {
        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/resources/views', resource_path('views'));

        copy(__DIR__ . '/../../stubs/resources/css/app.css', resource_path('css/app.css'));
        copy(__DIR__ . '/../../stubs/resources/js/app.js', resource_path('js/app.js'));
    }

    public static function routes()
    {
        copy(__DIR__ . '/../../stubs/routes/web.php', base_path('routes/web.php'));
        copy(__DIR__ . '/../../stubs/routes/auth.php', base_path('routes/auth.php'));
        copy(__DIR__ . '/../../stubs/routes/admin.php', base_path('routes/admin.php'));
        copy(__DIR__ . '/../../stubs/routes/user.php', base_path('routes/user.php'));
    }

    public static function providers()
    {
        copy(__DIR__ . '/../../stubs/App/Providers/RouteServiceProvider.php', app_path('Providers/RouteServiceProvider.php'));
    }

    public static function middleware()
    {
        copy(__DIR__ . '/../../stubs/App/Http/Middleware/admin.php', app_path('Http/Middleware/admin.php'));
    }

    public static function models()
    {
        copy(__DIR__ . '/../../stubs/App/Models/User.php', app_path('Models/User.php'));
    }

    public static function viewComponents()
    {
        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/App/View/Components', app_path('View/Components'));
    }

    public static function migrations()
    {
        copy(__DIR__ . '/../../stubs/database/migrations/2014_10_12_000000_create_users_table.php', database_path('migrations/2014_10_12_000000_create_users_table.php'));
    }

    public static function updateKernel()
    {
        copy(__DIR__ . '/../../stubs/App/Http/Kernel.php', app_path('Http/Kernel.php'));
    }

    public static function tailwindAndWebpack()
    {
        copy(__DIR__ . '/../../stubs/tailwind.config.js', base_path('tailwind.config.js'));
        copy(__DIR__ . '/../../stubs/webpack.mix.js', base_path('webpack.mix.js'));
    }

    public static function database()
    {
        static::put_permanent_env('DB_DATABASE', 'fresher');
        static::put_permanent_env('DB_PASSWORD', 'password');
    }

    public static function put_permanent_env($key, $value)
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
