<?php

namespace App\Http\Controllers\SAC;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Notifications\ApplicationStatusChanged;
use Illuminate\Http\Request;

class ChangeApplicationStatus extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Application $application
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Application $application)
    {
        abort_unless(!$application->isCancelled() && $request->user()->can('changeStatus', $application), 403);

        $request->validate([
            'message' => 'nullable|min:3'
        ]);

        $request->user()->setStatus($application, !$application->accepted, $request->post('message'));
        $request->session()->flash('status', 'Application status successfully updated.');

        $application->user->notify(new ApplicationStatusChanged($application));

        return back();
    }
}
