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
        $this->authorize('edit-user');

        $user = User::find($id);
        $roles = Role::where('name', 'not like', '%admin%')->get();

        return view('user.show', compact('user', 'roles'));
    }

    public function index()
    {
        $this->authorize('edit-user');

        $users = User::where('role_id', '>', '2')
            ->where('name', 'not like', 'roger%')
            ->get();

        return view('user.index', compact('users'));
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

    public function update(Request $data, $id)
    {
        $this->authorize('edit-user');

        $this->validate($data, [
            'name' => 'required|max:255',
//            'email' => 'required|email|max:255|unique:users',
            'password' => 'confirmed|min:6',
        ]);

        $user = User::find($id);
        $user->name = $data->name;
        $user->role_id = $data['usertype'];

        if(!empty($data['password']))
        {
            $user->password = bcrypt($data['password']);
        }

        $user->save();
        \Helper::flash_message('User succefully updated', true);
        return redirect()->back();
    }
}
