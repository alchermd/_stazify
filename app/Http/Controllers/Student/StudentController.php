<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterStudent;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the student registration form.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('students.create', [
            'email' => $request->query('email'),
            'courses' => Course::all(),
        ]);
    }

    /**
     * Persist a news student account.
     *
     * @param RegisterStudent $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(RegisterStudent $request)
    {
        $studentData = $this->buildStudentData($request->validated());
        $student = User::create($studentData);

        auth()->login($student);
        $request->session()->flash('status', 'You are now registered, ' . $student->first_name . '!');

        return redirect('/home');
    }

    /**
     * Build the student's data from the form inputs.
     *
     * @param array $validatedData
     *
     * @return array
     */
    private function buildStudentData(array $validatedData)
    {
        // Store the provided photo, generate an adorable avatar otherwise.
        if (isset($validatedData['avatar'])) {
            $path = $validatedData['avatar']->store('avatars', 'public');
            $validatedData['avatar_url'] = '/storage/' . $path;
        } else {
            $encodedName = urlencode($validatedData['first_name']);
            $validatedData['avatar_url'] = "https://api.adorable.io/avatars/285/{$encodedName}@adorable.png";
        }
        unset($validatedData['avatar']);

        // Resumes aren't required, so just store it if provided.
        if (isset($validatedData['resume'])) {
            $path = $validatedData['resume']->store('resumes', 'public');
            $validatedData['resume_url'] = '/storage/' . $path;
        }
        unset($validatedData['resume']);

        // Rest of the transformation.
        $validatedData['password'] = bcrypt($validatedData['password']);
        $validatedData['contact_number'] = '+639' . $validatedData['contact_number'];

        return $validatedData;
    }
}
