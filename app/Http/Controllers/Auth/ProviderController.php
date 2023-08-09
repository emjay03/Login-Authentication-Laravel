<?php

namespace App\Http\Controllers\Auth;

use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public function redirect($provider)
    { 
        return Socialite::driver($provider)->redirect();
    }
    
    public function callback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
            dd($user);
        } catch (\Exception $e) {
            // Handle the InvalidStateException here
            // For example, you can redirect back with an error message
            return redirect()->route('dashboard')->with('error', 'Authentication failed.');
        }
    }
}
 


