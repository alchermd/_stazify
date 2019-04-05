<?php

namespace App\Models;

use App\Models\Traits\CanHandleApplications;
use App\Models\Traits\CanMakeApplications;
use App\Models\Traits\HasMessages;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasMessages, CanHandleApplications, CanMakeApplications;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the data for a user's dashboard page.
     *
     * @param User $user
     *
     * @return array
     */
    public static function getHomeData(User $user) : array
    {
        $data = [];

        if ($user->isCompany()) {
            $company = $user;

            $data['jobsPostedCount'] = $company->jobposts->count();
            $data['applicationCount'] = $company
                ->jobposts
                ->reduce(function ($prev, $jobpost) {
                    return $jobpost->applications->filter(function (Application $application) {
                            return $application->isPending();
                        })->count() + $prev;
                }, 0);
        } else if ($user->isStudent()) {
            $student = $user;

            $data['pendingApplications'] = $student->applications->filter(function (Application $application) {
                return $application->isPending();
            });

            $data['acceptedApplications'] = $student->applications->filter(function (Application $application) {
                return $application->isAccepted();
            });

            $data['rejectedApplications'] = $student->applications->filter(function (Application $application) {
                return $application->isRejected();
            });
        }

        return $data;
    }

    /**
     * Determines if the user is a company account.
     *
     * @return bool
     */
    public function isCompany()
    {
        return 2 == $this->account_type;
    }

    /**
     * Determines if the user is a student account.
     *
     * @return bool
     */
    public function isStudent()
    {
        return 1 == $this->account_type;
    }

    /**
     * Get the applications that a company has received.
     * The applications are ordered in reversed chronological order.
     *
     * @param User $company
     *
     * @return Collection
     * @throws \Exception
     */
    public static function getApplicationsReceived(User $company)
    {
        return $company->pendingApplications()->reject(function (Application $application) {
            return ! is_null($application->accepted);
        })->sortByDesc('created_at');
    }

    /**
     * Get the active applications that a student has sent.
     * The applications are ordered in reversed chronological order.
     *
     * @param User $student
     *
     * @return mixed
     */
    public static function getActiveApplicationsSent(User $student)
    {
        return $student->applications->reject->is_cancelled->sortByDesc('created_at');
    }

    /**
     * The job posts that this company created.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jobposts()
    {
        return $this->hasMany(Jobpost::class);
    }

    /**
     * The applications that this student posted.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Name of the account type.
     *
     * @return string
     */
    public function accountTypeName()
    {
        return 1 == $this->account_type ? 'Student' : 'Company';
    }

    /**
     * The course that this student is enrolled to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * The industry that this company belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }

    /**
     * This student's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Determine a name for this model depending on the account type.
     *
     * @return mixed|string|null
     */
    public function getNameAttribute()
    {
        if ($this->isStudent()) {
            return $this->full_name;
        }

        if ($this->isCompany()) {
            return $this->company_name;
        }
    }

    /**
     * The verification requests this company has requested.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function verificationRequests()
    {
        return $this->hasMany(VerificationRequest::class, 'company_id');
    }

    /**
     * Determine if this company is verified.
     *
     * @return bool
     */
    public function isCompanyVerified()
    {
        return $this->company_verified_at != null;
    }

    /**
     * Helper method to get a company's posted jobposts or a student's eligible jobs.
     *
     * @return Jobpost[]|\Illuminate\Database\Eloquent\Collection|Collection|mixed
     */
    public function getJobposts()
    {
        if ($this->isCompany()) {
            return $this->jobposts->sortByDesc('created_at');
        } else {
            if ($this->isStudent()) {
                return static::getEligibleJobs($this);
            }
        }
    }

    /**
     * Get the jobs in which a user is eligible to apply with.
     *
     * @param User $user
     *
     * @return Jobpost[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getEligibleJobs(User $user) : Collection
    {
        return Jobpost::whereNull('closed_at')
            ->orderBy('created_at', 'desc')
            ->get()
            ->reject(function ($jobpost) use ($user) {
                return $user->applications->contains('jobpost_id', $jobpost->id);
            });
    }

    /**
     * Gets the collective views of this company's jobposts.
     *
     * @return int
     */
    public function getJobpostViewsAttribute()
    {
        return $this->jobposts->reduce(function ($prev, $jobpost) {
            return $prev + $jobpost->views;
        }, 0);
    }

    /**
     * Like a company.
     *
     * @param \App\Models\User $company
     *
     * @return \App\Models\User
     */
    public function like(User $company)
    {
        $this->likes()->syncWithoutDetaching([$company->id => ['is_liked' => true]]);

        return $this;
    }

    /**
     * Unlike a company.
     *
     * @param \App\Models\User $company
     *
     * @return \App\Models\User
     */
    public function unlike(User $company)
    {
        $this->likes()->detach([$company->id]);

        return $this;
    }

    /**
     * The companies that this student likes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likes()
    {
        return $this->belongsToMany(User::class, "likes", "student_id", "company_id");
    }

    /**
     * The students that liked this company.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likers()
    {
        return $this->belongsToMany(User::class, "likes",  "company_id", "student_id");
    }
}
