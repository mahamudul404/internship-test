<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function profile()
    {
        return view('home');
    }

    public function products()
    {
        return view('products');
    }

    public function uploadProfilePicture(Request $request)
    {
        
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        /** @var User $user */
        $user = Auth::user();

        // Handle old profile picture deletion
        if ($user->image) {
            Storage::delete('public/profile_images/' . $user->image);
        }

        // Store new image
        $image = $request->file('profile_picture');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/profile_images', $imageName);

        // Update user's profile image
        $user->image = $imageName;
        $user->save();

        // Return response to the frontend
        return response()->json([
            'success' => true,
            'message' => 'Profile picture uploaded successfully.',
            'image_url' => asset('storage/profile_images/' . $imageName),
        ]);
    }
}
