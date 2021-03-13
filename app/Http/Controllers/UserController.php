<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
class UserController extends Controller
{
    /**
     * get all users
     * @return object
     */
    public function index()
    {
        return User::all();
    }

    /**
     * get detail user
     * @param $id
     * @return array
     */
    public function show($id)
    {
        $users = User::find($id);
        if (empty($users)) {
            return [
                'code'=>0,
                'data'=>[]
            ];
        }
        return [
            'code'=>1,
            'data'=>[$users]
        ];
    }

    /**
     * pagination table users
     * @return array
     */
    public function pagination(){
        $users = DB::table('users')->paginate(5);
        return $users;
    }

    /**
     * create user
     * @param Request $request
     * @return mixed
     */
    public function store(StorePostRequest $request)
    {
//        $validator = Validator::make($request->all(),
//            [
//                'first_name' => 'required|max:255',
//                'last_name' => 'required',
//                'email' => 'unique:users,email|required|regex:/^.+@.+$/i'
//            ],
//            [
//                'first_name.required' => 'Loi ne',
//                'email.regex' => 'Email sai roi',
//                'email.unique' => 'Email da ton tai'
//            ]
//        );
//        if ($validator->fails()) {
//
//            return [
//                'code'=>0,
//                'data'=>[
//                    'error'=>$validator->errors()
//                ]
//            ];
//        } else {
//            DB::table('users')->insert([
//                'first_name' => $request->get('first_name'),
//                'last_name' => $request->get('last_name'),
//                'email' => $request->get('email'),
//                'password' => Hash::make($request->get('password'))
//            ]);
//
//            return [
//                'code' => 1
//            ];
//        }

        $user = User::create([
            "first_name" => $request->input('first_name'),
            "last_name" => $request->input('last_name'),
            "password" => Hash::make($request->input('password')),
            "email" => $request->input('email')
        ]);

        return [
            'code' => 1,
            'data' => [
                'user' => response($user)
            ]
        ];


    }

    /**
     * update user
     * @param $id
     * @param Request $request
     * @return array
     */
    public function update($id, UpdateRequest $request)
    {

        $user = User::find($id);
        if(empty($user)){
            return [
                'code'=>0
            ];
        }
        $user->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);
        return [
            'code'=>1,
            'data'=>[
                'user'=>$user
            ]
        ];
    }

    /**
     * delete user
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if(empty($user)){
            return [
                'code'=>0
            ];
        }

        User::destroy($id);

        return [
            'code'=>1,
            'user'=>$user
        ];

    }


}
