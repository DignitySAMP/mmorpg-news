<?php

namespace App\Console\Commands;

use App\Models\Game;
use Illuminate\Console\Command;
use App\Models\MMORPG;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ImportMMORPGs extends Command
{
    protected $signature = 'import:mmorpgs';
    protected $description = 'Import MMORPGs from MMO Bomb API';

    public function handle()
    {
        $this->info('Fetching MMORPG list...');
        $response = Http::get('https://www.mmobomb.com/api1/games?category=mmorpg');

        if ($response->failed()) {
            $this->error('Failed to fetch MMORPG list.');
            return 1;
        }

        $games = $response->json();

        foreach ($games as $game) {
            $this->info("Fetching details for: {$game['title']}");

            $detailResponse = Http::get('https://www.mmobomb.com/api1/game', [
                'id' => $game['id']
            ]);

            if ($detailResponse->failed()) {
                $this->warn("Failed to fetch details for {$game['title']}");
                continue;
            }

            $details = $detailResponse->json();

            // download thumbnail
            $thumbnailPath = null;
            if (!empty($details['thumbnail'])) {
                $thumbnailPath = $this->downloadImage($details['thumbnail'], 'thumbnails', $game['title']);
            }

            // download  screenshots
            $screenshots = [];
            if (!empty($details['screenshots'])) {
                foreach ($details['screenshots'] as $screenshot) {
                    $screenshots[] = $this->downloadImage($screenshot['image'], 'screenshots', $game['title']);
                }
            }

            Game::updateOrCreate(
                ['title' => $details['title']],
                [
                    'thumbnail' => $thumbnailPath,
                    'short_description' => $details['short_description'] ?? null,
                    'description' => $details['description'] ?? null,
                    'genre' => $details['genre'] ?? null,
                    'platform' => $details['platform'] ?? null,
                    'publisher' => $details['publisher'] ?? null,
                    'developer' => $details['developer'] ?? null,
                    'release_date' => $details['release_date'] ?? null,
                    'minimum_system_requirements' => $details['minimum_system_requirements'] ?? null,
                    'screenshots' => $screenshots,
                ]
            );
        }

        $this->info('MMORPG import complete!');
        return 0;
    }

    protected function downloadImage(string $url, string $folder, string $title): ?string
    {
        try {
            $contents = Http::get($url)->body();
            $filename = $folder . '/' . $title . '/' . basename($url);
            Storage::disk('public')->put($filename, $contents);
            return Storage::url($filename);
        } catch (\Exception $e) {
            $this->warn("Failed to download image: {$url}");
            return null;
        }
    }
}
