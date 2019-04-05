<?php

namespace App\Http\Controllers\Messages;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SentMessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display all the sent messages for this user.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('messages.sent-messages.index', [
            'messages' => $request->user()->sentMessages()->withTrashed()->get()->sortByDesc('created_at'),
        ]);
    }


    /**
     * Show a certain message.
     *
     * @param Message $message
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Message $message, Request $request)
    {
        abort_unless($request->user()->can('viewSent', $message), 403);

        return view('messages.sent-messages.show', [
            'message' => $message,
        ]);
    }
}
