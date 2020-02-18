<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'message'
    ];

    public static $publicChannel = 'public';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function scopeGetFiveAnswers($query)
    {
        $query->with(['answers' => function ($query)
        {
            $query->orderBy('created_at', 'desc')->limit(5);
        }]);
    }

    public function getFiveAnswers()
    {
        return $this->load(['answers' => function ($query)
        {
            $query->orderBy('created_at', 'desc')->limit(5);
        }]);
    }
}
