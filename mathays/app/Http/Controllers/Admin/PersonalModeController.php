<?php

namespace Mathays\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Mathays\Http\Controllers\Controller;

use Mathays\Personal\Mode;

class PersonalModeController extends Controller
{
    public function getModes()
    {
        return response([
            'modes' => Mode::get()->keyBy('slug')->toArray(),
        ], 200);
    }

    public function getModeContent(Request $request)
    {
        $mode = Mode::where('slug', $request->slug)->first();

        return response([
            'links' => $mode->quickLinks,
            'feeds' => $mode->feeds
        ], 200);
    }
}
