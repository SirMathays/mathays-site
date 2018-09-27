<?php

namespace Mathays\Http\Controllers;

use Illuminate\Http\Request;

use Mathays\BlogPost;
use Mathays\Video;
use Mathays\Person;

use Carbon\Carbon;
use Cookie;

class PublicController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');
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

        return response([
            'blogpost' => $blogpost,
            'video' => $video,
            'people' => $people,
            'name' => setting('name'),
            'story' => setting('story'),
        ], 200);
    }

    public function blog()
    {
        $blogposts = BlogPost::isBlogPost()->published()->newestFirst()->get();

        return response([
            'newest' => $blogposts->shift(),
            'blogposts' => $blogposts,
        ], 200);
    }

    public function post(Request $request)
    {
        $post = BlogPost::urlParameters($request->year, $request->month, $request->slug)
            ->published()
            ->isBlogPost()
            ->first();
        
        if(!$post) return response([
            'message' => 'Post not found'
        ], 404);

        return response([
            'post' => $post
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

        if(!$video) return response([
            'message' => 'Video not found'
        ], 404);

        return response([
            'video' => $video
        ], 200);
    }
}
