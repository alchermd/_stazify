<?php

namespace Tests\Unit\Messages;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SentMessagesTest extends TestCase
{
    /** @test */
    public function a_user_can_get_the_messages_that_they_sent()
    {
        $students = factory(User::class, 5)->state('student')->create();
        $company = factory(User::class)->state('company')->create();

        $students->each(function (User $student) use ($company) {
            $company->sendMessage(
                $student->email,
                'Inquiry about software internship',
                'Is this still open? Thanks.'
            );
        });

        $this->assertCount(5, $company->sentMessages);
    }
}
