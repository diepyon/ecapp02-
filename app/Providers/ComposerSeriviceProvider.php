<?php

namespace App\Providers;

use View;
use Illuminate\Support\ServiceProvider;
use App\Http\ViewComposers\CartComposer;
use App\Http\ViewComposers\ListComposer;

class ComposerSeriviceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composers([
          CartComposer::class => [
            '*'
          ]
      ]);
      View::composers([
        ListComposer::class => [
          '*'
        ]
    ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
