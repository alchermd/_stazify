<?php

namespace App\Http\Controllers\Messages;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class TrashedMessagesController extends Controller
{
    /**
     * TrashedMessagesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the trashed messages of the user.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('messages.trashed-messages.index', [
            'messages' => $request->user()->trashedMessages()->sortBy('created_at'),
        ]);
    }

    /**
     * Display a trashed message.
     *
     * @param Message $message
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Message $message)
    {
        return view('messages.trashed-messages.show', [
            'message' => $message
        ]);
    }

    /**
     * Restore a trashed message.
     *
     * @param Message $message
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Message $message, Request $request)
    {
        abort_unless($request->user()->can('restore', $message), 403);
        $message->restore();

        $request->session()->flash('status', 'Message restored.');

        return redirect(route('messages.index'));
    }

    /**
     * 'Permanently' delete a trashed message.
     *
     * @param Message $message
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Message $message, Request $request)
    {
        abort_unless($request->user()->can('permanentlyDelete', $message), 403);
        $message->removeFromTrash();

        $request->session()->flash('status', 'Message permanently deleted.');

        return redirect(route('trashed-messages.index'));
    }
}
