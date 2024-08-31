<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        // Validation des champs de profil
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $request->user()->id,
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = $request->user();

        // Mise à jour du profil
        $user->update($request->only('name', 'email'));

        // Mise à jour du mot de passe
        if ($request->filled('current_password') && $request->filled('new_password')) {
            if (!Hash::check($request->input('current_password'), $user->password)) {
                return redirect()->route('profile.edit')->withErrors(['current_password' => 'Current password is incorrect.']);
            }
            $user->password = Hash::make($request->input('new_password'));
            $user->save();
        }

        return redirect()->route('profile.edit')->with('success', 'Profile and/or password updated successfully.');
    }

    public function destroy(Request $request)
    {
        $user = $request->user();
        $user->delete();

        return redirect('/')->with('success', 'Profile deleted successfully.');
    }
}
