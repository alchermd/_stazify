<?php

namespace Tests\Feature\Settings;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_settings_page_exists()
    {
        $student = factory(User::class)->state('student')->create();
        $this->actingAs($student)
            ->get(route('settings.summary'))
            ->assertOk();
    }

    /** @test */
    public function the_settings_page_requires_authentication()
    {
        $this->get(route('settings.summary'))
            ->assertRedirect('/login');
    }

    /** @test */
    public function the_password_settings_page_exists()
    {
        $student = factory(User::class)->state('student')->create();

        $this->actingAs($student)
            ->get(route('settings.password'))
            ->assertOk();
    }

    /** @test */
    public function the_password_settings_page_requires_authentication()
    {
        $this->get(route('settings.password'))
            ->assertRedirect('/login');
    }

    /** @test */
    public function a_user_can_reset_their_password()
    {
        $student = factory(User::class)->state('student')->create([
            'password' => bcrypt('secret_password')
        ]);

        $this->actingAs($student)
            ->post(route('settings.password.change'), [
                'current_password' => 'secret_password',
                'new_password' => 'new_secret_password',
                'new_password_confirmation' => 'new_secret_password'
            ]);

        $this->assertTrue(Hash::check('new_secret_password', $student->password));
    }

    /** @test */
    public function the_notification_settings_page_exists()
    {
        $student = factory(User::class)->state('student')->create();
        $this->actingAs($student)
            ->get(route('settings.notification'))
            ->assertOk();
    }

    /** @test */
    public function the_notification_settings_page_requires_authentication()
    {
        $this->get(route('settings.notification'))
            ->assertRedirect('/login');
    }

    /** @test */
    public function a_user_can_update_their_email_notification_settings()
    {
        $student = factory(User::class)->state('student')->create([
            'wants_email_notifications' => 'false'
        ]);

        $this->actingAs($student)
            ->patch(route('settings.notification.update'), [
                'wants_email_notifications' => 'on'
            ]);

        $this->assertTrue($student->wants_email_notifications);

        $this->actingAs($student)
            ->patch(route('settings.notification.update'));

        $this->assertFalse($student->wants_email_notifications);
    }
}
