<?php

use App\Models\Comment;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\put;

it('requires authentication', function () {
    $comment = Comment::factory()->createOne();

    $response = put(route('comments.update', $comment));
    $response->assertRedirectToRoute('login');
});

it('can update a comment', function () {
    $comment = Comment::factory()->createOne([
        'body' => 'Original comment',
    ]);
    $body = 'Updated comment';

    actingAs($comment->user)->put(route('comments.update', $comment), [
        'body' => $body,
    ]);

    assertDatabaseHas(Comment::class, [
        'id' => $comment->id,
        'body' => $body,
    ]);
});

it('redirects to the post show page', function () {
    $comment = Comment::factory()->createOne([
        'body' => 'Original comment',
    ]);
    $body = 'Updated comment';

    $response = actingAs($comment->user)->put(route('comments.update', $comment), [
        'body' => $body,
    ]);
    $response->assertRedirectToRoute('posts.show', $comment->post_id);
});

it('redirects to the correct page of comments', function () {
    $comment = Comment::factory()->createOne([
        'body' => 'Original comment',
    ]);
    $body = 'Updated comment';

    $response = actingAs($comment->user)->put(route('comments.update', [
        'comment' => $comment->id,
        'page' => 3,
    ]), [
        'body' => $body,
    ]);
    $response->assertRedirectToRoute('posts.show', [
        'post' => $comment->post_id,
        'page' => 3,
    ]);
});

it('cannot update a comment from another user', function () {
    $user_a = User::factory()->createOne(['id' => 1]);
    $user_b = User::factory()->createOne(['id' => 2]);
    $comment_by_a = Comment::factory()->for($user_a)->createOne();

    $response = actingAs($user_b)->put(route('comments.update', $comment_by_a));
    $response->assertForbidden();
});

it('requires a valid body', function($body) {
    $comment = Comment::factory()->createOne();

    $response = actingAs($comment->user)->put(route('comments.update', $comment), [
        'body' => $body,
    ]);
    $response->assertInvalid('body');
})->with([
    null,
    true,
    0,
    1.5,
    '',
    str_repeat('a', 2501),
]);
