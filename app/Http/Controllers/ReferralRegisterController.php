<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReferralRegisterController extends Controller
{
    public function __invoke(Request $request) {
        return redirect(route('register', ['code' => $request->get('code')]));
    }
}
