<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchUsersRequest;
use App\Http\Requests\UsersUpdateRequest;
use App\Http\Requests\UsersStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    /**
     * Get all users
     *
     * @return array
     */
    public function getListUsers()
    {
        $userModel = new User();

        $selectRawQuery = [
            [
                'strRaw' => 'u.first_name, u.last_name, u.email, u.phone',
                'params' => []
            ]
        ];
        $whereRawQuery = [
            [
                'strRaw'=>'u.is_deleted <> ?',
                'params'=>[1]
            ]
        ];
        $user = $userModel->getListUser($selectRawQuery, $whereRawQuery);
        if (empty($user)) {
            return [
                'code' => 0,
                'data' => []
            ];
        }
        return [
            'code' => 1,
            'data' => $user
        ];
    }

    /**
     * Get detail user
     *
     * @param int $id
     * @return array
     */
    public function getUserId(int $id)
    {
        $userModel = new User();

        $selectRawQuery = [
            [
                'strRaw' => 'u.first_name, u.last_name, u.email, u.phone',
                'params' => []
            ]
        ];
        $whereRawQuery = [
            [
                'strRaw'=>'u.is_deleted <> ? AND u.user_id = ?',
                'params'=>[1,$id]
            ]
        ];
        $user = $userModel->getDetailUser($selectRawQuery,$whereRawQuery);
        if (empty($user)) {
            return [
                'code' => 0,
                'data' => []
            ];
        }
        return [
            'code' => 1,
            'data' => $user
        ];
    }

    /**
     * Search
     *
     * @param SearchUsersRequest $request
     * @return array
     */
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
     * Pagination table users
     * @param int $num_page
     * @return array
     */
    public function getUsersPagination($num_page)
    {
//        $total = DB::select('SELECT COUNT(*) as count FROM users');
//        $total = $total[0]->count;
//        $users = DB::select("SELECT id, first_name, last_name, email, email_verified_at,is_deleted,remember_token,created_at,updated_at FROM users LIMIT $num_page");
            $data= DB::table('users')->Paginate($num_page);
            return [
                'code' => 1,
                'data' => [$data]
            ];
    }

    /**
     * Create user
     * @param Request $request
     * @return mixed
     */
    public function createUser(UsersStoreRequest $request)
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
     * Update user
     *
     * @param int $id
     * @param Request $request
     * @return array
     */
    public function update(UsersUpdateRequest $request, $id)
    {
        $user = User::find($id);

        //not find user
        if(empty($user)) {
            return [
                "code"=> 0,
                "data"=>[]
            ];
        }
        $dataRequest = $request->only('first_name', 'last_name', 'email', 'password');
        $user->update($dataRequest);
        return [
            "code"=> 1,
            "data"=>[$user]
        ];
    }

    /**
     * Delete user
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        $query = "UPDATE users SET is_deleted = 1 WHERE user_id = $id";
        $result = DB::update($query);
        if (empty($result)) {
            return [
                'code' => 0
            ];
        }
        return [
            'code' => 1
        ];

    }


}
