<?php

namespace Tests\Feature;

use App\Models\Jobpost;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobpostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function its_creation_page_is_auth_protected()
    {
        $this->get('/home/jobs/new')
            ->assertRedirect('/login');
    }

    /** @test */
    public function its_creation_page_is_inaccessible_by_students()
    {
        $student = factory(User::class)->state('student')->create();

        $this->actingAs($student)
            ->get('/home/jobs/new')
            ->assertRedirect('/home');
    }

    /** @test */
    public function it_flashes_an_error_message_with_invalid_dates()
    {
        $company = factory(User::class)->state('company')->create();

        $this->actingAs($company)
            ->post('/home/jobs', [
                'title' => 'Web Developer Internship',
                'description' => 'An internship position for CS/IT students with web development skills.',
                'qualifications' => "Willing learner\r\nTeam player\r\nExcellent communication skills",
                'required_skills' => "PHP\r\nWordpress",
                'deadline_month' => '1',
                'deadline_day' => '1',
                'deadline_year' => Carbon::now()->subYear()->year,
            ])->assertSessionHasErrors();
    }

    /** @test */
    public function companies_can_mark_jobposts_as_closed()
    {
        $company = factory(User::class)->state('company')->create();
        $jobpost = factory(Jobpost::class)->create(['user_id' => $company->id]);

        $this->assertNull($jobpost->closed_at);

        $this->actingAs($company)
            ->patch(route('jobpost.close', ['jobpost' => $jobpost->id]));

        $this->assertNotNull($jobpost->fresh()->closed_at);
    }
}
