<?php

namespace App\Http\Controllers\SAC;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SearchForStudentAccounts extends Controller
{
    /**
     * SearchForStudentAccounts constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Search for student accounts.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        $students = User::where('account_type', 1)
            ->where(function (Builder $query) use ($request) {
                $studentName = strtoupper($request->get('student_name'));
                $query->whereRaw("UPPER(first_name) LIKE '%{$studentName}%'")
                    ->orWhereRaw("UPPER(last_name) LIKE '%{$studentName}%'")
                    ->orWhereRaw("UPPER(first_name || ' ' || last_name) LIKE '%{$studentName}%'");
            })
            ->where('email', 'LIKE', "%{$request->get('email')}%");

        if ($course = $request->get('course')) {
            $students = $students->where('course_id', $course);
        }

        return view('search.students', [
            'students' => $students->get(),
        ]);
    }
}
