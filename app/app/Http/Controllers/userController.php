<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class userController extends Controller
{
    /**
     * Display user profile.
     *
     * @return \Illuminate\View\View
     */

    public function profile()
    {
        // Dummy user data for testing
        $user = [
            'profile_picture' => 'https://via.placeholder.com/150', // Placeholder image URL
            'name' => 'John Doe',
            'email' => 'johndoe@example.com'
        ];

        // Dummy user lists for testing
        $userLists = [
            [
                'id' => 1,
                'name' => 'Favorites',
                'description' => 'My favorite movies'
            ],
            [
                'id' => 2,
                'name' => 'Watch Later',
                'description' => 'Movies to watch later'
            ]
        ];

        // Dummy watchlist for testing
        $watchlist = [
            [
                'id' => 1,
                'poster_path' => '/path/to/poster1.jpg',
                'title' => 'Movie Title 1',
                'release_date' => '2022-01-01',
                'genre_ids' => [1, 2],
                'vote_average' => 8.5
            ],
            [
                'id' => 2,
                'poster_path' => '/path/to/poster2.jpg',
                'title' => 'Movie Title 2',
                'release_date' => '2022-02-01',
                'genre_ids' => [3, 4],
                'vote_average' => 7.0
            ]
        ];

        // Dummy watch history for testing
        $watchHistory = [
            [
                'movie' => [
                    'id' => 1,
                    'poster_path' => 'https://via.placeholder.com/300x450', // Placeholder image URL
                    'title' => 'Watched Movie 1',
                    'release_date' => '2021-01-01',
                ],
                'watched_at' => now()->subDays(10) // 10 days ago
            ],
            [
                'movie' => [
                    'id' => 2,
                    'poster_path' => 'https://via.placeholder.com/300x450', // Placeholder image URL
                    'title' => 'Watched Movie 2',
                    'release_date' => '2020-02-01',
                ],
                'watched_at' => now()->subDays(20) // 20 days ago
            ],
            [
                'movie' => [
                    'id' => 3,
                    'poster_path' => 'https://via.placeholder.com/300x450', // Placeholder image URL
                    'title' => 'Watched Movie 3',
                    'release_date' => '2019-03-01',
                ],
                'watched_at' => now()->subDays(30) // 30 days ago
            ]
        ];

        // Sample genre map for testing
        $genreMap = [
            1 => 'Action',
            2 => 'Adventure',
            3 => 'Comedy',
            4 => 'Drama'
        ];

        return view('user.profile', compact('user', 'userLists', 'watchlist', 'genreMap', 'watchHistory'));
    }

    /**
     * Resend email verification link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function resendVerificationLink(Request $request)
    {
        // Validate request
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Find the user by email
        $user = User::where('email', $request->email)->first();

        // Resend verification email if user found
        if ($user) {
            $user->sendEmailVerificationNotification(route('user.verify'));
            return back()->with('success', 'Verification link sent! Please check your email.');
        }

        // User not found (should not happen due to validation)
        return back()->with('error', 'User not found.');
    }

    /**
     * Show email verification message.
     *
     * @return \Illuminate\View\View
     */
    public function showVerifyEmailMessage()
    {
        $message = 'Check your email for the verification link.';
        return view('auth.verify', compact('message'));
    }

    /**
     * Verify user email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(Request $request)
    {
        // Attempt to verify the user with the token from the request
        if (
            $request->route('id') && $request->route('id') == $request->user()->getKey() &&
            $request->route('hash') && hash_equals($request->route('hash'), sha1($request->user()->getEmailForVerification()))
        ) {
            // Mark the user's email as verified
            $request->user()->markEmailAsVerified();

            // Redirect to login page with success message
            return redirect('/login')->with('success', 'Email verified successfully!');
        }

        // Verification failed, redirect to login with error message
        return view('auth.verify')->with('error', 'Invalid verification link');
    }

    /**
     * Show registration form.
     *
     * @return \Illuminate\View\View
     */
    public function register()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        // Validate the incoming request data
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            // Authentication successful
            $request->session()->regenerate();

            // Redirect to a specific route or return a response
            return redirect()->intended('/profile');
        }

        // Authentication failed
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function getLogin()
    {
        return view('auth.login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // Redirect to the homepage or any other page after logout
    }


    /**
     * Create a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request)
    {
        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:50000', // Max 50MB
            'bio' => 'nullable|string|max:1000',
        ]);

        // Handle validation errors
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Handle profile picture upload
        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        // Create the user
        $user = User::create([
            'username' => $request->username,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'country' => $request->country,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_picture' => $profilePicturePath,
            'bio' => $request->bio,
        ]);

        // Send email verification notification
        $user->sendEmailVerificationNotification(route('user.verify'));

        // Redirect to verify page with success message and user's email
        return redirect('/verify')->with(['success' => 'User created successfully! Please check your email for verification.', 'userEmail' => $user->email]);
    }
}
