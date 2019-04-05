<?php

namespace Tests\Unit;

use App\Exceptions\ApplicationUpdateException;
use App\Models\Application;
use App\Models\Jobpost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApplicationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function isPending_works_accordingly()
    {
        $student = factory(User::class)->create(['account_type' => 1]);
        $company = factory(User::class)->create(['account_type' => 2]);
        $jobpost = factory(Jobpost::class)->create(['user_id' => $company->id]);

        $application = $student->applyTo($jobpost);

        $this->assertTrue($application->isPending());
    }

    /** @test */
    public function isAccepted_works_accordingly()
    {
        $student = factory(User::class)->create(['account_type' => 1]);
        $company = factory(User::class)->create(['account_type' => 2]);
        $jobpost = factory(Jobpost::class)->create(['user_id' => $company->id]);

        $application = $student->applyTo($jobpost);
        $company->accept($application);

        $this->assertTrue($application->isAccepted());
    }

    /** @test */
    public function isRejected_works_accordingly()
    {
        $student = factory(User::class)->create(['account_type' => 1]);
        $company = factory(User::class)->create(['account_type' => 2]);
        $jobpost = factory(Jobpost::class)->create(['user_id' => $company->id]);

        $application = $student->applyTo($jobpost);
        $company->reject($application);

        $this->assertTrue($application->isRejected());
    }

    /** @test */
    public function can_get_the_company_who_posted_it()
    {
        $student = factory(User::class)->create(['account_type' => 1]);
        $company = factory(User::class)->create(['account_type' => 2]);
        $jobpost = factory(Jobpost::class)->create(['user_id' => $company->id]);

        $application = $student->applyTo($jobpost);

        $this->assertEquals($company->id, $application->getCompany()->id);
    }

    /** @test */
    public function it_can_be_cancelled()
    {
        $student = factory(User::class)->create(['account_type' => 1]);
        $company = factory(User::class)->create(['account_type' => 2]);
        $jobpost = factory(Jobpost::class)->create(['user_id' => $company->id]);

        $application = $student->applyTo($jobpost);

        $application->cancel();

        $this->assertTrue($application->is_cancelled);
    }

    /** @test */
    public function it_can_determine_if_its_cancelled()
    {
        $student = factory(User::class)->create(['account_type' => 1]);
        $company = factory(User::class)->create(['account_type' => 2]);
        $jobpost = factory(Jobpost::class)->create(['user_id' => $company->id]);

        $application = $student->applyTo($jobpost);
        $this->assertFalse($application->isCancelled());

        $application->cancel();

        $this->assertTrue($application->isCancelled());
    }

    /** @test */
    public function a_cancelled_application_is_also_marked_as_rejected()
    {
        $student = factory(User::class)->create(['account_type' => 1]);
        $company = factory(User::class)->create(['account_type' => 2]);
        $jobpost = factory(Jobpost::class)->create(['user_id' => $company->id]);

        $application = $student->applyTo($jobpost);
        $this->assertFalse($application->isRejected());

        $application->cancel();
        $this->assertTrue($application->isRejected());
    }

    /** @test */
    public function it_can_receive_an_optional_message_when_applied_to()
    {
        $student = factory(User::class)->create(['account_type' => 1]);
        $company = factory(User::class)->create(['account_type' => 2]);
        $jobpost = factory(Jobpost::class)->create(['user_id' => $company->id]);

        $application = $student->applyTo($jobpost, 'hello!');

        $this->assertEquals('hello!', $application->message);
    }

    /** @test */
    public function it_can_have_a_preferred_number_of_applicants()
    {
        $company = factory(User::class)->create(['account_type' => 2]);
        $jobpost1 = factory(Jobpost::class)->create(['user_id' => $company->id]);
        $jobpost2 = factory(Jobpost::class)->create([
            'user_id' => $company->id,
            'preferred_applicants' => 5
        ]);

        $this->assertEquals(null, $jobpost1->getPreferredApplicants());
        $this->assertEquals(5, $jobpost2->getPreferredApplicants());
    }

    /** @test */
    public function an_applications_status_can_be_changed()
    {
        $student = factory(User::class)->create(['account_type' => 1]);
        $company = factory(User::class)->create(['account_type' => 2]);
        $jobpost = factory(Jobpost::class)->create(['user_id' => $company->id]);

        $application = $student->applyTo($jobpost, 'hello!');
        $company->accept($application);

        $company->setStatus($application, Application::REJECTED, 'Sorry, try again next time.');
        $this->assertDatabaseHas('applications', [
            'id' => $application->id,
            'accepted' => false,
        ]);

        $company->setStatus($application, Application::ACCEPTED, 'We have changed our mind, come aboard!');
        $this->assertDatabaseHas('applications', [
            'id' => $application->id,
            'accepted' => true,
        ]);
    }

    /** @test */
    public function setting_the_same_status_throws_an_exception()
    {
        $student = factory(User::class)->create(['account_type' => 1]);
        $company = factory(User::class)->create(['account_type' => 2]);

        $jobpost1 = factory(Jobpost::class)->create(['user_id' => $company->id]);

        $application1 = $student->applyTo($jobpost1, 'hello!');
        $company->accept($application1);

        $this->expectException(ApplicationUpdateException::class);
        $company->setStatus($application1, Application::ACCEPTED);

        $jobpost2 = factory(Jobpost::class)->create(['user_id' => $company->id]);

        $application2 = $student->applyTo($jobpost2, 'hello!');
        $company->reject($application2);

        $this->expectException(ApplicationUpdateException::class);
        $company->setStatus($application2, Application::REJECTED);
    }

    /** @test */
    public function changing_an_applications_status_creates_a_corresponding_changelog()
    {
        $student = factory(User::class)->create(['account_type' => 1]);
        $company = factory(User::class)->create(['account_type' => 2]);
        $jobpost = factory(Jobpost::class)->create(['user_id' => $company->id]);

        $application = $student->applyTo($jobpost, 'hello!');
        $company->accept($application);

        $company->setStatus($application, Application::REJECTED, 'Sorry, try again next time.');
        $this->assertDatabaseHas('changelogs', [
            'message' => 'Change status to rejected. Sorry, try again next time.'
        ]);
    }
}
