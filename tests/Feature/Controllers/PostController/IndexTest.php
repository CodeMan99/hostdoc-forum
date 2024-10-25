<?php

use App\Http\Resources\PostResource;
use App\Models\Post;
use Inertia\Testing\AssertableInertia;
use function Pest\Laravel\get;

it('should return the correct component', function() {
    Post::factory()->create();

    get(route('posts.index'))
        ->assertInertia(
            fn (AssertableInertia $inertia) => $inertia->component('Posts/Index', true)
        );
});

it('passes posts to the view', function() {
    $posts = Post::factory(3)->create();

    get(route('posts.index'))
        ->assertPaginatedResource('posts', PostResource::collection($posts->reverse()));
});
