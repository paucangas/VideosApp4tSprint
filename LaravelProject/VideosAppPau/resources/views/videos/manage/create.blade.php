<x-videos-app-layout>
    <div class="container">
        <h1>Crear Vídeo</h1>

        <form action="{{ route('videos.manage.store') }}" method="POST" data-qa="video-create-form">
            @csrf
            <div class="form-group">
                <label for="title" data-qa="title-label">Títol</label>
                <input type="text" class="form-control" id="title" name="title" required data-qa="title-input">
            </div>

            <div class="form-group">
                <label for="description" data-qa="description-label">Descripció</label>
                <textarea class="form-control" id="description" name="description" data-qa="description-input"></textarea>
            </div>

            <div class="form-group">
                <label for="url" data-qa="url-label">URL</label>
                <input type="url" class="form-control" id="url" name="url" required data-qa="url-input">
            </div>

            <div class="form-group">
                <label for="published_at" data-qa="published_at-label">Data de publicació</label>
                <input type="date" class="form-control" id="published_at" name="published_at" required data-qa="published_at-input">
            </div>

            <div class="form-group">
                <label for="previous" data-qa="previous-label">Vídeo anterior</label>
                <input type="text" class="form-control" id="previous" name="previous" data-qa="previous-input">
            </div>

            <div class="form-group">
                <label for="next" data-qa="next-label">Vídeo següent</label>
                <input type="text" class="form-control" id="next" name="next" data-qa="next-input">
            </div>

            <div class="form-group">
                <label for="series_id" data-qa="series_id-label">Sèrie</label>
                <input type="number" class="form-control" id="series_id" name="series_id" data-qa="series_id-input">
            </div>

            <button type="submit" class="btn btn-create-video mt-3" data-qa="submit-button">Crear Vídeo</button>
        </form>
    </div>
</x-videos-app-layout>
