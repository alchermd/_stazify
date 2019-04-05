<?php

namespace Tests\Feature\Messages;

use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class TrashedMessagesTest extends TestCase
{
    /** @test */
    public function the_index_page_for_trashed_messages_is_accessible()
    {
        $student = factory(User::class)->state('student')->create();

        $this->actingAs($student)
            ->get(route('trashed-messages.index'))
            ->assertOk();
    }

    /** @test */
    public function the_trashed_messages_index_page_needs_authentication_to_be_accessed()
    {
        $this->get(route('trashed-messages.index'))
            ->assertRedirect('/login');
    }

    /** @test */
    public function a_counter_for_the_trashed_messages_is_visible_on_the_inbox_page()
    {
        $student = factory(User::class)->state('student')->create();
        $numberOfMessages = 8;

        factory(Message::class, $numberOfMessages)->create([
            'recipient_id' => $student->id,
            'deleted_at' => Carbon::now()
        ]);

        $this->actingAs($student)
            ->get(route('trashed-messages.index'))
            ->assertSee("<span>{$numberOfMessages}</span>");
    }

    /** @test */
    public function a_user_can_send_a_message_to_trash()
    {
        $student = factory(User::class)->state('student')->create();
        $message = factory(Message::class)->create([
            'recipient_id' => $student->id
        ]);

        $this->actingAs($student)
            ->delete(route('messages.delete', ['message' => $message->id]));

        $this->assertNotNull($message->fresh()->deleted_at);
    }

    /** @test */
    public function trashing_a_message_requires_authentication()
    {
        $message = factory(Message::class)->create();

        $this->delete(route('messages.delete', ['message' => $message->id]))
            ->assertRedirect('/login');
    }

    /** @test */
    public function a_user_can_only_trash_their_own_messages()
    {
        $student = factory(User::class)->state('student')->create();
        $message = factory(Message::class)->create();

        $this->actingAs($student)
            ->delete(route('messages.delete', ['message' => $message->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function trashing_a_message_doesnt_affect_the_outbox_of_the_sender()
    {
        $student = factory(User::class)->state('student')->create();
        $company = factory(User::class)->state('company')->create();

        $message = factory(Message::class)->create([
            'sender_id' => $student->id,
            'recipient_id' => $company->id,
        ]);

        $this->actingAs($company)
            ->delete(route('messages.delete', ['message' => $message->id]));

        $this->actingAs($student)
            ->get(route('sent-messages.index'))
            ->assertSee($message->subject);

        $this->actingAs($student)
            ->get(route('sent-messages.show', ['message' => $message->id]))
            ->assertSee($message->title)
            ->assertSee($message->subject);
    }

    /** @test */
    public function the_trashed_messages_show_page_is_accessible()
    {
        $student = factory(User::class)->state('student')->create();
        $message = factory(Message::class)->create([
            'recipient_id' => $student->id,
            'deleted_at' => Carbon::now(),
        ]);

        $this->actingAs($student)
            ->get(route('trashed-messages.show', ['message' => $message->id]))
            ->assertOk();
    }

    /** @test */
    public function the_trashed_messages_show_page_needs_authentication_to_be_accessed()
    {
        $message = factory(Message::class)->create([
            'deleted_at' => Carbon::now(),
        ]);

        $this->get(route('trashed-messages.show', ['message' => $message->id]))
            ->assertRedirect('/login');
    }

    /** @test */
    public function trashed_messages_can_be_permanently_deleted()
    {
        $student = factory(User::class)->state('student')->create();
        $message = factory(Message::class)->create([
            'recipient_id' => $student->id,
            'deleted_at' => Carbon::now(),
        ]);

        $this->actingAs($student)
            ->delete(route('trashed-messages.delete', ['message' => $message->id]));

        $this->assertNotNull($message->fresh()->removed_at);
    }

    /** @test */
    public function permanently_deleting_a_trashed_message_required_authentication()
    {
        $message = factory(Message::class)->create([
            'deleted_at' => Carbon::now(),
        ]);

        $this->delete(route('trashed-messages.delete', ['message' => $message->id]))
            ->assertRedirect('/login');
    }

    /** @test */
    public function only_the_sender_can_permanently_delete_a_trashed_message()
    {
        $student = factory(User::class)->state('student')->create();
        $company = factory(User::class)->state('company')->create();
        $message = factory(Message::class)->create([
            'recipient_id' => $student->id,
            'sender_id' => $company->id,
            'deleted_at' => Carbon::now(),
        ]);

        $this->actingAs($company)
            ->delete(route('trashed-messages.delete', ['message' => $message->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function trashed_messages_can_be_restored()
    {
        $student = factory(User::class)->state('student')->create();
        $message = factory(Message::class)->create([
            'recipient_id' => $student->id,
            'deleted_at' => Carbon::now(),
        ]);

        $this->actingAs($student)
            ->patch(route('trashed-messages.update', ['message' => $message->id]));

        $this->assertNull($message->fresh()->deleted_at);
    }

    /** @test */
    public function restoring_a_trashed_message_required_authentication()
    {
        $message = factory(Message::class)->create([
            'deleted_at' => Carbon::now(),
        ]);

        $this->patch(route('trashed-messages.update', ['message' => $message->id]))
            ->assertRedirect('/login');
    }

    /** @test */
    public function only_the_sender_can_restore_a_trashed_message()
    {
        $student = factory(User::class)->state('student')->create();
        $company = factory(User::class)->state('company')->create();
        $message = factory(Message::class)->create([
            'recipient_id' => $student->id,
            'sender_id' => $company->id,
            'deleted_at' => Carbon::now(),
        ]);

        $this->actingAs($company)
            ->patch(route('trashed-messages.update', ['message' => $message->id]))
            ->assertStatus(403);
    }
}
