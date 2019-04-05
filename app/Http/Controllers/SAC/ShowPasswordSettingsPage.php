<?php

namespace App\Http\Controllers\SAC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShowPasswordSettingsPage extends Controller
{
    /**
     * ShowPasswordSettingsPage constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return view('settings.password');
    }
}
