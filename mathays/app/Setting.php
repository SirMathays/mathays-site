<?php

namespace Mathays;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public $timestamps = false;

    public function scopeKey($query, $key) 
    {
        $query->where('key', $key);
    }
}
