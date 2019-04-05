<?php

namespace Tests\Unit;

use App\Models\Application;
use App\Models\Jobpost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_accept_applications()
    {
        $student = factory(User::class)->state('student')->create();
        $company = factory(User::class)->state('company')->create();
        $jobpost = factory(Jobpost::class)->create(['user_id' => $company->id]);

        $application = $student->applyTo($jobpost);
        $company->accept($application);

        $this->assertTrue($application->accepted);
    }

    /** @test */
    public function can_reject_applications()
    {
        $student = factory(User::class)->state('student')->create();
        $company = factory(User::class)->state('company')->create();
        $jobpost = factory(Jobpost::class)->create(['user_id' => $company->id]);

        $application = $student->applyTo($jobpost);
        $company->reject($application);

        $this->assertFalse($application->accepted);
    }

    /** @test */
    public function it_can_fetch_all_the_accepted_applications()
    {
        $students = factory(User::class, 4)->state('student')->create();
        $company = factory(User::class)->state('company')->create();
        $jobpost = factory(Jobpost::class)->create(['user_id' => $company->id]);

        $applications = $students->map(function (User $student) use ($jobpost) {
            return $student->applyTo($jobpost);
        });

        $applications->each(function (Application $application) use ($company) {
            $company->accept($application);
        });

        $this->assertCount(4, $company->acceptedApplications());
    }

    /** @test */
    public function it_can_fetch_all_the_rejected_applications()
    {
        $students = factory(User::class, 4)->state('student')->create();
        $company = factory(User::class)->state('company')->create();
        $jobpost = factory(Jobpost::class)->create(['user_id' => $company->id]);

        $applications = $students->map(function (User $student) use ($jobpost) {
            return $student->applyTo($jobpost);
        });

        $applications->each(function (Application $application) use ($company) {
            $company->reject($application);
        });

        $this->assertCount(4, $company->rejectedApplications());
    }

    /** @test */
    public function it_can_fetch_all_the_pending_applications()
    {
        $students = factory(User::class, 4)->state('student')->create();
        $company = factory(User::class)->state('company')->create();
        $jobpost = factory(Jobpost::class)->create(['user_id' => $company->id]);

        $students->each(function (User $student) use ($jobpost) {
            $student->applyTo($jobpost);
        });

        $this->assertCount(4, $company->pendingApplications());
    }

    /** @test */
    public function it_can_get_the_total_views_of_its_jobposts()
    {
        $company = factory(User::class)->state('company')->create();
        factory(Jobpost::class)->create([
            'user_id' => $company->id,
            'views' => 404
        ]);
        factory(Jobpost::class)->create([
            'user_id' => $company->id,
            'views' => 419
        ]);
        factory(Jobpost::class)->create([
            'user_id' => $company->id,
            'views' => 200
        ]);

        $this->assertEquals(1023, $company->jobpost_views);
    }
}
