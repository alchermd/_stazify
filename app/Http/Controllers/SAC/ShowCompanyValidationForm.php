<?php

namespace App\Http\Controllers\SAC;

use App\Models\VerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShowCompanyValidationForm extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        abort_unless($request->user()->can('create', VerificationRequest::class), 401);
        return view('companies.validation.create');
    }
}
