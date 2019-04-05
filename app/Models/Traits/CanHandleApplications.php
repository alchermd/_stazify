<?php

namespace App\Models\Traits;

use App\Exceptions\ApplicationUpdateException;
use App\Models\Application;
use App\Models\Jobpost;

trait CanHandleApplications
{
    /**
     * Accept a student's application.
     *
     * @param Application $application
     *
     * @throws \Exception
     *
     * @return Application
     */
    public function accept(Application $application)
    {
        if (!$this->isCompany()) {
            throw new \Exception('User is not a company account.');
        }

        if (!$application->user->isStudent()) {
            throw new \Exception('Applicant is not a student account.');
        }

        $application->accepted = true;
        $application->save();

        return $application;
    }

    /**
     * Reject a student's application.
     *
     * @param Application $application
     *
     * @throws \Exception
     *
     * @return Application
     */
    public function reject(Application $application)
    {
        if (!$this->isCompany()) {
            throw new \Exception('User is not a company account.');
        }

        if (!$application->user->isStudent()) {
            throw new \Exception('Applicant is not a student account.');
        }

        $application->accepted = false;
        $application->save();

        return $application;
    }

    /**
     * Fetches all the accepted applications by this company.
     *
     * @throws \Exception
     *
     * @return \Illuminate\Support\Collection
     */
    public function acceptedApplications()
    {
        if (!$this->isCompany()) {
            throw new \Exception('User is not a company account.');
        }

        $applications = collect();
        $this->jobposts->each(function (Jobpost $jobpost) use ($applications) {
            $jobpost->applications
                ->filter(function (Application $application) {
                    return $application->isAccepted();
                })
                ->each(function (Application $application) use ($applications) {
                    $applications->push($application);
                });
        });

        return $applications;
    }

    /**
     * Fetches all the rejected applications by this company.
     *
     * @throws \Exception
     *
     * @return \Illuminate\Support\Collection
     */
    public function rejectedApplications()
    {
        if (!$this->isCompany()) {
            throw new \Exception('User is not a company account.');
        }

        $applications = collect();
        $this->jobposts->each(function (Jobpost $jobpost) use ($applications) {
            $jobpost->applications
                ->filter(function (Application $application) {
                    return $application->isRejected() || $application->isCancelled();
                })
                ->each(function (Application $application) use ($applications) {
                    $applications->push($application);
                });
        });

        return $applications;
    }

    /**
     * Fetches all the pending applications for this company.
     *
     * @throws \Exception
     *
     * @return \Illuminate\Support\Collection
     */
    public function pendingApplications()
    {
        if (!$this->isCompany()) {
            throw new \Exception('User is not a company account.');
        }

        $applications = collect();
        $this->jobposts->each(function (Jobpost $jobpost) use ($applications) {
            $jobpost->applications
                ->filter(function (Application $application) {
                    return $application->isPending();
                })
                ->each(function (Application $application) use ($applications) {
                    $applications->push($application);
                });
        });

        return $applications;
    }

    /**
     * Set an application's status.
     *
     * @param Application $application
     * @param bool $status
     * @param string|null $message
     * @throws ApplicationUpdateException
     */
    public function setStatus(Application $application, bool $status, string $message = null)
    {
        if ($application->accepted === $status) {
            throw new ApplicationUpdateException(
                'The application is already ' . $application->accepted ? 'accepted' : 'rejected'
            );
        }

        $application->update([
            'accepted' => $status
        ]);

        $application->changelogs()->create([
            'message' => sprintf('Change status to %s. %s', $status ? 'accepted' : 'rejected', $message)
        ]);
    }
}
