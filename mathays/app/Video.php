<?php

namespace Mathays;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    public function blogPost() {
        return $this->hasOne('Mathays\BlogPost');
    }
}
