<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;

use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, MustVerifyEmailTrait;
      use HasRoles;



    use Notifiable {
        notify as protected laravelNotify;
    }
    public function notify($instance)
    {
        // 如果要通知的人是当前用户,且不是在验证邮箱，就不必通知了！
        if ($this->id == Auth::id()&&get_class($instance)!="Illuminate\Auth\Notifications\VerifyEmail") {
            return;
        }

        // 只有数据库类型通知才需提醒，直接发送 Email 或者其他的都 Pass
        if (method_exists($instance, 'toDatabase')) {
            $this->increment('notification_count');
        }

        $this->laravelNotify($instance);
    }


     public function replies()
         {
             return $this->hasMany(Reply::class);
         }

     public function markAsRead()
        {
            $this->notification_count = 0;
            $this->save();
            $this->unreadNotifications->markAsRead();
        }


    protected $fillable = [
        'name',
        'email',
        'password',
        'introduction',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function topics()
        {
            return $this->hasMany(Topic::class);
        }

    public function isAuthorOf($model)
        {
            return $this->id == $model->user_id;
        }


     public function setPasswordAttribute($value)
        {
            // 如果值的长度等于 60，即认为是已经做过加密的情况
            if (strlen($value) != 60) {

                // 不等于 60，做密码加密处理
                $value = bcrypt($value);
            }

            $this->attributes['password'] = $value;
        }

    public function setAvatarAttribute($path)
    {
        if (!Str::startsWith($path, 'http')) {
            $path = "avatars/$path";
        }

        $this->attributes['avatar'] = $path;
    }



}
