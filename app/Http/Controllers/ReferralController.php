<?php

namespace App\Http\Controllers;

use App\Enums\ReferralStatus;
use App\Http\Requests\StoreReferralRequest;
use App\Services\ReferralService;

class ReferralController extends Controller
{
    /**
     * Show the referrals dashboard page
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $referrals = auth()->user()->referrals;
        $claimedReferrals = $referrals->where('status', ReferralStatus::Claimed);

        return view('referrals')->with([
            'referrals' => $referrals,
            'claimedReferrals' => $claimedReferrals
        ]);
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
