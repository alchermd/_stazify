<?php

namespace App\Services;

use App\Models\Jobpost;
use App\Models\Skill;

class JobpostFormatService
{
    /** @var Jobpost */
    private $jobpost;

    /**
     * JobpostFormatService constructor.
     *
     * @param Jobpost $jobpost
     */
    public function __construct(Jobpost $jobpost)
    {
        $this->jobpost = $jobpost;
    }

    /**
     * Render this jobpost's qualifications.
     */
    public function renderQualifications()
    {
        foreach (json_decode($this->jobpost->qualifications) as $qualification) {
            echo "{$qualification}\n";
        }
    }

    /**
     * Render this jobpost's required skills.
     */
    public function renderSkills()
    {
        $this->jobpost->skills->each(function (Skill $skill) {
            echo "{$skill->name}\n";
        });
    }
}
