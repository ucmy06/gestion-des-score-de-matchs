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
        $user = $request->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only('name', 'email'));

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }

    public function destroy(Request $request)
    {
        $user = $request->user();
        $user->delete();

        return redirect('/')->with('success', 'Profile deleted successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = $request->user();

        // Vérifier le mot de passe actuel
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Mise à jour du mot de passe
        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Password updated successfully.');
    }
}
