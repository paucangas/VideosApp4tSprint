<x-videos-app-layout>

<h1>{{ $video->title }}</h1>
    <p>{{ $video->description }}</p>
    @php
        // Convertir una URL normal de YouTube a URL embebida
        $embedUrl = str_replace("watch?v=", "embed/", $video->url);
    @endphp
    <iframe
        src="{{ $embedUrl }}"
        width="560"
        height="315"
        frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
        allowfullscreen>
    </iframe>
    <p>Data: {{ $video->published_at }}</p>
    <p>Anterior: {{ $video->previous }}</p>
    <p>Seguent: {{ $video->next }}</p>
    <p>ID de la serie: {{ $video->series_id }}</p>
    </x-videos-app-layout>

