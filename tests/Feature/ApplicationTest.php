<?php

namespace Tests\Feature;

use App\Models\Application;
use App\Models\Jobpost;
use App\Models\User;
use App\Notifications\ApplicationCancelled;
use App\Notifications\ApplicationStatusChanged;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ApplicationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_show_page_for_an_application_exists()
    {
        $student = factory(User::class)->state('student')->create();
        $application = factory(Application::class)->create([
            'user_id' => $student->id,
        ]);

        $this->actingAs($student)
            ->get(route('applications.show', ['application' => $application->id]))
            ->assertOk();
    }

    /** @test */
    public function the_show_page_requires_authentication()
    {
        $application = factory(Application::class)->create();

        $this->get(route('applications.show', ['application' => $application->id]))
            ->assertRedirect('/login');
    }

    /** @test */
    public function only_the_company_who_posted_the_job_being_applied_to_and_the_applicant_can_visit_the_application_show_page(
    ) {
        $student = factory(User::class)->state('student')->create();
        $company = factory(User::class)->state('company')->create();
        $randomUser = factory(User::class)->state('student')->create();
        $jobpost = factory(Jobpost::class)->create([
            'user_id' => $company->id,
        ]);

        $application = factory(Application::class)->create([
            'user_id' => $student->id,
            'jobpost_id' => $jobpost->id,
        ]);

        $this->actingAs($randomUser)
            ->get(route('applications.show', ['application' => $application->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function a_user_can_cancel_an_application_that_they_sent()
    {
        Notification::fake();

        $student = factory(User::class)->state('student')->create();
        $company = factory(User::class)->state('company')->create();
        $jobpost = factory(Jobpost::class)->create([
            'user_id' => $company->id,
        ]);

        $application = factory(Application::class)->create([
            'user_id' => $student->id,
            'jobpost_id' => $jobpost->id,
        ]);

        $this->actingAs($student)
            ->delete(route('applications.delete', ['application' => $application->id]));

        Notification::assertSentTo($company, ApplicationCancelled::class);

        $this->assertDatabaseHas('applications', [
            'id' => $application->id,
            'is_cancelled' => true,
        ]);
    }

    /** @test */
    public function an_application_can_contain_a_message()
    {
        $student = factory(User::class)->state('student')->create();
        $jobpost = factory(Jobpost::class)->create();

        $this->actingAs($student)
            ->post(route('applications.store'), [
                'user_id' => $student->id,
                'jobpost_id' => $jobpost->id,
                'message' => 'Hello, World!',
            ]);

        $this->assertDatabaseHas('applications', [
            'user_id' => $student->id,
            'jobpost_id' => $jobpost->id,
            'message' => 'Hello, World!',
        ]);
    }

    /** @test */
    public function an_application_status_can_be_changed()
    {
        $student = factory(User::class)->create(['account_type' => 1]);
        $company = factory(User::class)->create(['account_type' => 2]);
        $jobpost = factory(Jobpost::class)->create(['user_id' => $company->id]);

        $application = $student->applyTo($jobpost, 'hello!');
        $company->accept($application);

        $this->actingAs($company)
            ->post(route('applications.change-status', ['application' => $application->id]), [
                'message' => 'This is the reason...'
            ]);

        $this->assertDatabaseHas('applications', [
            'id' => $application->id,
            'accepted' => false,
        ]);
    }

    /** @test */
    public function only_the_company_that_owns_the_jobpost_can_update_the_status_of_a_related_application()
    {
        $student = factory(User::class)->create(['account_type' => 1]);
        $company = factory(User::class)->create(['account_type' => 2]);
        $company2 = factory(User::class)->create(['account_type' => 2]);
        $jobpost = factory(Jobpost::class)->create(['user_id' => $company->id]);

        $application = $student->applyTo($jobpost, 'hello!');
        $company->accept($application);

        $this->actingAs($company2)
            ->post(route('applications.change-status', ['application' => $application->id]), [
                'message' => 'This is the reason...'
            ])->assertStatus(403);
    }

    /** @test */
    public function the_applicant_receives_a_notification_when_their_applications_status_is_changed()
    {
        $student = factory(User::class)->create(['account_type' => 1]);
        $company = factory(User::class)->create(['account_type' => 2]);
        $jobpost = factory(Jobpost::class)->create(['user_id' => $company->id]);

        $application = $student->applyTo($jobpost, 'hello!');
        $company->accept($application);

        $this->expectsNotification($student, ApplicationStatusChanged::class);

        $this->actingAs($company)
            ->post(route('applications.change-status', ['application' => $application->id]), [
                'message' => 'This is the reason...'
            ]);
    }

    /** @test */
    public function status_of_cancelled_applications_cant_be_changed()
    {
        $student = factory(User::class)->create(['account_type' => 1]);
        $company = factory(User::class)->create(['account_type' => 2]);
        $jobpost = factory(Jobpost::class)->create(['user_id' => $company->id]);

        $application = $student->applyTo($jobpost, 'hello!');

        $application->cancel();

        $this->actingAs($company)
            ->post(route('applications.change-status', ['application' => $application->id]), [
                'message' => 'This is the reason...'
            ])->assertStatus(403);
    }
}
