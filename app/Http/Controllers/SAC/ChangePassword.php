<?php

namespace App\Http\Controllers\SAC;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePassword as ChangePasswordRequest;

class ChangePassword extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param ChangePasswordRequest $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ChangePasswordRequest $request)
    {
        $request->validated();

        $request->user()->password = bcrypt($request->post('new_password'));
        $request->user()->save();
        $request->session()->flash('status', 'Password successfully changed!');

        return back();
    }
}
