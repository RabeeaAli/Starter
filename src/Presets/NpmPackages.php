<?php

namespace Starter\Presets;

class NpmPackages
{
    public static function install()
    {
        static::updateNodePackages(function ($packages) {
            return [
                '@tailwindcss/forms' => '^0.2.1',
                'alpinejs' => '^2.7.3',
                'autoprefixer' => '^10.1.0',
                'postcss' => '^8.2.1',
                'postcss-import' => '^12.0.1',
                'tailwindcss' => '^2.0.2',
            ] + $packages;
        });
    }

    protected static function updateNodePackages(callable $callback, $dev = true)
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
}
