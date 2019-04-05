<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditStudentProfile;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class StudentProfileController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show a student's profile page.
     *
     * @param User $user
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user, Request $request)
    {
        if ($user->isCompany()) {
            return redirect('/home/companies/' . $user->id);
        }

        if ($request->user()->id !== $user->id) {
            $user->update([
                'profile_views' => $user->profile_views + 1
            ]);
        }

        return view('student-profile.show', [
            'student' => $user,
            'courses' => Course::all(),
        ]);
    }

    /**
     * Update a student's profile.
     *
     * @param EditStudentProfile $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(EditStudentProfile $request)
    {
        $validatedData = $this->buildUpdatedStudentProfile($request->validated());

        $request->user()->update($validatedData);
        $request->session()->flash('status', 'Profile updated!');

        return redirect('/home/students/' . $request->user()->id);
    }

    /**
     * Build the updated student data from the validated form input.
     *
     * @param array $validatedData
     *
     * @return array
     */
    private function buildUpdatedStudentProfile(array $validatedData): array
    {
        // Store the provided photo if provided.
        if (isset($validatedData['avatar'])) {
            $path = $validatedData['avatar']->store('avatars', 'public');
            $validatedData['avatar_url'] = '/storage/' . $path;
        }
        unset($validatedData['avatar']);

        // Resumes aren't required, so just store it if provided.
        if (isset($validatedData['resume'])) {
            $path = $validatedData['resume']->store('resumes', 'public');
            $validatedData['resume_url'] = '/storage/' . $path;
        }
        unset($validatedData['resume']);

        // Rest of the transformation.
        $validatedData['contact_number'] = '+639' . $validatedData['contact_number'];

        return $validatedData;
    }
}
