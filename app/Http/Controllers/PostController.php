<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page_size = 15;
        $posts = Post::latest('id')
            ->with('user')
            ->paginate($page_size)
            ->withQueryString();

        return inertia('Posts/Index', [
            'posts' => PostResource::collection($posts),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $comments_per_page = 10;
        $comments = $post->comments()
            ->with('user')
            ->latest('id')
            ->paginate($comments_per_page)
            ->withQueryString();
        $post->load('user');

        return inertia('Posts/Show', [
            'comments' => CommentResource::collection($comments),
            'post' => PostResource::make($post),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
