<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\User;
use App\Book;
use Hash;
use App\BorrowLog;

use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MembersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = Role::where('name', 'member')->first()->users;
        return view('members.index',compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMemberRequest $request)
    {
        $password = Str::random(6);
        $data = $request->all();
        $data['password'] = Hash::make($password);
        // bypass verifikasi
        $data['is_verified'] = 1;
        $member = User::create($data);
        // set role
        $memberRole = Role::where('name', 'member')->first();
        $member->attachRole($memberRole);
        // kirim email
        Mail::send('auth.emails.invite', compact('member', 'password'), function ($m) use ($member) {
         $m->to($member->email, $member->name)->subject('Anda telah didaftarkan di Larapus!');
        });

        return redirect()->route('members.index')->with('sukses','Data ' . $data['email'] . 'Password '. $password . ' Berhasil Ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $member = User::find($id);
        return view('members.show', compact('member'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMemberRequest $request, $id)
    {
        $member = User::find($id);
        $member->update($request->only('name','email'));

        return redirect()->route('members.index')->with('sukses','Berhasil menyimpan ' . $member->name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $member = User::find($id);
        // $borrowLogs = BorrowLog::with($member)->borrowed()->get();

        // $members = $member->borrowLogs()->borrowed()->get();
        if ($member->hasRole('member')) {
            if($member->borrowLogs()->borrowed()->count() > 0 ) {
                // dd($member);
                return redirect()->route('members.index')->with('sukses','tidak Berhasil dihapus ' . $member->name);
            }
            // echo "hai" ;
                $member->delete();
        }
                // dd($member);
                return redirect()->route('members.index')->with('sukses','Berhasil dihapus ');
        // }
    }
}
