<?php

namespace Tests\Feature\Student;

use App\Models\Application;
use App\Models\Jobpost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobpostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_apply_for_a_jobpost()
    {
        $student = factory(User::class)->state('student')->create();
        $company = factory(User::class)->state('company')->create();
        $jobpost = factory(Jobpost::class)->create(['user_id' => $company->id]);

        $this->actingAs($student)
            ->post('/home/applications', [
                'user_id' => $student->id,
                'jobpost_id' => $jobpost->id,
            ]);

        $this->assertDatabaseHas('applications', [
            'user_id' => $student->id,
            'jobpost_id' => $jobpost->id,
            'accepted' => null,
        ]);
    }

    /** @test */
    public function it_cant_apply_to_a_jobpost_that_they_already_applied_to()
    {
        $student = factory(User::class)->state('student')->create();
        $company = factory(User::class)->state('company')->create();
        $jobpost = factory(Jobpost::class)->create(['user_id' => $company->id]);

        Application::create([
            'user_id' => $student->id,
            'jobpost_id' => $jobpost->id,
        ]);

        $this->actingAs($student)
            ->get('/home/jobs/' . $jobpost->id)
            ->assertDontSee('Apply for this position');
    }

    /** @test */
    public function it_can_see_all_the_jobposts_in_the_jobposts_index_page()
    {
        $student = factory(User::class)->state('student')->create();
        $company = factory(User::class)->state('company')->create();
        $jobposts = factory(Jobpost::class, 3)->create(['user_id' => $company->id]);

        $this->actingAs($student)
            ->get('/home/jobs')
            ->assertSee("Available Jobs")
            ->assertSee($jobposts[0]->title)
            ->assertSee($jobposts[1]->title)
            ->assertSee($jobposts[2]->title);
    }

    /** @test */
    public function it_wont_see_the_jobposts_that_they_already_applied_to_in_the_index_page()
    {
        $this->withoutExceptionHandling();

        $student = factory(User::class)->state('student')->create();
        $company = factory(User::class)->state('company')->create();
        $jobposts = factory(Jobpost::class, 3)->create(['user_id' => $company->id]);

        $student->applyTo($jobposts[2]);

        $this->actingAs($student)
            ->get('/home/jobs')
            ->assertSee("Available Jobs")
            ->assertSee($jobposts[0]->title)
            ->assertSee($jobposts[1]->title)
            ->assertDontSee($jobposts[2]->title);
    }

    /** @test */
    public function a_closed_jobpost_should_not_appear_in_the_index_page()
    {
        $student = factory(User::class)->state('student')->create();
        $company = factory(User::class)->state('company')->create();
        $jobposts = factory(Jobpost::class, 3)->create(['user_id' => $company->id]);

        $jobposts[0]->markAsClosed();

        $this->actingAs($student)
            ->get(route('jobposts.index'))
            ->assertDontSee($jobposts[0]->title)
            ->assertSee($jobposts[1]->title)
            ->assertSee($jobposts[2]->title);
    }
}
