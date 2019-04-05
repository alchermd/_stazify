<?php

namespace Tests\Feature\Student;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    /** @test */
    public function it_contains_their_personal_information()
    {
        $student = factory(User::class)->state('student')->create();


        $this->actingAs($student)
            ->get('/home/students/'.$student->id)
            ->assertSee(e($student->first_name))
            ->assertSee(e($student->last_name))
            ->assertSee($student->email)
            ->assertSee($student->about)
            ->assertSee($student->address)
            ->assertSee($student->course->name)
            ->assertSee($student->school)
            ->assertSee($student->age)
            ->assertSee($student->contact_number)
            ->assertSee('Download Resumé');
    }

    /** @test */
    public function it_displays_an_edit_button_when_viewed_by_the_owner()
    {
        $student1 = factory(User::class)->state('student')->create();
        $student2 = factory(User::class)->state('student')->create();

        $this->actingAs($student1)
            ->get('/home/students/'.$student1->id)
            ->assertSee('Edit Profile');

        $this->actingAs($student1)
            ->get('/home/students/'.$student2->id)
            ->assertDontSee('Edit Profile');
    }

    /** @test */
    public function it_can_edit_their_own_profile()
    {
        $student = factory(User::class)->state('student')->create();
        $avatar = UploadedFile::fake()->image('avatar.png');
        $resume = UploadedFile::fake()->create('resume.pdf', 1500);

        $this->followingRedirects();

        $response = $this->actingAs($student)
            ->put('/home/students/'.$student->id.'', [
                'contact_number' => '987654321',
                'address' => 'My new address',
                'about' => 'This is the new me!',
                'avatar' => $avatar,
                'first_name' => 'David',
                'last_name' => 'Smith',
                'age' => '23',
                'resume' => $resume,
                'course_id' => 1,
                'school' => 'ACLC Malolos',
            ]);

        $response->assertSee('David Smith')
            ->assertSee('23')
            ->assertSee('Information Technology')
            ->assertSee('ACLC Malolos')
            ->assertSee('+639987654321')
            ->assertSee('This is the new me!')
            ->assertSee('Download Resumé')
            ->assertSee('Profile updated!');
    }
}
