<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    /** @var bool */
    const ACCEPTED = true;

    /** @var bool */
    const REJECTED = false;

    /**
     * Attributes to be casted.
     *
     * @var array
     */
    protected $casts = [
        'accepted' => 'boolean',
        'is_cancelled' => 'boolean'
    ];
    /**
     * Fields that are NOT mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The job post applied to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jobpost()
    {
        return $this->belongsTo(Jobpost::class);
    }

    /**
     * The student that applied.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Determine if this application is still pending.
     *
     * @return bool
     */
    public function isPending()
    {
        return null === $this->accepted;
    }

    /**
     * Determine if this application is already accepted.
     *
     * @return bool
     */
    public function isAccepted()
    {
        return true === $this->accepted;
    }

    /**
     * Determine if this application is already rejected.
     *
     * @return bool
     */
    public function isRejected()
    {
        return false === $this->accepted;
    }

    /**
     * Fetches the company that posted this application.
     *
     * @return User
     */
    public function getCompany()
    {
        return $this->jobpost->user;
    }

    /**
     * Mark the application as cancelled.
     *
     * @return $this
     */
    public function cancel()
    {
        $this->update([
            'is_cancelled' => true,
            'accepted' => false
        ]);

        return $this;
    }

    /**
     * Determine if the application is cancelled.
     *
     * @return bool
     */
    public function isCancelled()
    {
        return $this->is_cancelled === true;
    }

    /**
     * The logs of the changes that happened to this application.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function changelogs()
    {
        return $this->hasMany(Changelog::class);
    }
}
