<?php

namespace App\Http\Controllers\Messages;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendMessage;
use App\Models\Message;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    /**
     * MessagesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display all the messages for this user.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('messages.messages.index', [
            'messages' => $request->user()->messages->sortByDesc('created_at'),
        ]);
    }

    /**
     * Show the new message form.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('messages.messages.create', [
            'recipientEmail' => $request->get('recipient_email'),
            'subject' => $request->get('subject'),
        ]);
    }

    /**
     * Save a new message.
     *
     * @param SendMessage $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(SendMessage $request)
    {
        $request->validated();

        $request->user()
            ->sendMessage(
                $request->post('recipient_email'),
                $request->post('subject'),
                $request->post('body')
            );

        $request->session()->flash('status', 'Message sent!');

        return redirect(route('messages.index'));
    }

    /**
     * Show a certain message.
     *
     * @param Message $message
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Message $message, Request $request)
    {
        abort_if($message->trashed(), 404);
        abort_unless($request->user()->can('view', $message), 403);

        $message->markAsRead();

        return view('messages.messages.show', [
            'message' => $message,
        ]);
    }

    /**
     * Trash a certain message.
     *
     * @param Message $message
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Message $message, Request $request)
    {
        abort_unless($request->user()->can('trash', $message), 403);

        $message->sendToTrash();

        return redirect(route('messages.index'));
    }
}
