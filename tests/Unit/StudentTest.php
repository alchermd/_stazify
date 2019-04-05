<?php

namespace Tests\Unit;

use App\Models\Application;
use App\Models\Jobpost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_student_can_apply_to_a_jobpost()
    {
        $student = factory(User::class)->create(['account_type' => 1]);
        $company = factory(User::class)->create(['account_type' => 2]);
        $jobpost = factory(Jobpost::class)->create(['user_id' => $company->id]);

        $application = $student->applyTo($jobpost);

        $this->assertInstanceOf(Application::class, $application);
        $this->assertDatabaseHas('applications', [
            'user_id' => $student->id,
            'jobpost_id' => $jobpost->id,
        ]);
    }

    /** @test */
    public function it_has_a_full_name()
    {
        $student = factory(User::class)->state('student')->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);

        $this->assertEquals('John Doe', $student->full_name);
    }
}
