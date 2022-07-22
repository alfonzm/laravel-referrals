<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReferralRequest;
use App\Models\Referral;
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
    public function store(StoreReferralRequest $request)
    {
        $validated = $request->validated();

        $emails = collect($validated['emails'] ?? [])
            ->map(function ($email) {
                return [
                    'referrer_user_id' => auth()->user()->id,
                    'recipient_email' => $email,
                ];
            });

        $request->user()
            ->referrals()
            ->createMany($emails);

        return response('Successful', 201);
    }
}
