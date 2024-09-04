<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomUserProfileController extends Controller
{
    public function show(Request $request)
    {
        return view('profile.security', [
            'request' => $request,
            'user' => $request->user(),
        ]);
    }
}
