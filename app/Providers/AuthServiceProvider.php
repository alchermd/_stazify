<?php

namespace App\Providers;

use App\Models\Application;
use App\Models\Message;
use App\Models\User;
use App\Models\VerificationRequest;
use App\Policies\ApplicationPolicy;
use App\Policies\CompanyRatingPolicy;
use App\Policies\MessagePolicy;
use App\Policies\VerificationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Message::class => MessagePolicy::class,
        Application::class => ApplicationPolicy::class,
        VerificationRequest::class => VerificationPolicy::class,
        User::class => CompanyRatingPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
