<?php
/**
 * PHP version 5.6
 *
 * This source file is subject to the license that is bundled with this package in the file LICENSE.
 */
namespace App\Providers;

use App\Http\Controllers\VoteLinkAction;
use App\Repositories\LinksRepository;
use App\Repositories\VotesRepository;
use Auth;
use CodeUp\ReadIt\Links\Links;
use CodeUp\ReadIt\Links\Votes;
use CodeUp\ReadIt\Readitors\DownvoteLink;
use CodeUp\ReadIt\Readitors\UpvoteLink;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('partials.nav', function(View $view) {
            $view->with('readitor', Auth::user());
        });
    }

    /**
     * Bind `Links` with Eloquent implementation
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Links::class, LinksRepository::class);
        $this->app->bind(Votes::class, VotesRepository::class);
        $this->app->bind('\App\Http\Controllers\UpvoteLinkAction', function() {
            return new VoteLinkAction($this->app->make(UpvoteLink::class));
        });
        $this->app->bind('\App\Http\Controllers\DownvoteLinkAction', function() {
            return new VoteLinkAction($this->app->make(DownvoteLink::class));
        });
    }
}
