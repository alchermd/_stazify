<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Industry;
use App\Models\Jobpost;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_search_for_company_accounts_by_name()
    {
        $student = factory(User::class)->state('student')->create();
        $company = factory(User::class)->state('company')->create();

        $this->actingAs($student)
            ->get(route('search.companies', [
                'company_name' => $company->name
            ]))
            ->assertSee($company->name);
    }

    /** @test */
    public function searching_a_company_requires_authentication()
    {
        $company = factory(User::class)->state('company')->create();

        $this->get(route('search.companies', [
            'name' => $company->name
        ]))
            ->assertRedirect('/login');
    }

    /** @test */
    public function a_user_can_search_for_company_accounts_by_email()
    {
        $student = factory(User::class)->state('student')->create();
        $company = factory(User::class)->state('company')->create();

        $this->actingAs($student)
            ->get(route('search.companies', [
                'company_email' => $company->email
            ]))
            ->assertSee($company->email);
    }

    /** @test */
    public function a_user_can_search_for_company_accounts_by_industry()
    {
        $this->artisan('db:seed');
        $student = factory(User::class)->state('student')->create();
        factory(User::class)->state('company')->create([
            'industry_id' => 1,
        ]);

        $this->actingAs($student)
            ->get(route('search.companies', [
                'industry' => 1
            ]))
            ->assertSee(Industry::find(1)->name);
    }

    /** @test */
    public function a_user_can_search_a_student_by_name()
    {
        $company = factory(User::class)->state('company')->create();
        $student = factory(User::class)->state('student')->create();

        $this->actingAs($company)
            ->get(route('search.students', ['student_name' => $student->first_name]))
            ->assertSee($student->name);

        $this->actingAs($company)
            ->get(route('search.students', ['student_name' => $student->last_name]))
            ->assertSee($student->name);
    }

    /** @test */
    public function searching_for_a_student_requires_authentication()
    {
        $student = factory(User::class)->state('student')->create();

        $this->get(route('search.students', [
            'student_name' => $student->name
        ]))
            ->assertRedirect('/login');
    }

    /** @test */
    public function a_user_can_search_for_student_accounts_by_email()
    {
        $company = factory(User::class)->state('company')->create();
        $student = factory(User::class)->state('student')->create();

        $this->actingAs($company)
            ->get(route('search.students', [
                'student_email' => $student->email
            ]))
            ->assertSee($student->email);
    }

    /** @test */
    public function a_user_can_search_for_student_accounts_by_course()
    {
        $this->artisan('db:seed');

        $company = factory(User::class)->state('company')->create();
        factory(User::class)->state('student')->create([
            'course_id' => 1,
        ]);

        $this->actingAs($company)
            ->get(route('search.students', [
                'course' => 1
            ]))
            ->assertSee(Course::find(1)->name);
    }

    /** @test */
    public function a_user_can_search_for_students_by_full_name()
    {
        $company = factory(User::class)->state('company')->create();
        $student = factory(User::class)->state('student')->create();

        $this->actingAs($company)
            ->get(route('search.students', [
                'student_name' => $student->name
            ]))->assertSee($student->name);
    }

    /** @test */
    public function a_user_can_search_for_jobs_by_title()
    {
        $student = factory(User::class)->state('student')->create();
        $jobpost = factory(Jobpost::class)->create();

        $this->actingAs($student)
            ->get(route('search.jobposts', [
                'title' => $jobpost->title
            ]))
            ->assertSee($jobpost->title);
    }

    /** @test */
    public function searching_for_jobposts_required_authentication()
    {
        $jobpost = factory(Jobpost::class)->create();

        $this->get(route('search.jobposts', [
            'title' => $jobpost->title
        ]))
            ->assertRedirect('login');
    }

    /** @test */
    public function a_user_can_search_for_jobs_by_company()
    {
        $student = factory(User::class)->state('student')->create();
        $jobpost = factory(Jobpost::class)->create();

        $this->actingAs($student)
            ->get(route('search.jobposts', [
                'company_name' => $jobpost->user->name
            ]))
            ->assertSee($jobpost->title);
    }

    /** @test */
    public function a_user_can_search_for_jobs_by_skills()
    {
        $student = factory(User::class)->state('student')->create();
        $jobpost = factory(Jobpost::class)->create();

        $skill1 = factory(Skill::class)->create();
        $skill2 = factory(Skill::class)->create();

        $jobpost->skills()->attach($skill1);
        $jobpost->skills()->attach($skill2);

        $this->actingAs($student)
            ->get(route('search.jobposts', [
                'skills' => [
                    $skill1->name,
                    $skill2->name,
                ]
            ]))
            ->assertSee($jobpost->title);
    }
}
