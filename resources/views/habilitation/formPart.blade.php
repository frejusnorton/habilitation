@if (isset($applications) && count($applications) > 0)
@foreach ($applications as $application)
<div class="application-section mb-5 p-4 border rounded shadow-sm">
  
    <h4 class="mb-4 text-primary">
        <i class="bi bi-app-indicator me-2"></i>{{ $application->libelle }}
    </h4>

    <div class="row">
    
        @if ($application->roles)
        <div class="col-md-4 mb-4">
            <label class="fs-6 fw-semibold form-label mb-2 text-primary">
                <span class="required">Rôle dans {{ $application->libelle }}</span>
            </label>
            <select class="form-select form-select-sm border-primary text-primary fw-bold" data-control="select2"
                data-placeholder="Choisir le rôle" name="roles[{{ $application->id }}]"
                id="role_{{ $application->id }}">
                <option value="">--Selectionner un role--</option>
                @foreach ($application->roles as $role)
                <option value="{{ $role->id }}">{{ $role->libelle }}</option>
                @endforeach
            </select>
        </div>
        @endif

   
        <div class="col-md-8 d-flex flex-wrap">
            @if ($application->champs)
            @foreach ($application->champs as $champ)
            @if ($champ->fields->type == 'Select')
            <div class="col-md-5 mx-2 mb-3">
                <label for="select_{{ $champ->fields->code }}" class="fw-semibold fs-6 fw-semibold">{{
                    $champ->fields->libelle }}</label>
                <select class="form-select form-select-sm "
                    name="champs[{{ $application->id }}][{{ $champ->fields->code }}]" id="selectFields"
                    id="select_{{ $champ->fields->code }}" data-query="{{ $champ->fields->query }}"
                    data-connexion="{{ $champ->fields->connexion }}" data-url="{{route('send.query')}}">
                    <option disabled selected>Veuillez sélectionner</option>
                </select>
            </div>
            @elseif ($champ->fields->type == 'Input')
            <div class="col-md-5 mx-2 mb-3">
                <label for="input_{{ $champ->fields->code }}" class="fw-semibold fs-6 fw-semibold">{{
                    $champ->fields->libelle }}</label>
                <input type="text" name="value"
                    id="input_{{ $champ->fields->code }}" class="form-control form-control-sm"
                    placeholder="{{ $champ->fields->libelle }}">
            </div>
            @endif
            @endforeach
            @endif
        </div>
    </div>
</div>
@endforeach

<div class="global-comment-section mt-5 p-4 border rounded shadow-sm ">
    <h5 class="mb-3 text-secondary fw-bold">
        <i class="bi bi-chat-left-text me-2"></i> Commentaire
    </h5>
    <textarea name="commentaire" id="commentaire_global" class="form-control" rows="4"
        placeholder="Ajouter un commentaire ..."></textarea>
</div>
@endif