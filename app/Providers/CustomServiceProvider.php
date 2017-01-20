<?php
namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use App\Services\RolesService;
use App\Services\AppAuthService;
use App\Services\RbacService;

/**
 * Register our Repository with Laravel
 */
class CustomServiceProvider extends ServiceProvider
{
    /**
     * Registers Interfaces and Classes with Laravel's IoC Container
     *
     */
    public function register()
    {
        App::bind('RolesService', function()
        {
            return new RolesService();
        });

        App::bind('AppAuthService', function()
        {
            return new AppAuthService();
        });

        App::bind('RbacService', function()
        {
            return new RbacService();
        });

    }
}