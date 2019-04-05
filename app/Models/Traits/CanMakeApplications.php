<?php
/**
 * Created by PhpStorm.
 * User: alchermd
 * Date: 1/26/19
 * Time: 7:13 PM
 */

namespace App\Models\Traits;

use App\Models\Application;
use App\Models\Jobpost;

trait CanMakeApplications
{
    /**
     * Apply to a jobpost.
     *
     * @param Jobpost $jobpost
     * @param $message
     *
     * @return Application|\Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public function applyTo(Jobpost $jobpost, string $message = null)
    {
        if (!$this->isStudent()) {
            throw new \Exception('User is not a student account.');
        }

        return Application::create([
            'user_id' => $this->id,
            'jobpost_id' => $jobpost->id,
            'message' => $message
        ]);
    }
}
