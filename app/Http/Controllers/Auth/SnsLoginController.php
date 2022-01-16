<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
use Auth;

use App\Models\User;

class SnsLoginController extends Controller
{
  public function redirectToProvider($provider){
    return Socialite::driver($provider)->redirect();
  }

  public function handleProviderCallback($provider){
    $social_user = Socialite::driver($provider)->user();

    $provider_id = $provider . '_id';

    $user = User::firstOrNew([$provider_id => $social_user->id]);

    if(!$user->exist){
      $user->fill(['username' => $social_user->name])->save();
    }
    $user->fill(['image' => $social_user->avatar_original])->save();

    Auth::login($user);
    Auth::user()->fill(['login_time' => now()])->save();
    return redirect()->route('home');
  }
}
