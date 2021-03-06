<?php

namespace App;

use App\Events\PublicPush;
use App\Events\UserPush;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    public $token;

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

    public function avatar()
    {
        return $this->morphOne(File::class, 'fileable')->where('type', 'avatar');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function sendPush($data, $title = null, $description = null)
    {
        return event(new UserPush($this, $data, $title, $description));
    }

    public function makeToken()
    {
        $this->token = $this->createToken('authToken')->accessToken;
        return $this;
    }
}
