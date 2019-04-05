<?php

namespace Tests\Feature\Legacy;

use App\Models\Jobpost;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobpostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_jobposts_through_POST_requests()
    {
        $company = factory(User::class)->create(['account_type' => 2]);

        $deadline = Carbon::now()->addMonth();

        $jobpostRawData = [
            'title' => 'Web Developer Internship',
            'description' => 'An internship position for CS/IT students with web development skills.',
            'qualifications' => "Willing learner\nTeam player\nExcellent communication skills",
            'required_skills' => "PHP\nWordpress",
            'deadline_month' => $deadline->month,
            'deadline_day' => $deadline->day,
            'deadline_year' => $deadline->year,
        ];

        $response = $this->actingAs($company)
            ->post(route('jobposts.store'), $jobpostRawData);

        $response->assertStatus(302);

        $this->assertDatabaseHas('jobposts', [
            'title' => $jobpostRawData['title'],
            'description' => $jobpostRawData['description'],
        ]);
    }

    /** @test */
    public function a_company_can_access_a_jobpost_show_page()
    {
        $company = factory(User::class)->create(['account_type' => 2]);
        $jobpost = factory(Jobpost::class)->create(['user_id' => $company->id]);

        $this->actingAs($company)
            ->get('/home/jobs/' . $jobpost->id)
            ->assertStatus(200);
    }

    /** @test */
    public function a_student_can_access_the_jobposts_index_page()
    {
        $student = factory(User::class)->create(['account_type' => 1]);

        $this->actingAs($student)
            ->get('/home/jobs')
            ->assertStatus(200);
    }

    /** @test */
    public function a_student_can_apply_through_POST_requests()
    {
        $student = factory(User::class)->create(['account_type' => 1]);
        $company = factory(User::class)->create(['account_type' => 2]);
        $jobpost = factory(Jobpost::class)->create(['user_id' => $company->id]);

        $this->actingAs($student)
            ->post('/home/applications', [
                'user_id' => $student->id,
                'jobpost_id' => $jobpost->id,
            ])
            ->assertStatus(302);

        $this->assertDatabaseHas('applications', [
            'user_id' => $student->id,
            'jobpost_id' => $jobpost->id,
        ]);
    }
}
