<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendSiteFeedback;
use App\Jobs\SendSiteFeedbackMail;
use App\Mail\SiteFeedbackSent;
use App\Models\SiteFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SiteFeedbackController extends Controller
{
    /**
     * Show the feedback form.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        if ($request->get('message_sent') == 1) {
            return view('site-feedback.success');
        }

        return view('site-feedback.create');
    }

    /**
     * Send the user's feedback.
     *
     * @param SendSiteFeedback $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(SendSiteFeedback $request)
    {
        $validatedData = $request->validated();
        $validatedData['reply_me'] = $request->post('reply_me') === 'on';

        $siteFeedback = SiteFeedback::create($validatedData);
        SendSiteFeedbackMail::dispatch($siteFeedback);

        return redirect('/feedback?message_sent=1');
    }
}
