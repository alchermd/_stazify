<?php

namespace Tests\Feature\Student;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /** @test */
    public function it_is_logged_in_after_registration()
    {
        $avatar = UploadedFile::fake()->image('avatar.jpg');
        $resume = UploadedFile::fake()->create('resume.pdf', 1500);

        $this->followingRedirects();

        $compSci = Course::where('name', 'Computer Science')->first();

        $response = $this->post('/register/student', [
            'account_type' => 1,
            'email' => 'jdoe@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'age' => 22,
            'address' => "185 Foo Street\nSomewhereville, CA",
            'about' => 'We offer software solutions for your business needs!',
            'school' => 'University of FooBar',
            'avatar' => $avatar,
            'resume' => $resume,
            'contact_number' => '123456789',
            'course_id' => $compSci->id,
        ]);

        // Update: email verification is required first!
        $response->assertSee('Verify Your Email Address');

        // TODO: Find a way to assert the URL as well!
    }

    /** @test */
    public function a_valid_course_id_should_be_provided_for_registration()
    {
        $response = $this->json('post', '/register/student', [
            'account_type' => 1,
            'email' => 'jdoe@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'age' => 22,
            'address' => "185 Foo Street\nSomewhereville, CA",
            'about' => "I'm a student!",
            'contact_number' => '123456789',
            'course_id' => -1,
        ]);

        $response->assertStatus(422);
        $this->assertArrayHasKey('course_id', $response->decodeResponseJson()['errors']);
    }

    /** @test */
    public function it_can_login()
    {
        $student = factory(User::class)->state('student')->create();

        $this->post('/login', [
            'email' => $student->email,
            'password' => 'secret',
        ])->assertRedirect('/home');

        // TODO: Find a way to assert the text "Student Dashboard" as well!
    }

    /** @test */
    public function it_cannot_visit_the_registration_pages_once_logged_in()
    {
        $student = factory(User::class)->state('student')->create();

        $this->actingAs($student)
            ->get('/register/student')
            ->assertRedirect('/home');

        $this->actingAs($student)
            ->get('/register/company')
            ->assertRedirect('/home');
    }

    /** @test */
    public function it_cannot_visit_the_password_reset_page_once_logged_in()
    {
        $student = factory(User::class)->state('student')->create();

        $this->actingAs($student)
            ->get('/password/reset')
            ->assertRedirect('/home');
    }

    /** @test */
    public function it_is_greeted_with_a_message_upon_logging_in()
    {
        $student = factory(User::class)->state('student')->create();

        $this->followingRedirects()
            ->post('/login', [
                'email' => $student->email,
                'password' => 'secret',
            ])
            ->assertSee('Welcome back, '.$student->first_name.'!');
    }
}
