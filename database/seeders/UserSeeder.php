<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hashedPassword = Hash::make('bulletin2026');

        // Create Lola Hisuan
        $lola = User::create([
            'name'     => 'Lola Hisuan',
            'email'    => 'lola.hisuan@bulletin.test',
            'password' => $hashedPassword,
        ]);

        // Create Kagawad user
        $kagawadUser = User::create([
            'name'     => 'Kagawad Hisuan',
            'email'    => 'kagawad.hisuan@bulletin.test',
            'password' => $hashedPassword,
        ]);

        // Link existing Kagawad author profile to Kagawad user
        $kagawadAuthor = Author::where('email', 'like', 'kagawad.%')->first();
        if ($kagawadAuthor) {
            $kagawadAuthor->update([
                'user_id' => $kagawadUser->id,
            ]);
        }

        // 8 more resident users with the user factory
        User::factory()->count(8)->create([
            'password' => $hashedPassword,
        ]);
    }
}
