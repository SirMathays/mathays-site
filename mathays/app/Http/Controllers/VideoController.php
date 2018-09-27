<?php

namespace Mathays\Http\Controllers;

use Illuminate\Http\Request;

use Mathays\Video;
use Auth;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::get();

        return response([
            'videos' => $videos
        ], 200);
    }

    public function edit(Request $request)
    {
        $video = Video::find($request->id);
        
        if(!$video) return response([
            'message' => 'Video not found'
        ], 404);

        return response([
            'video' => $video
        ], 200);
    }

    public function save(Request $request)
    {
        // dd($request->input());
        $request->validate([
            'video.id' => 'exists:videos,id',
            'video.yid' => 'required|unique:videos,yid,'.$request->input('video.id'),
            'video.title' => 'required',
            'video.description' => 'required_if:publish,true',
            'publish' => 'boolean',
        ]);

        // If exists
        if($request->input('video.id')) $video = Video::find($request->input('video.id'));

        // Create new
        else $video = new Video;
        
        $video->title = $request->input('video.title');
        $video->yid = $request->input('video.yid');
        $video->description = $request->input('video.description');

        if($request->publish) $video->publish();
        else $video->save();

        return response([
            'message' => 'Video saved!',
            'video' => $video,
        ], 200);
    }

    public function delete(Request $request)
    {
        $video = Video::find()->find($request->id);
        $video->delete();

        return response([
            'message' => 'Video deleted!',
        ], 200);
    }
}
