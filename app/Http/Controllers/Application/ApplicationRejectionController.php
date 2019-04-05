<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\User;
use App\Notifications\ApplicationRejected;
use Illuminate\Http\Request;

class ApplicationRejectionController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('company');
    }

    /**
     * Reject an application.
     *
     * @param Application $application
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Application $application, Request $request)
    {
        $request->validate([
            'student_id' => 'required|numeric|exists:users,id',
        ]);

        $student = User::find($request->input('student_id'));
        $company = $request->user();

        $company->reject($application);

        $request->session()->flash('status', 'You have rejected ' . $student->first_name . '\'s application!');
        $student->notify(new ApplicationRejected($application));

        return redirect('/home');
    }
}
