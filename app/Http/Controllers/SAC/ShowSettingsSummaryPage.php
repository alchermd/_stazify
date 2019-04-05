<?php

namespace App\Http\Controllers\SAC;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShowSettingsSummaryPage extends Controller
{
    /**
     * ShowSettingsSummaryPage constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the summary page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return view('settings.summary');
    }
}
