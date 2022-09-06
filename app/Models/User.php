<?php

namespace App\Models;

use App\Traits\ModelTimeFormatTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class User.
 *
 * @package namespace App\Models;
 */
class User extends Authenticatable implements Transformable,JWTSubject
{
    use TransformableTrait, HasApiTokens, HasFactory, Notifiable,ModelTimeFormatTrait;

    protected $jWTCustomClaims = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    /**
     * @return mixed
     * @author zzp
     * @date 2022/9/5
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array
     * @author zzp
     * @date 2022/9/5
     */
    public function getJWTCustomClaims()
    {
        return $this->jWTCustomClaims??[];
    }

    /**
     * @param array $jWTCustomClaims
     * @return $this
     * @author zzp
     * @date 2022/9/5
     */
    public function setJWTCustomClaims(array $jWTCustomClaims){
        $this->jWTCustomClaims = array_merge($this->jWTCustomClaims??[],$jWTCustomClaims);
        return $this;
    }
}
