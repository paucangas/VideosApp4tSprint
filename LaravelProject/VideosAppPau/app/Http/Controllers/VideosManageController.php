<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Tests\Feature\Videos\VideosManageControllerTest;

class VideosManageController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        if (!auth()->user()->can('manage-videos')) {
            abort(403, 'No tens permisos per gestionar vídeos');
        }


        $videos = Video::all();
        return view('videos.manage.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        if (!auth()->user()->can('manage-videos')) {
            abort(403, 'No tens permisos per gestionar vídeos');
        }

        return view('videos.manage.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        if (!auth()->user()->can('manage-videos')) {
            abort(403, 'No tens permisos per gestionar vídeos');
        }

        $validated = $request->validate([
           'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'required|string|url',
            'published_at' => 'required|date',
            'previous' => 'nullable|string',
            'next' => 'nullable|string',
            'series_id' => 'nullable|integer|exists:series,id',
        ]);

        $video = Video::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'url' => $validated['url'],
            'published_at' => $validated['published_at'],
            'previous' => $validated['previous'],
            'next' => $validated['next'],
            'series_id' => $validated['series_id'],
        ]);

        return redirect()->route('videos.manage.index')->with('success', 'Vídeo creat correctament');
    }

    /**
     * Display the specified resource.
     */

    public function show(string $id)
    {
        if (!auth()->user()->can('manage-videos')) {
            abort(403, 'No tens permisos per gestionar vídeos');
        }

        $video = Video::find($id);

        if (!$video){
            return response()->json(['error' => 'Vídeo no trobat'], 404);
        }
        return View::Make('videos.manage.show', compact('video'));
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(string $id)
    {
        if (!auth()->user()->can('manage-videos')) {
            abort(403, 'No tens permisos per gestionar vídeos');
        }

        $video = Video::find($id);

        if (!$video){
            return response()->json(['error' => 'Vídeo no trobat'], 404);
        }

        return view('videos.manage.edit', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        if (!auth()->user()->can('manage-videos')) {
            abort(403, 'No tens permisos per gestionar vídeos');
        }

        $video = Video::find($id);

        if (!$video){
            return response()->json(['error' => 'Vídeo no trobat'], 404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'required|string|url',
            'published_at' => 'required|date',
            'previous' => 'nullable|string',
            'next' => 'nullable|string',
            'series_id' => 'nullable|integer|exists:series,id',
        ]);

        $video->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'url' => $validated['url'],
            'published_at' => $validated['published_at'],
            'previous' => $validated['previous'],
            'next' => $validated['next'],
            'series_id' => $validated['series_id'],
        ]);

        return redirect()->route('videos.manage.index')->with('success', 'Vídeo actualitzat correctament');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
    {
        if (!auth()->user()->can('manage-videos')) {
            abort(403, 'No tens permisos per gestionar vídeos');
        }

        $video = Video::find($id);

        if (!$video){
            return response()->json(['error' => 'Vídeo no trobat'], 404);
        }

        $video->delete();

        return redirect()->route('videos.manage.index')->with('success', 'Vídeo eliminat correctament');
    }

    public function testedBY(){
        return VideosManageControllerTest::class;
    }
}
