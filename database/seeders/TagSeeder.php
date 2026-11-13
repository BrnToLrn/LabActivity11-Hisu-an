<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tagNames = [
            'Purok Hisuan',
            'Urgent',
            'Advisory',
            'Event',
            'General',
        ];

        $tags = collect($tagNames)->map(function ($name) {
            return Tag::firstOrCreate(['name' => $name]);
        });

        $purokTag = $tags->firstWhere('name', 'Purok Hisuan');
        $urgentTag = $tags->firstWhere('name', 'Urgent');

        // Attach 1-3 random tags to each post through the relationship
        $posts = Post::all();
        foreach ($posts as $post) {
            if ($post->is_pinned) {
                // For your pinned post, use sync() so it always has exactly Purok [Lastname] and Urgent
                $post->tags()->sync([$purokTag->id, $urgentTag->id]);
            } else {
                $randomTagIds = $tags->random(rand(1, 3))->pluck('id')->toArray();
                $post->tags()->sync($randomTagIds);
            }
        }
    }
}
