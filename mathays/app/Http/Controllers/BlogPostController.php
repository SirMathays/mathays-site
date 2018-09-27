<?php

namespace Mathays\Http\Controllers;

use Illuminate\Http\Request;

use Mathays\BlogPost;
use Auth;

class BlogPostController extends Controller
{
    public function index()
    {
        $blogPosts = BlogPost::isBlogPost()->newestFirst()->get();

        return response([
            'posts' => $blogPosts
        ], 200);
    }

    public function edit(Request $request)
    {
        $post = BlogPost::isBlogPost()->find($request->id);
        
        if(!$post) return response([
            'message' => 'Post not found'
        ], 404);

        return response([
            'post' => $post
        ], 200);
    }

    public function save(Request $request)
    {
        // dd($request->input());
        $request->validate([
            'post.id' => 'exists:blog_posts,id',
            'post.title' => 'required',
            'post.body' => 'required_if:publish,true',
            'publish' => 'boolean',
        ]);

        // If exists
        if($request->input('post.id')) $post = BlogPost::isBlogPost()->find($request->input('post.id'));

        // Create new
        else $post = new BlogPost;
        
        $post->title = $request->input('post.title');
        $post->slug = str_slug($request->input('post.title'));
        $post->body = $request->input('post.body');

        if($request->publish) $post->publish();
        else $post->save();

        return response([
            'message' => 'Post saved!',
            'post' => $post,
        ], 200);
    }

    public function delete(Request $request)
    {
        $post = BlogPost::find()->find($request->id);
        $post->delete();

        return response([
            'message' => 'Post deleted!',
        ], 200);
    }
}
