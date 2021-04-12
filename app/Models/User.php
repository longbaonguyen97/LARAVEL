<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected  $table = 'users';
    protected  $primaryKey = 'user_id';
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'email',
        'password',
        'is_deleted'
    ];

    //return properties to class parent
    protected  function  getTableInfo () {
        $result = [
          'name'=>$this->table,
            'alias'=>$this->table.' as u',
            'primaryKey'=>$this->primaryKey,
        ];
        return (object) $result;
    }


    /**
     * get List user
     *
     * @param array $selectRawQuery
     * @param array $whereRawQuery
     * @param array $orderByRawQuery
     * @return mixed
     */
    public function getListUser ($selectRawQuery = [], $whereRawQuery = [], $orderByRawQuery = []){
        $query = DB::table($this->getTableInfo()->alias);

        foreach ($selectRawQuery as $itm){
            $query->selectRaw($itm['strRaw'],$itm['params']);
        }

        foreach ($whereRawQuery as $itm){
            $query->whereRaw($itm['strRaw'],$itm['params']);
        }

        foreach ($orderByRawQuery as $itm){
            $query->orderByRaw($itm['strRaw'],$itm['params']);
        }

        $dataDetail = $query->get();

        return $dataDetail;
    }

    /**
     * get Detail user
     *
     * @param array $selectRawQuery
     * @param array $whereRawQuery
     * @param array $orderByRawQuery
     * @return mixed
     */
    public function getDetailUser ($selectRawQuery = [], $whereRawQuery = [], $orderByRawQuery = []){
        $query = DB::table($this->getTableInfo()->alias);

        foreach ($selectRawQuery as $itm){
            $query->selectRaw($itm['strRaw'],$itm['params']);
        }

        foreach ($whereRawQuery as $itm){
            $query->whereRaw($itm['strRaw'],$itm['params']);
        }

        foreach ($orderByRawQuery as $itm){
            $query->orderByRaw($itm['strRaw'],$itm['params']);
        }

        $dataDetail = $query->first();

        return $dataDetail;
    }

    /**
     * get Detail user
     *
     * @param array $selectRawQuery
     * @param array $whereRawQuery
     * @param array $orderByRawQuery
     * @return mixed
     */
    public function getDetailUserPagination ($selectRawQuery = [], $whereRawQuery = [], $orderByRawQuery = []){
        $query = DB::table($this->getTableInfo()->alias);

        foreach ($selectRawQuery as $itm){
            $query->selectRaw($itm['strRaw'],$itm['params']);
        }

        foreach ($whereRawQuery as $itm){
            $query->whereRaw($itm['strRaw'],$itm['params']);
        }

        foreach ($orderByRawQuery as $itm){
            $query->orderByRaw($itm['strRaw'],$itm['params']);
        }

        $dataDetail = $query->first();

        return $dataDetail;
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
