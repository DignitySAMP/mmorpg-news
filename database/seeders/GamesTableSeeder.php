<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class GamesTableSeeder extends Seeder
{
    public function run()
    {
        $jsonPath = database_path('json/games.json');

        if (!File::exists($jsonPath)) {
            $this->command->error("JSON file not found: $jsonPath");
            return;
        }

        $data = json_decode(File::get($jsonPath), true);

        if (!$data) {
            $this->command->error("Failed to decode JSON.");
            return;
        }

        foreach ($data as $game) {
            DB::table('games')->updateOrInsert(
                [ 'id' => $game['id'] ],
                [
                    'title'                       => $game['title'],
                    'thumbnail'                   => $game['thumbnail'],
                    'short_description'           => $game['short_description'],
                    'description'                 => $game['description'],
                    'genre'                       => $game['genre'],
                    'platform'                    => $game['platform'],
                    'publisher'                   => $game['publisher'],
                    'developer'                   => $game['developer'],
                    'release_date'                => $game['release_date'],
                    'minimum_system_requirements' => is_array($game['minimum_system_requirements'])
                        ? json_encode($game['minimum_system_requirements'])
                        : null,
                    'screenshots'                 => json_encode($game['screenshots']),
                    'created_at'                  => $game['created_at'] ?? now(),
                    'updated_at'                  => $game['updated_at'] ?? now(),
                ]
            );
        }

        $this->command->info("Loaded default games!");
    }
}
