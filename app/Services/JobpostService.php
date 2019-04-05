<?php

namespace App\Services;

use Carbon\Carbon;

class JobpostService
{
    /**
     * Builds up the necessary job post data from the validated payload.
     *
     * @param array $validatedData
     *
     * @return array
     */
    public function buildJobpostData(array $validatedData)
    {
        $jobpostData = [
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'preferred_applicants' => $validatedData['preferred_applicants'] ?? null
        ];

        // Serialize the new-line separated payload for the qualifications.
        $jobpostData['qualifications'] = json_encode(explode("\r\n", $validatedData['qualifications']));

        // Parse the date fragments to a Carbon instance.
        $dateString = $validatedData['deadline_month'] . '/' . $validatedData['deadline_day'] . '/' . $validatedData['deadline_year'];
        $jobpostData['deadline'] = Carbon::parse($dateString);

        return $jobpostData;
    }

    /**
     * Determine if the given deadline has already elapsed.
     *
     * @param $deadline
     * @return bool
     */
    public function checkIfDeadlineHasElapsed($deadline)
    {
        return Carbon::now()->gte($deadline);
    }
}
