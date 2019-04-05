<?php

namespace Tests\Feature\Company;

use App\Models\Jobpost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class JobpostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function its_dashboard_shows_the_number_of_jobs_posted()
    {
        $company = factory(User::class)->state('company')->create();

        $this->actingAs($company)
            ->get('/home')
            ->assertSeeInOrder(['0', 'Jobs Posted']);
    }

    /** @test */
    public function it_can_create_jobposts()
    {
        $company = factory(User::class)->state('company')->create();
        $deadline = Carbon::now()->addMonth();

        $this->actingAs($company)
            ->post(route('jobposts.store'), [
                'title' => 'Web Developer Internship',
                'description' => 'An internship position for CS/IT students with web development skills.',
                'qualifications' => "Willing learner\r\nTeam player\r\nExcellent communication skills",
                'required_skills' => "PHP\r\nWordpress",
                'deadline_month' => $deadline->month,
                'deadline_day' => $deadline->day,
                'deadline_year' => $deadline->year,
                'preferred_applicants' => 5,
            ]);

        $this->assertDatabaseHas('jobposts', [
            'title' => 'Web Developer Internship',
            'description' => 'An internship position for CS/IT students with web development skills.',
            'preferred_applicants' => 5,
        ]);

        $this->assertDatabaseHas('skills', ['name' => 'PHP']);
    }

    /** @test */
    public function it_can_show_the_owned_jobposts_in_an_index_page()
    {
        $company = factory(User::class)->state('company')->create();
        $jobposts = factory(Jobpost::class, 3)->create(['user_id' => $company->id]);

        $this->actingAs($company)
            ->get('/home/jobs')
            ->assertSee($jobposts[0]->title)
            ->assertSee($jobposts[1]->title)
            ->assertSee($jobposts[2]->title);
    }

    /** @test */
    public function a_company_can_edit_a_jobpost()
    {
        $company = factory(User::class)->state('company')->create();
        $jobpost = factory(Jobpost::class)->create(['user_id' => $company->id]);

        $this->actingAs($company)
            ->get("/home/jobs/{$jobpost->id}/edit")
            ->assertSee('Edit Jobpost');

        $requiredSkills = ['Symfony', 'Laravel', 'CodeIgniter'];
        $qualifications = [
            'IT/CS graduate or equivalent',
            'Extensive programming skills',
            'Fast learner',
        ];

        $this->put("/home/jobs/{$jobpost->id}", [
            'title' => 'New Jobpost Title',
            'description' => 'The new description of the jobpost.',
            'qualifications' => implode('\n', $qualifications),
            'required_skills' => implode('\n', $requiredSkills),
            'deadline_month' => 12,
            'deadline_day' => 31,
            'deadline_year' => Carbon::now()->addYear()->year,
        ]);

        $this->get('/home/jobs/' . $jobpost->id)
            ->assertSee('New Jobpost Title')
            ->assertSee('Symfony')
            ->assertSee('Laravel')
            ->assertSee('CodeIgniter')
            ->assertSee('IT/CS graduate or equivalent')
            ->assertSee('Extensive programming skills')
            ->assertSee('Fast learner')
            ->assertSee('The new description of the jobpost.')
            ->assertSee('Dec 31, ' . Carbon::now()->addYear()->year);
    }
}
