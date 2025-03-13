
<div class="table-responsive">
    <table class=" table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
        <thead>
            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                <th class="min-w-125px">Code</th>
                <th class="min-w-125px">Type</th>
                <th class="min-w-125px">Libelle</th>
                <th class="min-w-125px">Query</th>
                <th class="min-w-125px">Chaine de connexion</th>
                <th class="min-w-100px">Action</th>
            </tr>
        </thead>

        <tbody class="text-gray-600 fw-semibold">
            @forelse ($champs as $champ)
                <tr>
                    <td>
                        <div class="text-gray-800 text-hover-primary mb-1">{{ $champ->code }} </div>
                    </td>
                    <td>
                        <div class="text-gray-800 text-hover-primary mb-1">{{ $champ->type }}</div>
                    </td>
                    <td>
                        <div class="text-gray-800 text-hover-primary mb-1">{{ $champ->libelle }}</div>
                    </td>
                    <td>
                        <div class="text-gray-800 text-hover-primary mb-1">
                            {{ $champ->query ? $champ->query : 'Non renseigné' }}
                        </div>
                    </td>

                    <td>
                        <div class="text-gray-800 text-hover-primary mb-1">{{ $champ->connexion ? $champ->connexion : "Non renseigné" }}</div>
                    </td>
                    <td class="d-flex gap-5 text-end">
                        <i class="bi bi-pencil text-warning" style="cursor: pointer;" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_edit_apk" data-libelle="{{$champ->libelle}}" id="edit_apk"
                            data-id="{{$champ->id}}"
                            data-url="{{ route('application_role.update', ['application_role' => $champ->id]) }}">
                        </i>
    
                        <i class="bi bi-trash text-danger" style="cursor: pointer;"></i>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Aucune donnée</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
