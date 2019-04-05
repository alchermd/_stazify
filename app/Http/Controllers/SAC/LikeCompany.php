<?php

namespace App\Http\Controllers\SAC;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class LikeCompany extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @param  \App\Models\User         $company
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request, User $company)
    {
        abort_unless($request->user()->can('like', $company), 401);

        $request->user()->like($company);

        return response()->json(['message' => 'OK'], 200);
    }
}
