<?php

namespace App\Http\Controllers\SAC;

use App\Http\Controllers\Controller;
use App\Models\Jobpost;
use Illuminate\Http\Request;

class SearchForJobposts extends Controller
{
    /**
     * SearchForJobposts constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Search for a jobpost.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $title = strtoupper($request->get('title'));

        $jobposts = Jobpost::whereRaw("UPPER(title) LIKE '%{$title}%'")
            ->whereHas('user', function ($query) use ($request) {
                $companyName = strtoupper($request->get('company_name'));

                return $query->whereRaw("UPPER(company_name) LIKE '%{$companyName}%'");
            });

        // Find all jobposts that contains ALL of the skills passed from the query string
        // TODO: Find a "less hacky" way than using reduce.
        if ($request->get('skills')) {
            $skills = collect($request->get('skills'));

            $jobposts = $skills->reduce(function ($prevSkill, $currSkill) use ($jobposts) {
                $skillName = strtoupper($currSkill);

                return $jobposts->whereHas("skills", function ($query) use ($skillName) {
                    $query->whereRaw("UPPER(name) LIKE '%{$skillName}%'");
                });
            }, $skills[0]);
        }


        return view('search.jobposts', [
            'jobposts' => $jobposts->get(),
        ]);
    }
}
