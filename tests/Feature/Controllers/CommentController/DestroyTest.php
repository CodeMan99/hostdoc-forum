<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertModelMissing;
use function Pest\Laravel\delete;
use function Pest\Laravel\freezeTime;
use function Pest\Laravel\travel;

it('requires an authenticated user', function () {
    $comment = Comment::factory()->createOne();

    $response = delete(route('comments.destroy', $comment));
    $response->assertRedirectToRoute('login');
});

it('can delete a comment', function() {
    $comment = Comment::factory()->createOne();

    actingAs($comment->user)->delete(route('comments.destroy', $comment));
    assertModelMissing($comment);
});

it('redirects to the post show page', function() {
    $comment = Comment::factory()->createOne();

    $response = actingAs($comment->user)->delete(route('comments.destroy', $comment));
    $response->assertRedirectToRoute('posts.show', $comment->post_id);
});

it('redirects to the post show page with the page query parameter', function() {
    $comment = Comment::factory()->createOne();

    $response = actingAs($comment->user)->delete(route('comments.destroy', [
        'comment' => $comment,
        'page' => 2,
    ]));
    $response->assertRedirectToRoute('posts.show', [
        'post' => $comment->post_id,
        'page' => 2,
    ]);
});

it('prevents deleting a comment you did not create', function() {
    $comment = Comment::factory()->createOne();
    $user = User::factory()->createOne();

    $response = actingAs($user)->delete(route('comments.destroy', $comment));
    $response->assertForbidden();
});

it('prevents deleting a comment posted more than one hour ago', function() {
    freezeTime();

    $comment = Comment::factory()->createOne();

    travel(1)->hour();

    $response = actingAs($comment->user)->delete(route('comments.destroy', $comment));
    $response->assertForbidden();
});
