<?php

namespace App\Policies;

use App\Models\User;

class CompanyRatingPolicy
{
    /**
     * Determine whether a user can like a company.
     *
     * @param \App\Models\User $liker
     * @param \App\Models\User $likee
     *
     * @return bool
     */
    public function like(User $liker, User $likee)
    {
        return $liker->isStudent() && $likee->isCompany();
    }

    /**
     * Determine whether a user can unlike a company.
     *
     * @param \App\Models\User $liker
     * @param \App\Models\User $likee
     *
     * @return bool
     */
    public function unlike(User $liker, User $likee)
    {
        return $liker->isStudent() && $likee->isCompany();
    }
}
