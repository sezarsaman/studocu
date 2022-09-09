<?php

namespace App\Providers;

use App\Repositories\Contracts\FlashcardRepositoryInterface;
use App\Repositories\Contracts\TrackingCodeRepositoryInterface;
use App\Repositories\Eloquent\FlashcardEloquentRepository;
use App\Repositories\Eloquent\TrackingCodeEloquentRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            FlashcardRepositoryInterface::class,
            FlashcardEloquentRepository::class
        );

        $this->app->bind(
            TrackingCodeRepositoryInterface::class,
            TrackingCodeEloquentRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
