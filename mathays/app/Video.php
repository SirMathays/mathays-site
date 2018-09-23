<?php

namespace Mathays;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $dates = [
        'published_at'
    ];
    
    public function blogPost() {
        return $this->hasOne('Mathays\BlogPost');
    }
}
