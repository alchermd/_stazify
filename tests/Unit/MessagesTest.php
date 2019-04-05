<?php

namespace Tests\Unit;

use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MessagesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_be_sent_by_users()
    {
        $student = factory(User::class)->state('student')->create();
        $company = factory(User::class)->state('company')->create();

        $student->sendMessage(
            $company->email,
            'Inquiry about software internship',
            'Is this still open? Thanks.'
        );

        $this->assertDatabaseHas('messages', [
            'sender_id' => $student->id,
            'recipient_id' => $company->id,
            'subject' => 'Inquiry about software internship',
            'body' => 'Is this still open? Thanks.',
        ]);
    }

    /** @test */
    public function a_user_can_get_the_messages_sent_to_them()
    {
        $students = factory(User::class, 5)->state('student')->create();
        $company = factory(User::class)->state('company')->create();

        $students->each(function (User $student) use ($company) {
            $student->sendMessage(
                $company->email,
                'Inquiry about software internship',
                'Is this still open? Thanks.'
            );
        });

        $this->assertCount(5, $company->messages);
    }

    /** @test */
    public function it_can_mark_itself_as_read()
    {
        $message = factory(Message::class)->create();
        $message->markAsRead();

        $this->assertNotNull($message->read_at);
    }

    /** @test */
    public function it_can_trash_itself()
    {
        $message = factory(Message::class)->create();
        $message->sendToTrash();

        $this->assertNotNull($message->deleted_at);
    }
}
