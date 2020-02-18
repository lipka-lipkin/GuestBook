<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    public static $types = ['avatar'];

    public $table = 'fileable';

    protected $fillable = [
        'type',
        'path'
    ];

    public function user()
    {
        return $this->morphTo();
    }
}
