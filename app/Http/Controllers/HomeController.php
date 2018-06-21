<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
    /* Function to manage login from user table */

    public function user_login_by_id($user_id)
    {
        //Get current user (Admin) id
        $current_admin_id = Auth::user()->id;

        //Manage session var
        if (session('back_to_admin_id') == $user_id) {
            session()->forget('back_to_admin_id');
        } else {
            session(['back_to_admin_id' => $current_admin_id]);
        }

        Auth::loginUsingId($user_id); //Login by id
        return redirect('home');
    }
}
