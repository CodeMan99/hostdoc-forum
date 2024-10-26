<?php

use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Post;
use function Pest\Laravel\get;

it('should return the correct component', function() {
    $post = Post::factory()->create();

    get(route('posts.show', $post))
        ->assertComponentExists('Posts/Show');
});

it('passes posts to the view', function() {
    $post = Post::factory()->create();
    $post->load('user');

    get(route('posts.show', $post))
        ->assertResource('post', PostResource::make($post));
});

it('passes comments to the view', function() {
    $post = Post::factory()->create();
    $comments = Comment::factory(3)->for($post)->create();
    $comments->load('user');

    get(route('posts.show', $post))
        ->assertPaginatedResource('comments', CommentResource::collection($comments->reverse()));
});
