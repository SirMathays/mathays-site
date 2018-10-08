<?php

namespace Mathays\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Mathays\Http\Controllers\Controller;

use Mathays\Personal\Mode;
use Auth;

class PersonalModeController extends Controller
{
    public function getModes()
    {
        $modes = Auth::user()->modes->keyBy('slug')->toArray();
        
        if(!count($modes)) return response([
            'message' => 'No modes found'
        ], 404);

        return response([
            'modes' => $modes,
        ], 200);
    }

    public function getModeContent(Request $request)
    {
        $mode = Auth::user()->modes()->where('slug', $request->slug)->first();

        if(!$mode) return response([
            'message' => 'No modes found'
        ], 404);

        return response([
            'links' => $mode->quickLinks,
            'feeds' => $mode->feeds
        ], 200);
    }
}
