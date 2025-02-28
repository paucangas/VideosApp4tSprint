<x-videos-app-layout>

    <div class="container mt-5">
        <h1 class="text-center mb-4">🎬 Videos 🎬</h1>
        <div class="row">
            @foreach ($videos as $video)
                @php
                    preg_match('/(?:\/|v=)([a-zA-Z0-9_-]{11})/', $video->url, $matches);
                    $videoId = $matches[1] ?? null;
                    $thumbnailUrl = $videoId ? "https://img.youtube.com/vi/$videoId/hqdefault.jpg" : null;
                @endphp
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card shadow-sm">
                                @if ($thumbnailUrl)
                                    <a href="{{ url('/video', $video->id) }}">
                                        <img src="{{ $thumbnailUrl }}" class="card-img-top"
                                             alt="Miniatura de {{ $video->title }}">
                                    </a>
                                @else
                                    <div class="text-center p-4 bg-light">Miniatura no disponible</div>
                                @endif
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title">
                                    <a href="{{ url('/video', $video->id) }}"
                                       class="text-decoration-none text-dark fw-bold">
                                        {{ $video->title }}
                                    </a>
                                </h5>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
        </div>
    </div>

</x-videos-app-layout>

