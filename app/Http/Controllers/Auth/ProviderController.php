<?php

namespace App\Http\Controllers\Auth;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
 
class ProviderController extends Controller
{
    public function redirect($provider)
    { 
        return Socialite::driver($provider)->redirect();
    }
    
    public function callback($provider)
    {
        try{
            $SocialUser = Socialite::driver($provider)->user();
           
            $user=User::where([
                'provider'=>$provider,
                'provider_id'=>$SocialUser->getId()
            ])->first();
            if(!$user){
                $user=User::create([
                    'name'=>$SocialUser->getName(),
                    'email'=>$SocialUser->getEmail(),
                    'username' => (new User())->generateUserName($SocialUser->getNickname()), // Create an instance and call the method
                    'provider'=>$provider,
                    'provider_id'=>$SocialUser->getId(),
                    'provider_token'=>$SocialUser->token,
                    'email_verified_at'=>now()
                    
                ]);
            }
            Auth::login($user); 
            return redirect('/dashboard');
           
        }
        catch(\Exception $e){
            return redirect('/login');
        }
    }

}
 


