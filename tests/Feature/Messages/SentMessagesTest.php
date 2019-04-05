<?php

namespace Tests\Feature\Messages;

use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SentMessagesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_outbox_index_exists()
    {
        $student = factory(User::class)->state('student')->create();

        $this->actingAs($student)
            ->get(route('sent-messages.index'))
            ->assertOk();
    }

    /** @test */
    public function a_counter_for_the_sent_messages_is_visible_on_the_inbox_page()
    {
        $student = factory(User::class)->state('student')->create();
        $numberOfMessages = 5;

        factory(Message::class, $numberOfMessages)->create([
            'sender_id' => $student->id,
        ]);

        $this->actingAs($student)
            ->get(route('sent-messages.index'))
            ->assertSee("<span>{$numberOfMessages}</span>");
    }

    /** @test */
    public function the_outbox_page_needs_authentication_to_be_accessed()
    {
        $this->get(route('sent-messages.index'))
            ->assertRedirect('/login');
    }

    /** @test */
    public function the_sent_message_show_page_is_accessible()
    {
        $student = factory(User::class)->state('student')->create();
        $message = factory(Message::class)->create(['sender_id' => $student->id]);

        $this->actingAs($student)
            ->get(route('sent-messages.show', ['message' => $message->id]))
            ->assertOk();
    }

    /** @test */
    public function the_sent_message_show_page_needs_authentication_to_be_accessed()
    {
        $message = factory(Message::class)->create();

        $this->get(route('sent-messages.show', ['message' => $message->id]))
            ->assertRedirect('/login');
    }
}
