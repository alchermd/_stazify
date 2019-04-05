<?php

namespace Tests\Feature\Notifications;

use App\Models\Application;
use App\Models\Jobpost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_mark_all_their_database_notifications_as_read()
    {
        $student = factory(User::class)->state('student')->create();
        $company = factory(User::class)->state('company')->create();
        $jobpost = factory(Jobpost::class)->create(['user_id' => $company->id]);

        $this->actingAs($student)
            ->post('/home/applications', [
                'user_id' => $student->id,
                'jobpost_id' => $jobpost->id,
            ]);

        $application = Application::where('user_id', '=', $student->id)
            ->where('jobpost_id', '=', $jobpost->id)
            ->first();

        $this->actingAs($company)
            ->post("/home/applications/{$application->id}/accept", [
                'student_id' => $student->id,
            ]);

        $this->actingAs($student)
            ->delete('/home/notifications', []);

        $this->actingAs($company)
            ->delete('/home/notifications', []);

        $this->assertEmpty($student->fresh()->unreadNotifications->all());
        $this->assertEmpty($company->fresh()->unreadNotifications->all());
    }
}
