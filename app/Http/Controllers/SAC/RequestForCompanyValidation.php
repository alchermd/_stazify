<?php

namespace App\Http\Controllers\SAC;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVerificationRequest;
use App\Models\User;

class RequestForCompanyValidation extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param StoreVerificationRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function __invoke(StoreVerificationRequest $request, User $user)
    {
        $request->validated();

        $user->verificationRequests()->create([
            'message' => $request->post('message'),
            'attachment' => $request->file('attachment')->store('verifications'),
        ]);

        $request->session()->flash('status', 'Request for verification sent!');

        return redirect('/home');
    }
}
