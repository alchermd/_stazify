<?php

namespace Tests\Feature\Legacy;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApplicationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_student_can_access_the_applications_index_page()
    {
        $student = factory(User::class)->create(['account_type' => 1]);

        $this->actingAs($student)
            ->get('/home/applications')
            ->assertOk();
    }

    /** @test */
    public function a_company_can_visit_the_applications_page()
    {
        $company = factory(User::class)->create(['account_type' => 2]);

        $this->actingAs($company)
            ->get('/home/applications')
            ->assertStatus(200);
    }
}
