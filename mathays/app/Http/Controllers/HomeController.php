<?php

namespace Mathays\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Inspiring;

use Mathays\BlogPost;
use Mathays\Video;
use Auth;
use Artisan;

use BingPhoto;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin-index');
    }

    public function dashboard()
    {
        $blogpost = BlogPost::select('id', 'published_at')->published()->orderBy('created_at', 'desc')->first();
        $video = Video::select('id', 'published_at')->orderBy('published_at', 'desc')->first();

        return response([
            'blogpost' => $blogpost,
            'video' => $video,
        ], 200);
    }

    public function getUser()
    {
        $bing = new BingPhoto([
            'date' => BingPhoto::YESTERDAY,
            'quality' => BingPhoto::QUALITY_LOW,
        ]);

        return response([
            'user' => Auth::user(),
            'siteName' => setting('name'),
            'bing' => $bing->getImage(),
            'quote' => Inspiring::quote(),
        ], 200);
    }
}
