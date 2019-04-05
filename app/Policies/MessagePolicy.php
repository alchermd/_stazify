<?php

namespace App\Policies;

use App\Models\Message;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the message.
     *
     * @param User $user
     * @param Message $message
     * @return mixed
     */
    public function view(User $user, Message $message)
    {
        return $message->recipient->id === $user->id;
    }

    /**
     * Determine whether the user can view the sent message.
     *
     * @param User $user
     * @param Message $message
     * @return mixed
     */
    public function viewSent(User $user, Message $message)
    {
        return $message->sender->id === $user->id;
    }

    /**
     * Determine whether the user can send a message to trash.
     *
     * @param User $user
     * @param Message $message
     * @return bool
     */
    public function trash(User $user, Message $message)
    {
        return $message->recipient->id === $user->id;
    }

    /**
     * Determine whether the user can 'permanently' delete a message.
     *
     * @param User $user
     * @param Message $message
     * @return bool
     */
    public function permanentlyDelete(User $user, Message $message)
    {
        return $message->recipient->id === $user->id;
    }

    /**
     * Determine whether the user can restore a trashed message.
     *
     * @param User $user
     * @param Message $message
     * @return bool
     */
    public function restore(User $user, Message $message)
    {
        return $message->recipient->id === $user->id;
    }
}
