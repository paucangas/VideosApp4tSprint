<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Tests\Unit\VideosTest;

class VideosController extends Controller
{
    public function show($id)
    {
        // Buscar el vídeo per ID
        $video = Video::find($id);

        if (!$video) {
            return response()->json(['message' => 'Video not found'], 404);
        }

        // Retornar una vista amb les dades del vídeo
        return view('videos.show', compact('video'));
    }
    public function manage()
    {
        if (auth()->user()->can('manage-videos')) {
            return \Illuminate\Support\Facades\View::Make('videos.manage');
        }
        abort(403, 'Unauthorized');
    }

    /**
     * Retorna la clase de test dels vídeos.
     *
     * @return string
     */
    public function testedBy()
    {
        return VideosTest::class;
    }

    public function index(): View
    {
        // Obtenir tots els vídeos
        $videos = Video::all();

        // Retornar una vista amb tots els vídeos
        return view('videos.index', compact('videos'));
    }
}
