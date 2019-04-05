<?php

namespace Tests\Feature\Legacy;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_is_redirected_to_the_correct_url_if_the_page_visited_is_of_incorrect_account_type()
    {
        $student = factory(User::class)->create(['account_type' => 1]);
        $company = factory(User::class)->create(['account_type' => 2]);

        $this->actingAs($student)
            ->get('/home/companies/' . $student->id)
            ->assertRedirect('/home/students/' . $student->id);

        $this->actingAs($student)
            ->get('/home/students/' . $company->id)
            ->assertRedirect('/home/companies/' . $company->id);
    }

    /** @test */
    public function user_profiles_are_auth_protected()
    {
        $student = factory(User::class)->create(['account_type' => 1]);
        $company = factory(User::class)->create(['account_type' => 2]);

        $this->get('/home/companies/' . $company->id)->assertRedirect('/login');
        $this->get('/home/students/' . $student->id)->assertRedirect('/login');
    }
}
