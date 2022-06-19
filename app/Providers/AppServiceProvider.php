<?php

namespace App\Providers;

use App\Contracts\Repositories\LinksRepositoryInterface;
use App\Contracts\Repositories\LinkViewsRepositoryInterface;
use App\Contracts\Services\LinksServiceInterface;
use App\Repositories\LinksRepository;
use App\Repositories\LinkViewsRepository;
use App\Services\LinksService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(LinksRepositoryInterface::class, LinksRepository::class);
        $this->app->bind(LinkViewsRepositoryInterface::class, LinkViewsRepository::class);
        $this->app->bind(LinksServiceInterface::class, LinksService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
