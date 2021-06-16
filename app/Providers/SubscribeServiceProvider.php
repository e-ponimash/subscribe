<?php

namespace App\Providers;

use App\Services\Subscribe\SubscribeInterface;
use App\Services\Subscribe\SubscribeService;
use Illuminate\Support\ServiceProvider;

class SubscribeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SubscribeInterface::class, function ( $app){
            return new SubscribeService();
        });
    }
}
