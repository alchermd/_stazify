<?php

namespace Tests\Feature\Company;

use App\Models\Application;
use App\Models\Jobpost;
use App\Notifications\ApplicationAccepted;
use App\Notifications\ApplicationRejected;
use App\Notifications\ApplicationSent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ApplicationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_see_the_number_of_applications_on_their_dashboard()
    {
        $students = factory(User::class, 12)->state('student')->create();
        $company = factory(User::class)->state('company')->create();
        $jobpost = factory(Jobpost::class)->create(['user_id' => $company->id]);

        $students->each(function (User $student) use ($jobpost) {
            $student->applyTo($jobpost);
        });

        $this->actingAs($company)
            ->get('/home')
            ->assertSee('12');
    }

    /** @test */
    public function it_can_see_all_the_applications_made_on_their_job_posts_on_the_applications_page()
    {
        $students = factory(User::class, 3)->state('student')->create();
        $company = factory(User::class)->state('company')->create();
        $jobpost = factory(Jobpost::class)->create(['user_id' => $company->id]);

        $students->each(function (User $student) use ($jobpost) {
            $student->applyTo($jobpost);
        });

        $this->actingAs($company)
            ->get('/home/applications')
            ->assertSee($jobpost->title)
            ->assertSee('3 applicants')
            ->assertSee($students[0]->first_name)
            ->assertSee($students[1]->first_name)
            ->assertSee($students[2]->first_name);
    }

    /** @test */
    public function it_can_accept_a_students_application_to_their_jobpost()
    {
        [$student, $company, $jobpost] = $this->jobpostSetup();

        $application = $student->applyTo($jobpost);

        $this->actingAs($company)
            ->post("/home/applications/{$application->id}/accept", [
                'student_id' => $student->id,
            ])
            ->assertRedirect('/home');

        $this->assertTrue($application->fresh()->isAccepted());
    }

    /**
     * Helper method for setting up a jobpost scenario.
     *
     * @return array
     */
    private function jobpostSetup()
    {
        return [
            factory(User::class)->state('student')->create(),
            $company = factory(User::class)->state('company')->create(),
            factory(Jobpost::class)->create(['user_id' => $company->id]),
        ];
    }

    /** @test */
    public function it_can_see_the_updated_number_of_applications_after_accepting_an_application()
    {
        [$student, $company, $jobpost] = $this->jobpostSetup();

        $application = $student->applyTo($jobpost);
        $company->accept($application);

        $this->actingAs($company)
            ->get('/home')
            ->assertSeeInOrder(['0', 'Applications']);
    }

    /** @test */
    public function it_wont_see_accepted_applications_on_the_applications_page()
    {
        [$student, $company, $jobpost] = $this->jobpostSetup();

        $application = $student->applyTo($jobpost);
        $company->accept($application);

        $this->actingAs($company)
            ->get('/home/applications')
            ->assertSee('No active applicants.');
    }

    /** @test */
    public function it_can_reject_a_students_application_to_their_jobpost()
    {
        [$student, $company, $jobpost] = $this->jobpostSetup();

        $application = $student->applyTo($jobpost);

        $this->actingAs($company)
            ->post("/home/applications/{$application->id}/reject", [
                'student_id' => $student->id,
            ])
            ->assertRedirect('/home');

        $this->assertTrue($application->fresh()->isRejected());
    }

    /** @test */
    public function it_can_see_the_updated_number_of_applications_after_rejecting_an_application()
    {
        [$student, $company, $jobpost] = $this->jobpostSetup();

        $application = $student->applyTo($jobpost);
        $company->reject($application);

        $this->actingAs($company)
            ->get('/home')
            ->assertSeeInOrder(['0', 'Applications']);
    }

    /** @test */
    public function it_wont_see_rejected_applications_on_the_applications_page()
    {
        [$student, $company, $jobpost] = $this->jobpostSetup();

        $application = $student->applyTo($jobpost);
        $company->reject($application);

        $this->actingAs($company)
            ->get('/home/applications')
            ->assertSee('No active applicants.');
    }

    /** @test */
    public function it_can_see_a_section_of_rejected_applicants_on_their_dashboard()
    {
        $company = factory(User::class)->state('company')->create();
        $students = factory(User::class, 4)->state('student')->create();
        $jobpost = factory(Jobpost::class)->create(['user_id' => $company->id]);

        $applications = $students->map(function (User $student) use ($jobpost) {
            return $student->applyTo($jobpost);
        });

        $company->accept($applications[0]);
        $company->accept($applications[1]);
        $company->reject($applications[2]);
        $company->reject($applications[3]);

        $this->actingAs($company)
            ->get('/home')
            ->assertSeeInOrder(['Accepted Applicants', $applications[0]->user->first_name])
            ->assertSeeInOrder(['Accepted Applicants', $applications[1]->user->first_name])
            ->assertSeeInOrder(['Rejected Applicants', $applications[2]->user->first_name])
            ->assertSeeInOrder(['Rejected Applicants', $applications[3]->user->first_name]);
    }

    /** @test */
    public function a_company_receives_a_notification_if_one_of_their_jobpost_gets_an_application()
    {
        Notification::fake();

        [$student, $company, $jobpost] = $this->jobpostSetup();

        $this->actingAs($student)
            ->post('/home/applications', [
                'user_id' => $student->id,
                'jobpost_id' => $jobpost->id,
            ]);

        Notification::assertSentTo(
            $company,
            ApplicationSent::class
        );
    }

    /** @test */
    public function a_student_gets_a_notification_if_their_application_is_accepted()
    {
        Notification::fake();

        [$student, $company, $jobpost] = $this->jobpostSetup();

        $this->actingAs($student)
            ->post('/home/applications', [
                'user_id' => $student->id,
                'jobpost_id' => $jobpost->id,
            ]);

        $application = Application::where('user_id', '=', $student->id)
            ->where('jobpost_id', '=', $jobpost->id)
            ->first();

        $this->actingAs($company)
            ->post("/home/applications/{$application->id}/accept", [
                'student_id' => $student->id,
            ]);

        Notification::assertSentTo(
            $student,
            ApplicationAccepted::class
        );
    }

    /** @test */
    public function a_student_gets_a_notification_if_their_application_is_rejected()
    {
        Notification::fake();

        [$student, $company, $jobpost] = $this->jobpostSetup();

        $this->actingAs($student)
            ->post('/home/applications', [
                'user_id' => $student->id,
                'jobpost_id' => $jobpost->id,
            ]);

        $application = Application::where('user_id', '=', $student->id)
            ->where('jobpost_id', '=', $jobpost->id)
            ->first();

        $this->actingAs($company)
            ->post("/home/applications/{$application->id}/reject", [
                'student_id' => $student->id,
            ]);

        Notification::assertSentTo(
            $student,
            ApplicationRejected::class
        );
    }
}
