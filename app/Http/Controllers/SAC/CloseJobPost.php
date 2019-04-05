<?php

namespace App\Http\Controllers\SAC;

use App\Http\Controllers\Controller;
use App\Models\Jobpost;
use Illuminate\Http\Request;

class CloseJobPost extends Controller
{
    /**
     * Mark a jobpost as closed.
     *
     * @param Jobpost $jobpost
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Jobpost $jobpost, Request $request)
    {
        $jobpost->markAsClosed();

        return redirect()->back();
    }
}
