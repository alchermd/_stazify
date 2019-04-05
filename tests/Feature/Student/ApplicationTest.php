<?php

namespace Tests\Feature\Student;

use App\Models\Jobpost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApplicationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_see_the_pending_rejected_and_accepted_applications_on_their_dashboard()
    {
        $student = factory(User::class)->state('student')->create();
        $company = factory(User::class)->state('company')->create();
        $jobposts = factory(Jobpost::class, 3)->create(['user_id' => $company->id]);

        $applications = $jobposts->map(function (Jobpost $jobpost) use ($student) {
            return $student->applyTo($jobpost);
        });

        $company->accept($applications[1]);
        $company->reject($applications[2]);

        $this->actingAs($student)
            ->get('/home')
            ->assertSee('Pending Applications')
            ->assertSee('Accepted Applications')
            ->assertSee('Rejected Applications')
            ->assertSee($jobposts[0]->title)
            ->assertSee($jobposts[1]->title)
            ->assertSee($jobposts[2]->title);
    }

    /** @test */
    public function it_can_see_a_text_stating_that_there_are_no_jobs_available_if_there_are_none()
    {
        $student = factory(User::class)->state('student')->create();

        $this->actingAs($student)
            ->get('/home/jobs')
            ->assertSee('No jobs available. Maybe try another time?');
    }
}
