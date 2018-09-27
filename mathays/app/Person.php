<?php

namespace Mathays;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Person extends Authenticatable
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
     * The attributes that should be appended to arrays.
     *
     * @var array
     */
    protected $appends = [
        'avatar',
        'first_name',
        'last_name',
    ];

    public function getAvatarAttribute()
    {
        return md5($this->email);
    }

    public function getFirstNameAttribute()
    {
        return explode(' ', $this->name)[0];
    }

    public function getLastNameAttribute()
    {
        $lastName = array_values(array_slice(explode(' ', $this->name), -1))[0];
        return $lastName != $this->first_name ? $lastName : NULL;
    }
}
