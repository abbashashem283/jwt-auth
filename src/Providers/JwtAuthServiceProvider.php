<?php

namespace DevCraft\JwtAuth\Providers;


use Illuminate\Support\ServiceProvider;
use DevCraft\JwtAuth\Commands\JwtSecretGenerate;
use DevCraft\JwtAuth\JwtGuard;
use DevCraft\JwtAuth\JwtService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;



class JwtAuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        $this->publishes([
            __DIR__.'/../../config/jwt-auth.php' => config_path('jwt-auth.php'),
        ], 'jwt-auth');

        if ($this->app->runningInConsole()) {
            $this->commands([
                JwtSecretGenerate::class,
            ]);
        }

        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        Auth::extend('jwt', function ($app, $name, array $config) {
            $provider = Auth::createUserProvider($config['provider']);
            $request = $app['request'];
            $jwtService = $app->make(JwtService::class);
            return new JwtGuard($provider, $request, $jwtService);
        });
    }
}
