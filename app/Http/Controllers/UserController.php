<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchUsersRequest;
use App\Http\Requests\UsersStoreRequest;
use App\Http\Requests\UsersUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * get all users
     * @return object
     */
    public function index()
    {
        $query = "SELECT * FROM users WHERE is_deleted = 1";
        return DB::select($query);
    }

    /**
     * get detail user
     * @param $id
     * @return array
     */
    public function show($id)
    {
        $query = "SELECT * FROM users WHERE id = $id and is_deleted = 1";
        $result = DB::select($query);
        if (empty($result)) {
            return [
                'code' => 0,
                'data' => []
            ];
        }
        return [
            'code' => 1,
            'data' => [$result]
        ];
    }

    public function search(SearchUsersRequest $request)
    {
        $condition = "";
        $input = $request->input();
        foreach ($input as $key => $val) {
            if ($val) {

                if (end($input) !== $val) {
                    $condition .= "$key LIKE '%$val%' OR ";
                } else {
                    $condition .= "$key LIKE '%$val%'";
                }
            }
        }

        $query = "SELECT * FROM users WHERE $condition";
        $result = DB::select($query);
        if (empty($result)) {
            return [
                'code' => 0,
                'data' => []
            ];
        }
        return [
            'code' => 1,
            'data' => [$result]
        ];
    }

    /**
     * pagination table users
     * @return array
     */
    public function pagination($num_page = 10)
    {
        $total = DB::select('SELECT COUNT(*) as count FROM users');
        $total = $total[0]->count;
        $users = DB::select("SELECT id, first_name, last_name, email, email_verified_at,is_deleted,remember_token,created_at,updated_at FROM users LIMIT $num_page");
        $testusers = DB::select("SELECT * FROM users LIMIT 10");
        $result = [
            'total' => $total,
            'users'=> $testusers
        ];
        return [
            'code' => 1,
            'data' => $users
        ];
    }

    /**
     * create user
     * @param Request $request
     * @return mixed
     */
    public function store(UsersStoreRequest $request)
    {
        $query = "INSERT INTO users (first_name,last_name,email, password) VALUES (?,?,?,?)";
        $values = [$request->input('first_name'), $request->input('last_name'), $request->input('email'), Hash::make($request->input('password'))];

        $result = DB::insert($query, $values);
        return [
            'code' => 1,
            'data' => [
                'user' => $result
            ]
        ];
    }

    /**
     * update user
     * @param $id
     * @param Request $request
     * @return array
     */
    public function update($id, UsersUpdateRequest $request)
    {
        $col = "";
        $input = $request->input();
        foreach ($input as $key => $val) {
            if ($val) {
                if ($key === "password") {
                    $val = Hash::make($val);
                }

                if (end($input) !== $val) {
                    $col .= "$key= '$val',";
                } else {
                    $col .= "$key='$val'";
                }

            }
        }
        $query = "update users set $col where id = $id";

        $result = DB::update($query);
        if (empty($result)) {
            return [
                'code' => 0
            ];
        }
        return [
            'code' => 1,
            'data' => [
                'user' => self::show($id)
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
        $query = "update users set is_deleted = 0 where id = $id";
        $result = DB::update($query);
        if (empty($result)) {
            return [
                'code' => 0
            ];
        }
        return [
            'code' => 1,
            'user' => $result
        ];

    }


}
