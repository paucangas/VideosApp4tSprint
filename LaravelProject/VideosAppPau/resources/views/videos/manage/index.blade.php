<x-videos-app-layout>
    <div class="container">
        <h1>Gestió de Vídeos</h1>
        <a href="{{ route('videos.manage.create') }}" class="btn btn-create-video mb-3">Crear Vídeo</a>

        @if (session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped mt-3">
                <thead>
                <tr>
                    <th>Títol</th>
                    <th>Descripció</th>
                    <th>URL</th>
                    <th>Data de publicació</th>
                    <th>Anterior</th>
                    <th>Següent</th>
                    <th>Sèrie</th>
                    <th>Accions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($videos as $video)
                    <tr>
                        <td>{{ $video->title }}</td>
                        <td>{{ \Str::limit($video->description, 50) }}</td>
                        <td><a href="{{ $video->url }}" target="_blank">{{ $video->url }}</a></td>
                        <td>{{ \Carbon\Carbon::parse($video->published_at)->format('d-m-Y') }}</td>
                        <td>{{ $video->previous }}</td>
                        <td>{{ $video->next }}</td>
                        <td>{{ $video->series_id }}</td>
                        <td>
                            <a href="{{ route('videos.manage.edit', $video->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('videos.manage.destroy', $video->id) }}" method="POST" onsubmit="return confirm('Estas segur de que vols eliminiar el vídeo?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-videos-app-layout>
