<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Role;
use App\User;
use Illuminate\Support\Facades\Auth;
use Session;

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
        $id = Auth::id();
        $active = User::where('id', '=', $id)->first();
        if($active->active == 1){
            $posts = Post::orderBy('created_at', 'desc')->limit(4)->get();
            return view('home')->withPosts($posts);
        }else{
            Auth::logout();
            return view('errors/unactive');
        }
    }

    public function getAdminPage()
    {
        $users = User::all();
        return view('roles.admin', ['users' => $users]);
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
        return redirect()->route('account');
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

    public function toggle()
    {
        $data = Request::capture()->all();
        $state = User::where('id', '=', $data['user_id'])->first();
        if ($state->active == 1) {
            User::where('id', '=', $data['user_id'])->update(array('active' => 0));
            $toggleState = 'images/nonactive.png';
        } else {
            User::where('id', '=', $data['user_id'])->update(array('active' => 1));
            $toggleState = 'images/active.png';
        }
        return $toggleState;
    }
}
