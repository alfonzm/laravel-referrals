<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Referral;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    /**
     * Show the referrals dashboard page for administrators
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $referrals = Referral::with('referrer')->latest()->get();
        return view('admin/referrals')->with(['referrals' => $referrals]);
    }
}
