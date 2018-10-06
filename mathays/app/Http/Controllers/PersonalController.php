<?php

namespace Mathays\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Inspiring;

use Mathays\Personal\Mode;
use Mathays\Personal\QuickLink;

use Auth;
use BingPhoto;

use DOMDocument;

class PersonalController extends Controller
{
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
        return response([
            'modes' => Mode::get()->keyBy('slug')->toArray(),
        ], 200);
    }

    public function getBaseData(Request $request)
    {
        if(!$request->input('slug')) {
            $mode = Mode::where('default', true)->first();
        } else {
            $mode = Mode::where('slug', $request->slug)->first();
        }

        return response([
            'mode' => $mode->slug,
            'links' => $mode->quickLinks,
        ], 200);
    }

    public function getFeeds(Request $request)
    {
        if(!$request->input('slug')) {
            $mode = Mode::where('default', true)->first();
        } else {
            $mode = Mode::where('slug', $request->slug)->first();
        }

        return response([
            'feeds' => $mode->fullFeeds(),
        ], 200);
    }
}
