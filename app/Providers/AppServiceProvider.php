<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace App\Providers;

use App\Repositories\LinksRepository;
use CodeUp\ReadIt\Links\Links;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Bind `Links` with Eloquent implementation
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Links::class, LinksRepository::class);
    }
}
