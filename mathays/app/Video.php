<?php

namespace Mathays;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $dates = [
        'published_at'
    ];

    protected $appends = [
        'url',
    ];
    
    public function blogPost() {
        return $this->hasOne('Mathays\BlogPost');
    }

    public function getUrlAttribute()
    {
        return 'https://www.youtube.com/watch?v='.$this->yid;
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function publish()
    {
        $this->published_at = now();
        $this->save();
    }
}
