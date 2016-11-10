<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['get_token']]);
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

    public function get_token(Request $request)
    {
        $email = $request->email;
        $password = base64_decode($request->password);

//        $input = "SmackFactory";
//
//        $encrypted = $this->encryptIt( $input );
//        $decrypted = $this->decryptIt( $encrypted );

        if (Auth::attempt(['email' => $email, 'password' => $password])) {

            $user = Auth::user();
            $token = $user->api_token;

            $names = DB::table('permissions')->select('slug')->get();
            $permissions = [];

            foreach ($names as $name)
            {
                if($user->can($name->slug))
                $permissions[] = $name->slug;
            }

            return response()->json([
                'success'=> true,
                'token' => $token,
                'uname' => $user->name,
                'email' => $user->email,
                'role' => $user->role->name,
                'permissions' => $permissions
                ]);
        }
        return response()->json([
            'success'=> false,
            'token' => '',
            'uname' => '',
            'email' => '',
            'role' => '',
            'permissions' => []
        ]);
    }

    function encryptIt( $q ) {
        $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
        $qEncoded      = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
        return( $qEncoded );
    }

    function decryptIt( $q ) {
        $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
        $qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
        return( $qDecoded );
    }
}
