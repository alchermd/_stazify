<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VerificationRequest;
use Illuminate\Auth\Access\HandlesAuthorization;

class VerificationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create verification requests.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->account_type === 2;
    }
}
