<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertModelMissing;
use function Pest\Laravel\delete;

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

it('prevents deleting a comment you did not create', function() {
    $comment = Comment::factory()->createOne();
    $user = User::factory()->createOne();

    $response = actingAs($user)->delete(route('comments.destroy', $comment));
    $response->assertForbidden();
});
