<x-videos-app-layout>
    <div class="container">
        <h1>Confirmar Eliminació</h1>

        <p>Estàs segur que vols eliminar el vídeo: <strong>{{ $video->title }}</strong>?</p>

        <form action="{{ route('videos.manage.destroy', $video->id) }}" method="POST" data-qa="video-delete-form">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-danger">Eliminar</button>
            <a href="{{ route('videos.manage.index') }}" class="btn btn-secondary">Cancel·lar</a>
        </form>
    </div>
</x-videos-app-layout>
