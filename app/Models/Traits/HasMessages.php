<?php

namespace App\Models\Traits;

use App\Models\Message;
use App\Models\User;

trait HasMessages
{
    /**
     * Sends a message to another user.
     *
     * @param string $email
     * @param string $subject
     * @param string $body
     * @return Message
     */
    public function sendMessage(string $email, string $subject, string $body): Message
    {
        return Message::create([
            'sender_id' => $this->id,
            'recipient_id' => User::whereEmail($email)->first()->id,
            'subject' => $subject,
            'body' => $body,
        ]);
    }

    /**
     * The messages that this user sent.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * The trashed messages of this user.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function trashedMessages()
    {
        return $this->messages()->withTrashed()->whereNotNull('deleted_at')->whereNull('removed_at')->get();
    }

    /**
     * The messages sent to this user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'recipient_id');
    }
}
