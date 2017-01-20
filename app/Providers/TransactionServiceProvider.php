<?php

namespace App\Providers;

use App\Services\TransactionService;
use Illuminate\Support\ServiceProvider;

class TransactionServiceProvider extends ServiceProvider
{
    protected $defer = true;
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('TransactionService', function() {
            return new TransactionService();
        });
    }

    public function provides()
    {
        return ['TransactionService'];
    }}
