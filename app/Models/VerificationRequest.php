<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificationRequest extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * Accept this verification request.
     */
    public function accept()
    {
        $this->company()->update([
            'company_verified_at' => now()
        ]);
    }

    /**
     * The company that sent this request.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(User::class);
    }
}
