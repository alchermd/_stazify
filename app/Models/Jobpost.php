<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Jobpost extends Model
{
    /**
     * Fields that are NOT mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Fields that are casted to date.
     *
     * @var array
     */
    protected $dates = ['deadline'];

    /**
     * Custom table name.
     *
     * @var string
     */
    protected $table = 'jobposts';

    /**
     * The required skills for this jobpost.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'jobpost_skill', 'jobpost_id', 'skill_id');
    }

    /**
     * The company that posted this jobpost.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The applications for this jobpost.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Determine if the jobpost is closed.
     *
     * @return bool
     */
    public function isClosed()
    {
        return !is_null($this->closed_at);
    }

    /**
     * Mark the jobpost as closed.
     *
     * @return $this
     */
    public function markAsClosed()
    {
        $this->closed_at = Carbon::now();
        $this->save();

        return $this;
    }

    /**
     * Get the preferred applicants for this jobpost.
     *
     * @return int|null
     */
    public function getPreferredApplicants(): ?int
    {
        return $this->preferred_applicants;
    }
}
