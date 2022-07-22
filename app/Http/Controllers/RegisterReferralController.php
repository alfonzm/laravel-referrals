<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterReferralRequest;
use App\Models\Referral;
use Illuminate\Http\Request;

class RegisterReferralController extends Controller
{
    public function __invoke(Request $request) {
        return redirect(route('register', ['code' => $request->get('code')]));
    }
}
