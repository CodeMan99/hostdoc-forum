<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(10)->create();
        $posts = Post::factory(200)
            ->has(Comment::factory(13)->recycle($users))
            ->recycle($users)
            ->create();

        $dev_bro = User::factory()
            ->has(Post::factory(25))
            ->has(Comment::factory(50)->recycle($posts))
            ->create([
                'name' => 'Dev Bro',
                'email' => 'dev.bro@hostdoc.forum',
            ]);
    }
}
