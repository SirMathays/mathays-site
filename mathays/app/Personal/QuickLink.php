<?php

namespace Mathays\Personal;

use Illuminate\Database\Eloquent\Model;

class QuickLink extends Model
{
    protected $table = 'personal_quick_links';

    public $timestamps = false;

    protected $appends = [
        'favicon_url'
    ];

    public function getFaviconUrlAttribute()
    {
        return "https://s2.googleusercontent.com/s2/favicons?domain_url=".$this->url;
    }

    public function scopeOrder($query)
    {
        return $query->orderBy('order');
    }
}
