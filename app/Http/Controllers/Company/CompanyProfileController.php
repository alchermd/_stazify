<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditCompanyProfile;
use App\Models\Industry;
use App\Models\User;
use Illuminate\Http\Request;

class CompanyProfileController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show a company's profile page.
     *
     * @param User $user
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user, Request $request)
    {
        if ($user->isStudent()) {
            return redirect('/home/students/' . $user->id);
        }

        if ($request->user()->id !== $user->id) {
            $user->update([
                'profile_views' => $user->profile_views + 1
            ]);
        }

        return view('company-profile.show', [
            'company' => $user,
            'industries' => Industry::all(),
        ]);
    }

    /**
     * Update a company's profile.
     *
     * @param EditCompanyProfile $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(EditCompanyProfile $request)
    {
        $validatedData = $this->buildUpdatedCompanyProfile($request->validated());

        $request->user()->update($validatedData);
        $request->session()->flash('status', 'Profile updated!');

        return redirect('/home/companies/' . $request->user()->id);
    }

    /**
     * Build the updated company data from the validated form input.
     *
     * @param array $validatedData
     *
     * @return array
     */
    private function buildUpdatedCompanyProfile(array $validatedData): array
    {
        // Store the provided photo if provided.
        if (isset($validatedData['avatar'])) {
            $path = $validatedData['avatar']->store('avatars', 'public');
            $validatedData['avatar_url'] = '/storage/' . $path;
        }
        unset($validatedData['avatar']);

        // Rest of the transformation.
        $validatedData['contact_number'] = '+639' . $validatedData['contact_number'];

        return $validatedData;
    }
}
