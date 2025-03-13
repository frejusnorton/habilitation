<div>
    <form id="ActionForm" method="post" class="" action="{{ route('app_acl_new', ['menu' => $menu->id]) }}">
        <div id="errorActSec"></div>
        @csrf
        <div class="my-1">
            <label for="">Identifiant</label>
            <input type="text" name="identifiant" class="form-control form-control-sm"
                placeholder="Identifiant de la permission" autocomplete="off">
        </div>
        <div class="my-1">
            <label for="">Libelle</label>
            <input type="text" name="libelle" class="form-control form-control-sm"
                placeholder="Libelle de la permission" autocomplete="off">
        </div>

        <div class="d-grid gap-2 my-2">
            <button class="btn btn-block btn-sm btn-light-success" id="addAction">Ajouter</button>
        </div>
    </form>
    <div class="mt-3 table-responsive">
        <table class="table align-middle table-row-dashed fs-6 gy-5">
            <thead>
                <tr>
                    <td>Identifiant</td>
                    <td class="min-w-250px">Libelle</td>
                    <td class="">Action</td>
                </tr>
            </thead>
            <tbody>
                @forelse ($actions as $item)
                    <tr>
                        <td>
                            <span class="badge badge-light">{{ $item->identifiant }}</span>
                        </td>
                        <td>{{ $item->libelle }}</td>
                        <td>
                            <a href="#" id="deleteAction" class="btn btn-sm" data-url="{{ route('app_acl_delete', ['menu'=> $menu->id,'acl' =>$item->id]) }}">
                                <i class="bi bi-trash-fill text-danger"></i>
                            </a>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="2" class="text-center text-danger">Aucune permission</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
