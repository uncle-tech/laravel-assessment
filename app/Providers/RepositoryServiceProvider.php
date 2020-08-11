<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\ToursRepository;
use App\Repositories\Tours;

class RepositoryServiceProvider extends ServiceProvider
{
    protected function bindToursRepository()
    {
        $this->app->bind(
            ToursRepository::class,
            Tours::class
        );
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->bindToursRepository();
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
