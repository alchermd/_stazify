<?php

namespace App\Http\Controllers\SAC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpdateEmailNotifications extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->user()->update([
            'wants_email_notifications' => $request->has('wants_email_notifications')
        ]);

        $request->session()->flash('status', 'Email notification preferences updated.');

        return back();
    }
}
