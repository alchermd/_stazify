<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApplication;
use App\Models\Application;
use App\Models\Jobpost;
use App\Models\User;
use App\Notifications\ApplicationCancelled;
use App\Notifications\ApplicationSent;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Create a controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('student')->only(['store']);
    }

    /**
     * Show the index page for applications.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $applications = [];
        if ($request->user()->isCompany()) {
            $applications = User::getApplicationsReceived($request->user());
        } else {
            if ($request->user()->isStudent()) {
                $applications = User::getActiveApplicationsSent($request->user());
            }
        }

        return view('applications.index.' . strtolower($request->user()->accountTypeName()), [
            'applications' => $applications,
        ]);
    }

    /**
     * Show a specific application.
     *
     * @param Application $application
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Application $application, Request $request)
    {
        abort_unless($request->user()->can('view', $application), 403);

        return view('applications.show', [
            'application' => $application
        ]);
    }

    /**
     * Persist a new application data.
     *
     * @param StoreApplication $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     *
     * @throws \Exception
     */
    public function store(StoreApplication $request)
    {
        $request->validated();

        $student = User::find($request->post('user_id'));
        $jobpost = Jobpost::find($request->post('jobpost_id'));
        $company = $jobpost->user;

        $application = $student->applyTo($jobpost, $request->post('message'));

        $company->notify(new ApplicationSent($application));
        $request->session()->flash('status', 'Application successfully sent!');

        return redirect('/home');
    }

    /**
     * Cancel an application.
     *
     * @param Application $application
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Application $application, Request $request)
    {
        $application->cancel();

        $request->session()->flash('status', 'Application has been cancelled.');
        $application->getCompany()->notify(new ApplicationCancelled($application));

        return redirect('/home');
    }
}
