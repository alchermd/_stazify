<?php

namespace App\Providers;

use App\Models\Message;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View as BaseView;
use Laravel\Telescope\TelescopeServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer(['messages.includes.sidebar', 'layouts.includes.second-header'], function (BaseView $view) {
            return $view->with([
                'unreadMessagesCount' => auth()->user()->messages->filter(function (Message $message) {
                    return is_null($message->read_at);
                })->count(),
                'sentMessagesCount' => auth()->user()->sentMessages()->withTrashed()->count(),
                'trashedMessagesCount' => auth()->user()->trashedMessages()->count(),
            ]);
        });
    }

    /**
     * Register any application services.
     */
    public function register()
    {
	if ($this->app->isLocal()) {
        $this->app->register(TelescopeServiceProvider::class);
    }
    }
}
