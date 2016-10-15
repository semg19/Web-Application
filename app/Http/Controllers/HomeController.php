<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Role;
use App\User;
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
        $posts = Post::orderBy('created_at', 'desc')->limit(4)->get();
        return view('home')->withPosts($posts);
    }

    public function getAuthorPage()
    {
        return view('author');
    }

    public function getAdminPage()
    {
        $users = User::all();
        return view('admin', ['users' => $users]);
    }

    public function getAccount()
    {
        return view('account.edit', ['user' => Auth::user()]);
    }

    public function postSaveAccount(Request $request) {
        $this->validate($request, array(
            'name' => 'required|max:225',
            'email' => 'required|max:225',
        ));

        $user = Auth::user();
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->update();

        Session::flash('success', 'Account updated.');
        return redirect()->route('account.edit');
    }

    public function postAdminAssignRoles(Request $request)
    {
        $user = User::where('email', $request['email'])->first();
        $user->roles()->detach();
        if ($request['role_user']) {
            $user->roles()->attach(Role::where('name', 'User')->first());
        }
        if ($request['role_author']) {
            $user->roles()->attach(Role::where('name', 'Author')->first());
        }
        if ($request['role_admin']) {
            $user->roles()->attach(Role::where('name', 'Admin')->first());
        }
        return redirect()->back();
    }
}
