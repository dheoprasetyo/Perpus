<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;
class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function profile()
    {
        return view('settings.profile');
    }

    public function editProfile()
    {
        return view('settings.edit-profile');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
        'name' => 'required',
        'email' => 'required|unique:users,email,' . $user->id
        ]);

        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->save();

        return redirect('/')->with('sukses','Profile Berhasil Disimpan');


    }

    public function editPassword()
    {
        return view('settings.edit-password');
    }

//     Untuk field password, menggunakan rule passcheck dengan parameter
// password user saat ini. Rule passcheck tidak dimiliki Laravel, kita akan membuat
// rule ini untuk memastikan input password user sama dengan password yang tercatat
// di database pada pembahasan selanjutnya.

// membuat rule passcheck untuk
// melakukan validasi password lama user.
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'password' => 'required|passcheck:' . $user->password,
            'new_password' => 'required|confirmed|min:6',
        ],[
            'password.passcheck' => 'Password lama tidak sesuai'
        ]);

        $user->password = Hash::make($request->get('new_password'));
        $user->save();
        return redirect()->route('edit.pass')->with('sukses','Password Berhasil Dirubah');

    }
}
