<?php
  
namespace App\Http\Controllers\Auth;
  
use App\Http\Controllers\Controller;
use Socialite;
use Auth;
use Exception;
use App\User;
  
class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
      
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {
    

            $user = Socialite::driver('google')->user();
     
            $finduser = User::where('google_id', $user->id)->first();

            if($finduser){
     
                Auth::login($finduser);
                    return redirect('/admin');
                }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'password' => encrypt('123456dummy'),
                    'estado' => 1
                ]);
    
                Auth::login($newUser);
     
                return redirect('/admin');
            }
    
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}