<?php

namespace Mathays\Personal;

use Illuminate\Database\Eloquent\Model;

use DOMDocument;

class Feed extends Model
{
    protected $table = 'personal_feeds';

    public $timestamps = false;

    protected $casts = [
        'rows' => 'array',
    ];

    public function getRssFeedAttribute() 
    {
        $i = 0;
        $rss = new DOMDocument();
        $rss->load($this->url);
        
        foreach($rss->getElementsByTagName('item') as $item) {
            if($i >= $this->limit) break;

            foreach($this->rows as $section) {
                if($item->getElementsByTagName($section)->item(0))
                    $results[$i][$section] = $item->getElementsByTagName($section)->item(0)->nodeValue;
            }

            $i++;
        }

        return $results;
    }

    public function scopeOrder($query, $dir = 'ASC')
    {
        return $query->orderBy('order', $dir);
    }
}
