<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Choisir les applications</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="choix_application" action="{{ route('loadField') }}" method="post">
                    @csrf
                    <input type="hidden" name="selected_applications" id="selected_applications">
                    <div class="row mb-5">
                        <label class="form-label">Choisir les applications</label>
                        <div class="d-flex flex-column">
                            @foreach ($applications->chunk(10) as $chunk)
                                <div class="d-flex flex-wrap">
                                    @foreach ($chunk as $application)
                                        <div class="mb-3 col-12 col-md-6">
                                            <label class="form-check-label" for="champ_{{ $application->id }}">
                                                <input class="form-check-input" type="checkbox" name="champs[]"
                                                    value="{{ $application->id }}" id="champ_{{ $application->id }}">
                                                {{ $application->libelle}}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" id="submitButton" class="btn btn-primary btn-sm">Continuer</button>
                    </div>
                </form>
                

            </div>

        </div>
    </div>
</div>