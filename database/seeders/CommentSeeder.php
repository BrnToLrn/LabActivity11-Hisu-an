<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $lola = User::where('name', 'like', 'Lola%')->first() ?? $users->first();
        $publishedPosts = Post::where('is_published', true)->get();
        $pinnedPost = Post::where('is_pinned', true)->first();

        // Give every published post 0-5 comments by random users
        foreach ($publishedPosts as $post) {
            $commentCount = rand(0, 5);
            for ($i = 0; $i < $commentCount; $i++) {
                Comment::create([
                    'post_id' => $post->id,
                    'user_id' => $users->random()->id,
                    'body'    => fake()->sentence(),
                ]);
            }
        }

        // Add 3+ comments on your pinned post (one by Lola)
        if ($pinnedPost) {
            // One by Lola
            Comment::create([
                'post_id' => $pinnedPost->id,
                'user_id' => $lola->id,
                'body'    => fake()->sentence(),
            ]);

            // Add 2 more comments by random users so it has at least 3
            for ($i = 0; $i < 2; $i++) {
                Comment::create([
                    'post_id' => $pinnedPost->id,
                    'user_id' => $users->random()->id,
                    'body'    => fake()->sentence(),
                ]);
            }
        }
    }
}
