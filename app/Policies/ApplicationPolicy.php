<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the application.
     *
     * @param User $user
     * @param Application $application
     * @return bool
     */
    public function view(User $user, Application $application)
    {
        return collect([$application->user->id, $application->jobpost->user->id])->contains($user->id);
    }

    /**
     * Determine whether a
     *
     * @param User $user
     * @param Application $application
     * @return bool
     */
    public function changeStatus(User $user, Application $application)
    {
        return $user->isCompany() && $user->jobposts->contains($application->jobpost);
    }
}
