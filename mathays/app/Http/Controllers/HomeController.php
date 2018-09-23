<?php

namespace Mathays\Http\Controllers;

use Illuminate\Http\Request;

use Mathays\BlogPost;
use Mathays\Video;
use Mathays\Person;

use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.index');
    }

    public function home()
    {
        $blogpost = BlogPost::orderBy('created_at', 'desc')->first();
        $video = Video::orderBy('published_at', 'desc')->first();

        $people = Person::orderBy('name', 'desc')->get()->map(function ($item, $key) {
            return [
                'name' => $item->name,
                'email' => $item->email,
                'avatar' => $item->avatar,
            ];
        });
        
        $story = "Mathays Productions is a one-man-production which creates mainly videos and but also other media - games, short stories, websites and so on.";

        return response([
            'blogpost' => $blogpost,
            'video' => $video,
            'people' => $people,
            'story' => $story,
        ], 200);
    }

    public function blog()
    {
        $blogposts = BlogPost::orderBy('created_at', 'desc')->get();

        return response([
            'newest' => $blogposts->shift(),
            'blogposts' => $blogposts->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('Y-m');
            })
        ], 200);
    }

    public function videos()
    {
        $videos = Video::orderBy('published_at', 'desc')->get();

        return response([
            'newest' => $videos->shift(),
            'videos' => $videos
        ], 200);
    }

    public function video(Request $request)
    {
        $video = Video::where('yid', $request->input('yid'))->with('blogPost')->first();

        return response([
            'video' => $video
        ], 200);
    }

    public function post(Request $request)
    {
        $post = BlogPost::where('slug', $request->input('slug'))->first();

        return response([
            'post' => $post
        ], 200);
    }
}