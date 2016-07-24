<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {

    }
    
    public function create()
    {
        $this->authorize('edit-user');

        $roles = Role::where('name', 'not like', '%admin%')->get();
        return view('user.create', compact('roles'));
    }
    
    public function store(Request $data)
    {
        $this->authorize('edit-user');

        $this->validate($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role_id' => $data['usertype']
        ]);

        \Helper::flash_message('User succefully created', true);

        return redirect()->action('UserController@create');
    }
}
