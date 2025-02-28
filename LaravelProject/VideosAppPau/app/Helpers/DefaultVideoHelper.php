<?php

namespace App\Helpers;

use App\Models\Video;

use Carbon\Carbon;

class DefaultVideoHelper
{
    /**
     * Retorna una llista de vídeos per defecte.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getDefaultVideos()
    {
        // Exemple de retorn d'una llista de vídeos per defecte. Això es pot personalitzar
        return Video::where('published_at', '<=', now()) // Vídeos ja publicats
        ->orderBy('published_at', 'desc') // Ordenats per data de publicació
        ->limit(5) // Límits a 5 vídeos per defecte
        ->get();
    }

    public static function createDefaultVideoHelper($title = 'Vídeo de prova', $description = 'Descripció del vídeo de prova', $url = 'https://www.youtube.com/watch?v=123456')
    {
        return Video::create([
            'title' => $title,
            'description' => $description,
            'url' => $url,
            'published_at' => Carbon::now(),
        ]);
    }
    public static function createDefaultVideo(array $overrides = []){
        $defaultData = [
            'title' => 'Detall Blue Kid',
            'description' => 'Un xiquet es torna blau i mor',
            'url' => 'https://www.youtube.com/watch?v=3HSC8z5ceG0',
            'published_at' => Carbon::now()->toDateTimeString(),
            'previous' => null,
            'next' => null,
            'series_id' => 1
        ];

        $data = array_merge($defaultData, $overrides);

        return Video::create($data);
    }
    public static function createDefaultVideo2(array $overrides = []){
        $defaultData = [
            'title' => 'Detalls del tutorial de dormir',
            'description' => 'Ensenya com dormir',
            'url' => 'https://www.youtube.com/watch?v=Hg469wSrZhI',
            'published_at' => Carbon::now()->toDateTimeString(),
            'previous' => null,
            'next' => null,
            'series_id' => 2
        ];

        $data = array_merge($defaultData, $overrides);

        return Video::create($data);
    }
    public static function createDefaultVideo3(array $overrides = []){
        $defaultData = [
            'title' => 'Detalls del tutorial de despertar',
            'description' => 'Ensenya com despertar',
            'url' => 'https://www.youtube.com/watch?v=dG3niF2GgHM',
            'published_at' => Carbon::now()->toDateTimeString(),
            'previous' => null,
            'next' => null,
            'series_id' => 3
        ];

        $data = array_merge($defaultData, $overrides);

        return Video::create($data);
    }
}
