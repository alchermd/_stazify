<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobpost;
use App\Http\Requests\UpdateJobpost;
use App\Models\Jobpost;
use App\Models\Skill;
use App\Services\JobpostFormatService;
use App\Services\JobpostService;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class JobpostController extends Controller
{
    /** @var JobpostService */
    private $service;

    /**
     * Create a new controller instance.
     * @param JobpostService $service
     */
    public function __construct(JobpostService $service)
    {
        $this->middleware('auth');
        $this->middleware('company')->only(['create', 'edit']);

        $this->service = $service;
    }

    /**
     * Show the index page for job posts.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('jobposts.index', [
            'jobposts' => $request->user()->getJobposts(),
        ]);
    }

    /**
     * Show the job post creation form.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('jobposts.create');
    }

    /**
     * Persist the new job post data.
     *
     * @param StoreJobpost $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreJobpost $request)
    {
        $validatedData = $request->validated();

        $jobpostData = $this->service->buildJobpostData($validatedData);
        if ($this->service->checkIfDeadlineHasElapsed($jobpostData['deadline'])) {
            $errors = new MessageBag();
            $errors->add('deadline', 'Date has already elapsed.');

            return back()->withErrors($errors)->withInput($request->input());
        }

        $jobpost = $request->user()->jobposts()->create($jobpostData);
        $request->session()->flash('status', 'Job successfully posted!');

        // Attach each line of the required skills from the payload to the jobpost instance.
        $requiredSkills = explode("\r\n", $validatedData['required_skills']);
        foreach ($requiredSkills as $skill) {
            $skill = Skill::firstOrCreate(['name' => $skill]);
            $jobpost->skills()->attach($skill);
        }

        return redirect('/home');
    }

    /**
     * Display the details of a job post.
     *
     * @param Jobpost $jobpost
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Jobpost $jobpost, Request $request)
    {
        if (!$request->user()->jobposts->contains($jobpost)) {
            $jobpost->update([
                'views' => $jobpost->views + 1,
            ]);
        }

        return view('jobposts.show', [
            'jobpost' => $jobpost,
        ]);
    }

    /**
     * Show the jobpost edit form.
     *
     * @param Jobpost $jobpost
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Jobpost $jobpost)
    {
        return view('jobposts.edit', [
            'jobpost' => $jobpost,
            'formatter' => new JobpostFormatService($jobpost),
        ]);
    }

    /**
     * Update a jobpost's data.
     *
     * @param Jobpost $jobpost
     * @param UpdateJobpost $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Jobpost $jobpost, UpdateJobpost $request)
    {
        $validatedData = $request->validated();

        $jobpostData = $this->service->buildJobpostData($validatedData);
        if ($this->service->checkIfDeadlineHasElapsed($jobpostData['deadline'])) {
            $errors = new MessageBag();
            $errors->add('deadline', 'Date has already elapsed.');

            return back()->withErrors($errors)->withInput($request->input());
        }

        $newRequiredSkills = explode("\r\n", $validatedData['required_skills']);
        $oldRequiredSkills = $jobpost->skills->pluck('name')->toArray();

        $requiredSkillsToAdd = array_diff($newRequiredSkills, $oldRequiredSkills);
        $requiredSkillsToDelete = array_diff($oldRequiredSkills, $newRequiredSkills);

        foreach ($requiredSkillsToAdd as $skill) {
            $skill = Skill::firstOrCreate(['name' => $skill]);
            $jobpost->skills()->attach($skill);
        }

        foreach ($requiredSkillsToDelete as $skill) {
            $skill = Skill::where('name', $skill)->first();
            $jobpost->skills()->detach($skill);
        }

        $jobpost->update($jobpostData);
        $request->session()->flash('Jobpost updated!');

        return redirect('/home/jobs/' . $jobpost->id);
    }
}
