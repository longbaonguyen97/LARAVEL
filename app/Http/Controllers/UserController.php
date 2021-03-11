<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * get all users
     * @return object
     */
    public function index(){
        return User::all();
    }
    /**
     * get detail user
     * @param $id
     * @return array
     */
    public function show($id){
        $users =User::find($id);
        if (empty($users)){
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
    public function store(Request $request)
    {
        return User::create($request->all());

    }

    /**
     * update user
     * @param $id
     * @param Request $request
     * @return array
     */
    public function update($id, Request $request)
    {
        return [
            'code'=>User::where('id',$id)->update($request->all())
        ];
    }

    /**
     * delete user
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        return [
            'code'=>User::where('id',$id)->delete()
        ];
    }


}
