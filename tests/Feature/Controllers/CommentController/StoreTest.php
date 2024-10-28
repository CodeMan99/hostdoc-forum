<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

it('can store a comment', function () {
    $user = User::factory()->createOne();
    $post = Post::factory()->createOne();

    actingAs($user)->post(route('posts.comments.store', $post), [
        'body' => 'This is a comment',
    ]);

    assertDatabaseHas(Comment::class, [
        'post_id' => $post->id,
        'user_id' => $user->id,
        'body' => 'This is a comment',
    ]);
});

it('redirects to the post show page', function () {
    $user = User::factory()->createOne();
    $post = Post::factory()->createOne();

    $response = actingAs($user)->post(route('posts.comments.store', $post), [
        'body' => 'This is a comment',
    ]);

    $response->assertRedirectToRoute('posts.show', $post);
});

it('requires a valid body', function ($value) {
    $user = User::factory()->createOne();
    $post = Post::factory()->createOne();

    $response = actingAs($user)->post(route('posts.comments.store', $post), [
        'body' => $value,
    ]);

    $response->assertInvalid('body');
})->with([
    null,
    1,
    1.5,
    true,
    false,
    str_repeat('a', 2501),
]);
