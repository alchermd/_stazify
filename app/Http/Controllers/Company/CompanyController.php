<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterCompany;
use App\Models\Industry;
use App\Models\User;

class CompanyController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the company registration form.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('companies.create', [
            'industries' => Industry::all(),
        ]);
    }

    /**
     * Persist a new company account.
     *
     * @param RegisterCompany $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(RegisterCompany $request)
    {
        $companyData = $this->buildCompanyData($request->validated());
        $company = User::create($companyData);

        auth()->login($company);
        $request->session()->flash('status', 'You are now registered, '.$company->company_name.'!');

        return redirect('/home');
    }

    /**
     * Build the company's data from the form inputs.
     *
     * @param array $validatedData
     *
     * @return array
     */
    private function buildCompanyData(array $validatedData)
    {
        // Store the provided photo, generate an adorable avatar otherwise.
        if (isset($validatedData['avatar'])) {
            $path = $validatedData['avatar']->store('avatars', 'public');
            $validatedData['avatar_url'] = '/storage/'.$path;
        } else {
            $encodedName = urlencode($validatedData['company_name']);
            $validatedData['avatar_url'] = "https://api.adorable.io/avatars/285/{$encodedName}@adorable.png";
        }
        unset($validatedData['avatar']);

        // Rest of the transformation.
        $validatedData['password'] = bcrypt($validatedData['password']);
        $validatedData['contact_number'] = '+639'.$validatedData['contact_number'];

        return $validatedData;
    }
}
