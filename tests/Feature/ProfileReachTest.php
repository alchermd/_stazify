<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileReachTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function visiting_a_students_profile_will_increase_their_total_reach()
    {
        $student = factory(User::class)->state('student')->create();
        $company = factory(User::class)->state('company')->create();

        $this->assertEquals(0, $student->profile_views);

        $this->actingAs($company)
            ->get(route('students.show', ['user' => $student->id]));

        $this->assertEquals(1, $student->fresh()->profile_views);
    }

    /** @test */
    public function a_student_visiting_their_own_profile_wont_increase_their_total_reach()
    {
        $student = factory(User::class)->state('student')->create();

        $this->assertEquals(0, $student->profile_views);

        $this->actingAs($student)
            ->get(route('students.show', ['user' => $student->id]));

        $this->assertEquals(0, $student->fresh()->profile_views);
    }

    /** @test */
    public function visiting_a_companys_profile_will_increase_their_total_reach()
    {
        $company = factory(User::class)->state('company')->create();
        $student = factory(User::class)->state('student')->create();

        $this->assertEquals(0, $company->profile_views);

        $this->actingAs($student)
            ->get(route('companies.show', ['user' => $company->id]));

        $this->assertEquals(1, $company->fresh()->profile_views);
    }

    /** @test */
    public function a_company_visiting_their_own_profile_wont_increase_their_total_reach()
    {
        $company = factory(User::class)->state('company')->create();

        $this->assertEquals(0, $company->profile_views);

        $this->actingAs($company)
            ->get(route('companies.show', ['user' => $company->id]));

        $this->assertEquals(0, $company->fresh()->profile_views);
    }
}
