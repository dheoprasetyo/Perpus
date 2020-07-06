<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\BorrowLog;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function membertransaction()
    {
//         passing borrowLogs yang berisi data peminjaman
// yang belum dikembalikan.
        $borrowLogs = Auth::user()->borrowLogs()->borrowed()->get();
        return view('transaction.member', compact('borrowLogs'));
    }

    public function transaction()
    {
        // $user = User::all();
//         passing borrowLogs yang berisi data peminjaman
// yang belum dikembalikan.
        // $borrowLogs = $user;
        // $borrowLogs = \App\User::all()->borrowLogs()->get();
        // Book::with('author')->get()
        $borrowLogs = BorrowLog::with('user')->borrowed()->get();
        return view('transaction.admin', compact('borrowLogs'));
    }
}
