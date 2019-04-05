<?php

namespace Tests\Feature\Legacy;

use App\Models\User;
use Tests\TestCase;

class StudentTest extends TestCase
{
    /** @test */
    public function authenticated_student_is_redirected_to_the_dashboard()
    {
        $user = factory(User::class)->create(['account_type' => '1']);

        $this->actingAs($user)
            ->get('/login')
            ->assertRedirect('/home');
    }

    /** @test */
    public function visiting_the_registration_page_shows_a_student_registration_link()
    {
        $this->get('/register')
            ->assertStatus(200)
            ->assertSee('Student Registration');
    }

    /** @test */
    public function visiting_the_student_registration_page_shows_appropriate_text()
    {
        $this->get('/register/student')
            ->assertStatus(200)
            ->assertSee('Create a Student Account');
    }

    /** @test */
    public function cant_access_company_registration_page_when_logged_in()
    {
        $student = factory(User::class)->create(['account_type' => 1]);

        $response = $this->actingAs($student)
            ->get('/register/company');

        $response->assertRedirect('/home');
    }

    /** @test */
    public function cant_access_student_registration_page_when_logged_in()
    {
        $student = factory(User::class)->create(['account_type' => 1]);

        $response = $this->actingAs($student)
            ->get('/register/student');

        $response->assertRedirect('/home');
    }

    /** @test */
    public function cant_create_with_invalid_number()
    {
        $studentData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'contact_number' => '1234567890', // 10 digits instead of 9
            'age' => 22,
            'email' => 'john@myuniversity.edu',
            'password' => 'random-student-password',
            'password_confirmation' => 'random-student-password',
            'account_type' => 1,
            'address' => '056 Cherry St, Washington',
            'school' => 'ACME Web Development School',
            'course' => 'Computer Science',
            'about' => "I'm a CS Student!",
            'resume' => null,
            'avatar' => null,
        ];

        $this->post('/register/student', $studentData)
            ->assertSessionHasErrors('contact_number');

        $studentData['contact_number'] = '12345678'; // 8 digits instead of 9

        $this->post('/register/student', $studentData)
            ->assertSessionHasErrors('contact_number');

        $this->assertDatabaseMissing('users', [
            'account_type' => 1,
            'last_name' => 'Doe',
        ]);
    }
}
