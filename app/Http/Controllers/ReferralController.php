<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReferralRequest;
use App\Models\Referral;
use App\Services\ReferralService;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    /**
     * Show the referrals dashboard page
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('referrals');
    }

    /**
     * Create a new referral link
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(StoreReferralRequest $request, ReferralService $referralService)
    {
        $validated = $request->validated();

        $referralService->sendReferralLink($request->user(), $validated['emails']);

        return response('Successful', 201);
    }
}
