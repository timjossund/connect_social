<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

class UserController extends Controller
{
    public function register(Request $request) {
        $incomingFields = $request->validate([
            'username' => ['required', 'min:3', 'max:20', Rule::unique('users', 'username')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'confirmed']
        ]);

        $incomingFields['password'] = bcrypt($incomingFields['password']);

        $user = User::create($incomingFields);
        auth()->login($user);
        return redirect('/')->with('success', 'You are registered and logged in!');
    }

    public function showAvatarForm() {
        return view('avatar-form');
    }

    public function saveAvatar(Request $request) {
        $request->validate([
            'avatar' => 'required|image|max:8000'
        ]);

        $user = auth()->user();

        $filename = $user->id . "-" . uniqid() . ".jpg";

        $imgManager = new ImageManager(new Driver());
        $image = $imgManager->read($request->file('avatar'));
        $imageData = $image->cover(120, 120)->toJpeg();
        Storage::put("public/avatars/" . $filename, $imageData); 

        $oldAvatar = $user->avatar;

        $user->avatar = $filename;
        $user->save();

        if($oldAvatar != "/fallback-avatar.jpg") {
            Storage::delete(str_replace("/storage/", "public/", $oldAvatar));
        }

        return redirect('/profile/' . auth()->user()->username)->with('success', 'Avatar Saved!');
    }

    public function login(Request $request) {
        $incomingFields = $request->validate([
            'loginusername' => 'required',
            'loginpassword' => 'required'
        ]);

        if (auth()-> attempt(['username' => $incomingFields['loginusername'], 'password' => $incomingFields['loginpassword']])) {
            $request->session()->regenerate();
            return redirect('/')->with('success', 'You are now logged in!');
        } else {
            return redirect('/')->with('error', 'Login failed!');
        }
    }

    public function logout() {
        auth()->logout();
        return redirect('/')->with('success', 'You are now logged out!');
    }

    public function showCorrectHomepage() {
        if (auth()->check()) {
            return view('homepage-feed');
        } else {
            return view('homepage');
        }
    }

    public function showProfile(User $user) {
        return view('profile', ['avatar' => $user->avatar, 'username' => $user->username, 'posts' => $user->posts()->latest()->get()]);
    }
}
