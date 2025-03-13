<script>
    $(document).ready(function() {

        //#Modification----------------------------------------------------
        $(document).on('click', '#editBtn', function() {

            $('#libelle1').val($(this).attr('data-libelle'));
            $('#identifiant1').val($(this).attr('data-identifiant'));
            $('#menu1').val($(this).attr('data-menu'));

            if ($(this).attr('data-statut') == true) {
                $('#statut1').prop("checked", true);
            }
            document.forms.editForm.action = $(this).attr('data-url');
        });

      











        $(document).on('click', '#deleteBtn', function() {
            document.forms.formId.action = $(this).attr('data-url');
            Swal.fire({
                title: "{{ __('Suppression') }}",
                text: "{{ __('Voulez-vous vraiment supprimer ?') }}",
                icon: "info",
                buttonsStyling: false,
                showCancelButton: true,
                confirmButtonText: "{{ __('Oui, Supprimer') }}",
                cancelButtonText: '{{ __('Annuler') }}',
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: 'btn btn-danger'
                }
            }).then((result) => {
                if (result.isConfirmed) {

                    $('#formId').submit();
                }
            });
        });

        var currentRequest = null;
        $("#searchMenu").keydown(function() {
            var search = $(this).val()
            $('#blocDatatable').html(
                '<div class="text-center"><div class="spinner-border" style="width: 3rem; height: 3rem;" role="status"><span class="visually-hidden">Loading...</span></div></div>'
            );
            //then you make another ajax request
            var path = "{{ route('app_acl_search') }}";
            currentRequest = $.ajax({
                type: "GET",
                url: path,
                data: {
                    search: search
                },
                beforeSend: function() {
                    if (currentRequest != null) {
                        currentRequest.abort();
                    }

                },
                success: function(response) {
                    $('#blocDatatable').html(response)
                }
            });
        });

        $(document).on('click', '#exportBtn', function() {
            $('#searchData').val($('#searchMenu').val())
        })

    })
</script>
