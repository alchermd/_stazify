<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    /**
     * Fields that are NOT mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The job posts that requires this skill.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function jobposts()
    {
        return $this->belongsToMany(Jobpost::class, 'jobpost_skill', 'jobpost_id', 'skill_id');
    }
}
