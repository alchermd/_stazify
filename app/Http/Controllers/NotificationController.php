<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * NotificationController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mark all of the unread notifications for the logged in user as read.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        return back();
    }
}
