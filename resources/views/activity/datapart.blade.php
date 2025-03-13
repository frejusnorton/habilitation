<!--begin::Table-->
<div class="table-responsive">
    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
        <thead>
        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
            <th class="min-w-125px">Date</th>
            <th class="min-w-125px">Utilisateur</th>
            <th class="min-w-125px">Action</th>
        </tr>
        </thead>
        <tbody class="text-gray-600 fw-semibold">
        @forelse ($activities as $activity)
            <tr>
                <td class="">
                    {{  Carbon\carbon::parse($activity->created_at)->format('d-m-Y')  }}
                </td>

                <td >
                    {{$activity->userDetail->username}}
                </td>

                <td >
                    {{$activity->action}}
                </td>
            </tr>

        @empty
        @endforelse
        </tbody>
    </table>
    <!--end::Table-->
    {{$activities->links('pagination.custom')}}
</div>
