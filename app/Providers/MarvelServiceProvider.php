<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MarvelServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   *
   * @return void
   */
  public function register()
  {
    $this->app->bind('Marvel', function () {
      return new \App\Services\Marvel;
    });
  }

  /**
   * Bootstrap services.
   *
   * @return void
   */
  public function boot()
  {
    //
  }
}
