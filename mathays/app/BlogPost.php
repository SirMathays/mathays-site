<?php

namespace Mathays;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $dates = [
        'published_at'
    ];

    protected $appends = [
        'pub_year',
        'pub_month',        
    ];

    public function getPubYearAttribute()
    {
        return $this->published_at->year;
    }

    public function getPubMonthAttribute()
    {
        return $this->published_at->month;
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
}
