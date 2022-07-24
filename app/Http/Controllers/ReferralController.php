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
        $user = auth()->user();

        $referrals = $user->latestReferrals();

        return view('referrals')->with([
            'referrals' => $referrals,
            'points' => $user->referralPoints,
            'maxPoints' => config('referrals.max_referral_points')
        ]);
    }

    /**
     * Create a new referral link
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(StoreReferralRequest $request, ReferralService $referralService)
    {
        $user = auth()->user();
        $emails = $request->validated()['emails'];

        $referralService->sendReferralLinks($user, $emails);

        return response()->created(['referrals' => $user->latestReferrals()]);
    }
}
