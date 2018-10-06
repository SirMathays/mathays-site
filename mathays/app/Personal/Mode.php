<?php

namespace Mathays\Personal;

use Illuminate\Database\Eloquent\Model;

use DOMDocument;

class Mode extends Model
{
    protected $table = 'personal_modes';

    public $timestamps = false;

    protected $casts = [
        'default' => 'boolean',
    ];

    public function quickLinks()
    {
        return $this->hasMany('Mathays\Personal\QuickLink')->order();
    }

    public function feeds()
    {
        return $this->hasMany('Mathays\Personal\Feed')->order();
    }

    public function fullFeeds()
    {
        $feeds = $this->feeds;

        foreach ($feeds as $feed) $feed->setAppends(['rss_feed']);

        return $feeds;
    }
}
