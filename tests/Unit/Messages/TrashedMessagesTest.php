<?php

namespace Tests\Unit\Messages;

use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrashedMessagesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_get_the_messages_that_they_trashed()
    {
        $student = factory(User::class)->state('student')->create();
        $messages = factory(Message::class, 5)->create([
            'recipient_id' => $student->id
        ]);

        $messages->each(function (Message $message) {
            $message->sendToTrash();
        });

        $this->assertCount(5, $student->trashedMessages());
    }

    /** @test */
    public function a_user_can_permanently_delete_a_message()
    {
        $student = factory(User::class)->state('student')->create();
        $messages = factory(Message::class, 5)->create([
            'recipient_id' => $student->id,
            'deleted_at' => Carbon::now()
        ]);

        $messages->first()->removeFromTrash();

        $this->assertCount(4, $student->trashedMessages());
    }
}
