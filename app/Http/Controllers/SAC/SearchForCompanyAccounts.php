<?php

namespace App\Http\Controllers\SAC;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SearchForCompanyAccounts extends Controller
{
    /**
     * SearchForCompanyAccounts constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $companyName = strtoupper($request->get('company_name'));
        $companies = User::where('account_type', 2)
            ->whereRaw("UPPER(company_name) LIKE '%{$companyName}%'")
            ->where('email', 'LIKE', "%{$request->get('company_email')}%");

        if ($industry = $request->get('industry')) {
            $companies = $companies->where('industry_id', $industry);
        }

        return view('search.companies', [
            'companies' => $companies->get(),
        ]);
    }
}
