<?php

namespace Mathays;

use Illuminate\Database\Eloquent\Model;
use Auth;

class BlogPost extends Model
{
    protected $dates = [
        'published_at'
    ];

    protected $appends = [
        'published_at_tz',
        'pub_year',
        'pub_month',        
    ];

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

    public function getPubYearAttribute()
    {
        return $this->published_at ? $this->published_at->year : NULL;
    }

    public function getPubMonthAttribute()
    {
        return $this->published_at ? $this->published_at->month : NULL;
    }

    public function scopeSlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }

    public function scopeUrlParameters($query, $year, $month, $slug)
    {
        return $query->whereYear('published_at', $year)->whereMonth('published_at', $month)->slug($slug);
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function scopeNewestFirst($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    public function scopeIsBlogPost($query)
    {
        return $query->whereNull('video_id');
    }

    public function scopeIsVideoStory($query)
    {
        return $query->whereNotNull('video_id');
    }

    public function publish()
    {
        $this->published_at = now();
        $this->save();
    }
}
