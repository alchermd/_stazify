<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UnlikeCompanyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_student_can_unlike_a_company()
    {
        $this->withoutExceptionHandling();

        $student = factory(User::class)->state('student')->create();
        $company = factory(User::class)->state('company')->create();

        $this->actingAs($student)
            ->post(route('company.like', ['company' => $company->id]))
            ->assertOk();

        $this->assertEquals(1, $company->likers->count());
        $this->assertEquals(1, $student->likes->count());

        $this->actingAs($student)
            ->post(route('company.unlike', ['company' => $company->id]))
            ->assertOk();

        $this->assertEquals(0, $company->fresh()->likers->count());
        $this->assertEquals(0, $student->fresh()->likes->count());
    }

    /** @test */
    public function a_company_cant_unlike_another_company()
    {
        $company1 = factory(User::class)->state('company')->create();
        $company2 = factory(User::class)->state('company')->create();

        $this->actingAs($company1)
            ->post(route('company.unlike', ['company' => $company2->id]))
            ->assertStatus(401);

        $this->assertEquals(0, $company2->likers->count());
    }

    /** @test */
    public function a_student_cant_be_unliked()
    {
        $studentToUnlike = factory(User::class)->state('student')->create();
        $student = factory(User::class)->state('student')->create();
        $company = factory(User::class)->state('company')->create();

        $this->actingAs($student)
            ->post(route('company.unlike', ['company' => $studentToUnlike->id]))
            ->assertStatus(401);

        $this->assertEquals(0, $studentToUnlike->likers->count());

        $this->actingAs($company)
            ->post(route('company.unlike', ['company' => $studentToUnlike->id]))
            ->assertStatus(401);

        $this->assertEquals(0, $studentToUnlike->likers->count());
    }
}
