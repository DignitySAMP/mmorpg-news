<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleComment;
use App\Models\ArticleImage;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin@example.com'),
        ]);

        $numUsers = 10;
        User::factory($numUsers)->create();
        for($i = 0; $i < $numUsers + 1; $i++) {
            $profile = UserProfile::factory()->create([
                'user_id' => $i
            ]);
        }

        for ($i = 0; $i < 32; $i++) {
            Article::factory()->create([
                'user_id' => User::inRandomOrder()->first(),
            ]);
        }

        for ($i = 0; $i < 100; $i++) {
            ArticleComment::factory()->create([
                'user_id' => User::inRandomOrder()->first(),
                'article_id' => Article::inRandomOrder()->first(),
            ]);

        }

        for ($i = 0; $i < 256; $i++) {
            ArticleImage::factory()->create([
                'article_id' => Article::inRandomOrder()->first(),
            ]);
        }
    }
}
