<?php

namespace Mathays;

use Illuminate\Database\Eloquent\Model;

use Auth;

class Video extends Model
{
    protected $dates = [
        'published_at'
    ];

    protected $appends = [
        'url',
        'published_at_tz'
    ];
    
    public function blogPost() {
        return $this->hasOne('Mathays\BlogPost');
    }

    public function getUrlAttribute()
    {
        return 'https://www.youtube.com/watch?v='.$this->yid;
    }

    public function getPublishedAtTzAttribute()
    {
        if(!$this->published_at) 
            return null;

        $tz = null;

        if(Auth::check()) 
            $tz = Auth::user()->timezone;
        else if(isset($_COOKIE['mathays_tz'])) 
            $tz = $_COOKIE['mathays_tz'];

        return $this->published_at->tz($tz)->toDateTimeString();
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
