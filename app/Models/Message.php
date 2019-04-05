<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Message extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The sender of this message.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * The recipient of this message.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    /**
     * Mark the message as read.
     *
     * @return Carbon|mixed|string|null
     */
    public function markAsRead()
    {
        $this->read_at = $this->read_at ?? Carbon::now();
        $this->save();

        return $this->read_at;
    }

    /**
     * Send this message to trash.
     *
     * @return Carbon|mixed
     */
    public function sendToTrash()
    {
        $this->deleted_at = Carbon::now();
        $this->save();

        return $this->deleted_at;
    }

    /**
     * 'Permanently' delete a message.
     *
     * @return Carbon|mixed
     */
    public function removeFromTrash()
    {
        $this->removed_at = Carbon::now();
        $this->save();

        return $this->removed_at;
    }
}
