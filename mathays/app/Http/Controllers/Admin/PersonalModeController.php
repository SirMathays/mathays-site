<?php

namespace Mathays\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Mathays\Http\Controllers\Controller;

use Mathays\Personal\Mode;
use Mathays\Personal\Feed;
use Auth;

use DB;
use Mathays\Personal\QuickLink;

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

    public function saveFeedData(Request $request)
    {
        $request->validate([
            'slug' => 'required|exists:personal_modes,slug',
            'data.id' => 'nullable|exists:personal_feeds,id',
            'data.title' => 'required',
            'data.url' => 'required|url',
            'data.theme_color' => 'required',
            'data.limit' => 'required|min:1|numeric',
        ]);

        $mode = Mode::where('slug', $request->slug)->first();

        if ($request->input('data.id')) {
            $feed = Feed::where('mode_id', $mode->id)->findOrFail($request->input('data.id'));
        } else {
            $feed = new Feed;
            $feed->mode_id = $mode->id;
            $feed->rows = ["title", "link", "pubDate", "category"];
            $feed->order = 999;
        }

        $feed->title = $request->input('data.title');
        $feed->url = $request->input('data.url');
        $feed->theme_color = $request->input('data.theme_color');
        $feed->limit = $request->input('data.limit');

        $feed->save();

        return response([
            'message' => 'great success!'
        ], 200);
    }

    public function saveLinkData(Request $request)
    {
        $request->validate([
            'slug' => 'required|exists:personal_modes,slug',
            'data.id' => 'nullable|exists:personal_feeds,id',
            'data.name' => 'required',
            'data.url' => 'required|url',
            'data.color' => 'required|in:dark,light,info,success,danger',
        ]);

        $mode = Mode::where('slug', $request->slug)->first();

        if ($request->input('data.id')) {
            $link = QuickLink::where('mode_id', $mode->id)->findOrFail($request->input('data.id'));
        } else {
            $link = new QuickLink;
            $link->mode_id = $mode->id;
            $link->order = 999;
        }

        $link->name = $request->input('data.name');
        $link->url = $request->input('data.url');
        $link->color = $request->input('data.color');

        $link->save();

        return response([
            'message' => 'great success!'
        ], 200);
    }

    public function handleOrder(Request $request)
    {
        $request->validate([
            'slug' => 'required|exists:personal_modes,slug',
            'feeds' => 'required_without:links|array',
            'feeds.*.id' => 'required|exists:personal_feeds,id',
            'feeds.*.order' => 'required|integer',
            'links' => 'required_without:feeds|array',
            'links.*.id' => 'required|exists:personal_quick_links,id',
            'links.*.order' => 'required|integer',
        ]);

        $mode = Mode::where('slug', $request->slug)->first();
        $feeds = $request->feeds;
        $links = $request->links;

        if ($feeds) {
            DB::transaction(function () use ($feeds, $mode) {
                collect($feeds)->each(function ($item) use ($mode) {
                    $feed = Feed::where('mode_id', $mode->id)->findOrFail($item['id']);

                    $feed->order = $item['order'];
                    $feed->save();
                });
            });
        }

        if ($links) {
            DB::transaction(function () use ($links, $mode) {
                collect($links)->each(function ($item) use ($mode) {
                    $link = QuickLink::where('mode_id', $mode->id)->findOrFail($item['id']);

                    $link->order = $item['order'];
                    $link->save();
                });
            });
        }

        return response([
            'message' => 'most successful!'
        ], 200);
    }
}
