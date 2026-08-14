<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdatePasswordRequest;
use App\Http\Requests\Admin\UpdateProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display admin profile management page.
     */
    public function index(): View
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.profile.index', compact('admin'));
    }

    /**
     * Update admin profile details (Name & Email).
     */
    public function updateProfile(UpdateProfileRequest $request): RedirectResponse
    {
        $admin = Auth::guard('admin')->user();
        $admin->update($request->validated());

        return back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Update admin password.
     */
    public function updatePassword(UpdatePasswordRequest $request): RedirectResponse
    {
        $admin = Auth::guard('admin')->user();
        $admin->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password changed successfully.');
    }
}
