<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function drills()
    {
        return $this->hasMany('App\Drill');
    }
    public function problems()
    {
        return $this->hasManyThrough(
            'App\Problem',
            'App\Drill',
            'user_id', // drillsテーブルの外部キー
            'drill_id', // problemsテーブルの外部キー
            'id', // usresテーブルのローカルキー
            'id' // drillsテーブルのローカルキー
        );
    }
}
//class User extends Model
//{
//    /**
//    * 会社の全従業員を取得
//    */
//    
//}
