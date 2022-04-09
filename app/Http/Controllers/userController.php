<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use Illuminate\Http\Request;
use \App\Models\User;

class userController extends Controller
{

    // -- PROTECT THIS CONTROLLER --

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        if ($users->isEmpty()){
            return ['status' => 200, 'desc' => 'no users available'];
        }

        return ['status' => 200, 'desc' => 'Users fetched successfully', 'data'=> $users];

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUser($user_id)
    {
        $user = User::find($user_id);

        if (is_null($user)){
            return ['status' => 200, 'desc' => 'user not found'];
        }

        return ['status' => 200, 'desc' => 'User fetched successfully', 'data'=> $user];

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validatedData = $this->validate($request,[
            'first_name' => ['required','String'],
            'last_name' => 'required',
            'email' => ['required','email'],
            'phone' => ['required', 'Integer'],
            'password' => ['required', 'String'],
            'address' => ['required', 'String'],
            'state' => 'string',
            'city' => 'string',
            'country' => 'string',
            'photo' => 'required|string',
            'role'=> ['required', 'Integer', 'exists:user_roles,id']
        ]);

        if (User::where('email', '=', $request->email)->exists() OR User::where('phone', '=', $request->phone)->exists()){
            return  ['status' => '406', 'desc' =>'User already exists'];
        }

        try {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => md5($request->password),
                'address' => $request->address,
                'role'=> $request->role,
            ]);
        } catch (\Exception $e){
        return  ['status' => '500', 'desc' => $e->getMessage()];
        }



        return ['status' => 200, 'desc' => 'user created successfully', 'data'=> $user ];

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $this->validate($request,[
            'first_name' => ['String'],
            'last_name' => 'String',
            'email' => ['email'],
            'phone' => ['Integer'],
            'password' => ['String'],
            'address' => ['String'],
            'role'=> ['string']
        ]);

        $user = User::find($id);
        if ($user->isEmpty()){
            return ['status' => 500, 'desc' => 'user not found', 'data'=> $user ];
        }
        isset ($request->first_name) ? $user->first_name = $request->first_name: false;
        isset ($request->last_name) ? $user->last_name = $request->last_name: false;
        isset ($request->email) ? $user->email = $request->email: false;
        isset ($request->phone) ? $user->phone = $request->phone: false;
        isset ($request->password) ? $user->password = md5($request->password) : false;
        isset ($request->address) ? $user->address = $request->address : false;
        isset ($request->role) ? $user->role = $request->role : false;
        $user->save();

        return ['status' => 200, 'desc' => 'user updated successfully', 'data'=> $user ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::destroy($id);

        if (!$user){
            return ['status' => 500, 'desc' => 'user was not deleted' ];
        }

        return ['status' => 200, 'desc' => 'user has been deleted successfully' ];


    }
}
