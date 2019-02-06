<?php

namespace Mathays\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Inspiring;

use Mathays\Personal\Mode;
use Mathays\Personal\QuickLink;

use Auth;
use BingPhoto;

use DOMDocument;
use Mathays\Personal\Feed;

class PersonalController extends Controller
{
    public function __construct() {
        // 
    }
    
    public function index()
    {
        $bing = new BingPhoto([
            'quality' => BingPhoto::QUALITY_HIGH,
        ]);

        return view('personal-index', [
            'user' => Auth::user(),
            'bing' => $bing->getImage(),
            'quote' => Inspiring::quote(),
        ]);
    }

    public function getModes(Request $request)
    {
        $user = Auth::user();

        return response([
            'modes' => $user->modes->keyBy('slug')->toArray(),
        ], 200);
    }

    public function getBaseData(Request $request)
    {
        $user = Auth::user();
        
        if(!$request->input('slug')) {
            $mode = $user->modes()->where('default', true)->first();
        } else {
            $mode = $user->modes()->where('slug', $request->slug)->first();
        }

        return response([
            'mode' => $mode->slug,
            'links' => $mode->quickLinks,
        ], 200);
    }

    public function getFeeds(Request $request)
    {
        $user = Auth::user();
        
        if(!$request->input('slug')) {
            $mode = $user->modes()->where('default', true)->first();
        } else {
            $mode = $user->modes()->where('slug', $request->slug)->first();
        }

        return response([
            'feeds' => $mode->fullFeeds(),
        ], 200);
    }
}
