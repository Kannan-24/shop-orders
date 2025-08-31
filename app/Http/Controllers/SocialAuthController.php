<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class SocialAuthController extends Controller
{
    /**
     * Redirect to Google OAuth
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Check if user already exists with this email
            $existingUser = User::where('email', $googleUser->email)->first();
            
            if ($existingUser) {
                // Update existing user with Google info
                $existingUser->update([
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                ]);
                
                Auth::login($existingUser);
                
                return redirect()->intended('/dashboard')->with('success', 'Logged in successfully!');
            }
            
            // Create new user
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'avatar' => $googleUser->avatar,
                'password' => null, // No password for social login
                'role' => 'admin', // Default role, you can change this
                'is_active' => true,
            ]);
            
            Auth::login($user);
            
            return redirect()->intended('/dashboard')->with('success', 'Account created and logged in successfully!');
            
        } catch (Exception $e) {
            return redirect('/login')->with('error', 'Something went wrong with Google authentication. Please try again.');
        }
    }
}
