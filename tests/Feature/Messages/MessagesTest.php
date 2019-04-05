<?php

namespace Tests\Feature\Messages;

use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MessagesTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function the_inbox_page_is_accessible()
    {
        $user = factory(User::class)->state('student')->create();
        $this->actingAs($user)
            ->get(route('messages.index'))
            ->assertOk();
    }

    /** @test */
    public function the_inbox_page_needs_authentication_to_be_accessed()
    {
        $this->get(route('messages.index'))
            ->assertRedirect('/login');
    }

    /** @test */
    public function a_user_can_send_a_message_to_another_user()
    {
        $student = factory(User::class)->state('student')->create();
        $company = factory(User::class)->state('company')->create();

        $this->actingAs($student)
            ->post(route('messages.store'), [
                'recipient_email' => $company->email,
                'subject' => 'Inquiry about software internship',
                'body' => 'Is this still open? Thanks.',
            ]);

        $this->assertDatabaseHas('messages', [
            'sender_id' => $student->id,
            'recipient_id' => $company->id,
            'subject' => 'Inquiry about software internship',
            'body' => 'Is this still open? Thanks.',
        ]);
    }

    /** @test */
    public function a_user_needs_to_be_authenticated_before_sending_a_message()
    {
        $this->post(route('messages.store'), [])
            ->assertRedirect('/login');
    }

    /** @test */
    public function the_inbox_page_displays_an_index_of_the_authenticated_users_messages()
    {
        $student = factory(User::class)->state('student')->create();

        $messages = factory(Message::class, 5)->create(['recipient_id' => $student->id]);

        $response = $this->actingAs($student)
            ->get(route('messages.index'));

        $messages->each(function (Message $message) use ($response) {
            $response->assertSee($message->sender->name);
            $response->assertSee($message->subject);
        });
    }

    /** @test */
    public function the_create_message_page_is_accessible()
    {
        $student = factory(User::class)->state('student')->create();

        $this->actingAs($student)
            ->get(route('messages.create'))
            ->assertOk();
    }

    /** @test */
    public function the_create_message_page_needs_authentication_to_access()
    {
        $this->get(route('messages.create'))
            ->assertRedirect();
    }

    /** @test */
    public function the_message_show_page_is_accessible()
    {
        $student = factory(User::class)->state('student')->create();
        $message = factory(Message::class)->create(['recipient_id' => $student->id]);

        $this->actingAs($student)
            ->get(route('messages.show', ['message' => $message->id]))
            ->assertOk();
    }

    /** @test */
    public function the_message_show_page_required_authentication()
    {
        $message = factory(Message::class)->create();

        $this->get(route('messages.show', ['message' => $message->id]))
            ->assertRedirect('/login');
    }

    /** @test */
    public function a_user_can_only_view_messages_sent_to_them()
    {
        $student = factory(User::class)->state('student')->create();
        $student2 = factory(User::class)->state('student')->create();
        $company = factory(User::class)->state('company')->create();

        $message = factory(Message::class)->create([
            'sender_id' => $student->id,
            'recipient_id' => $company->id,
        ]);

        $this->actingAs($student2)
            ->get(route('messages.show', ['message' => $message->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function passing_the_recipient_email_on_the_query_string_works()
    {
        $student = factory(User::class)->state('student')->create();

        $this->actingAs($student)
            ->get(route('messages.create', ['recipient_email' => 'jdoe@example.com']))
            ->assertSee('jdoe@example.com');
    }

    /** @test */
    public function passing_the_subject_on_the_query_string_works()
    {
        $student = factory(User::class)->state('student')->create();

        $this->actingAs($student)
            ->get(route('messages.create', ['subject' => 'On your application...']))
            ->assertSee('On your application...');
    }

    /** @test */
    public function a_counter_for_the_messages_is_visible_on_the_inbox_page()
    {
        $student = factory(User::class)->state('student')->create();
        $numberOfMessages = 5;

        factory(Message::class, $numberOfMessages)->create([
            'recipient_id' => $student->id,
        ]);

        $this->actingAs($student)
            ->get(route('messages.index'))
            ->assertSee("<span>{$numberOfMessages} total messages</span>");
    }

    /** @test */
    public function visiting_a_message_show_page_marks_it_as_read()
    {
        $student = factory(User::class)->state('student')->create();
        $numberOfMessages = 2;

        $messages = factory(Message::class, $numberOfMessages)->create([
            'recipient_id' => $student->id,
        ]);

        $this->actingAs($student)
            ->get(route('messages.show', ['message' => $messages[0]->id]))
            ->assertSee('<span>1 unread messages</span>');
    }

    /** @test */
    public function a_message_is_shown_when_there_are_no_messages()
    {
        $student = factory(User::class)->state('student')->create();

        $this->actingAs($student)
            ->get(route('messages.index'))
            ->assertSee('No unread messages')
            ->assertSee('Inbox Empty');
    }

    /** @test */
    public function visiting_a_trashed_message_yields_a_404()
    {
        $student = factory(User::class)->state('student')->create();
        $message = factory(Message::class)->create([
            'recipient_id' => $student->id,
            'deleted_at' => Carbon::now()
        ]);

        $this->actingAs($student)
            ->get(route('messages.show', ['message' => $message->id]))
            ->assertStatus(404);
    }
}
