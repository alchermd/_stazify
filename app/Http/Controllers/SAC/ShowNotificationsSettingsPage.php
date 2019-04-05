<?php

namespace App\Http\Controllers\SAC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShowNotificationsSettingsPage extends Controller
{
    /**
     * ShowNotificationsSettingsPage constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return view('settings.notifications', [
            'wantsEmailNotifications' => $request->user()->wants_email_notifications
        ]);
    }
}
