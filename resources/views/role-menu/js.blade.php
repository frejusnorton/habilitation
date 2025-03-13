<script>
     //Fonction de recherche
     $('.filter').on('keyup', function(e) {
        filter()
    });

    $('.filter').on('change', function(e) {
        filter()
    });

    function filter() {
        var search = $('#search').val();
        var url = "{{ route('app_role_menu_index') }}";

        $("#datapart").html('<div class="col-xs-12 text-center" style="padding-top: 3em;">' +
            '<i class="fa fa-spin fa-spinner" style="color: lightgrey; font-size: 4em;"></i>' +
            ' </div>'
        );
        window.ajaxControl = null;

        if (window.ajaxControl) {
            window.ajaxControl.abort()
        };
        if (ajaxControl) ajaxControl.abort();
        ajaxControl = $.ajax({
            url: url,
            data: {
                'search': search,
                'filter': true
            },
            type: 'GET',
            success: function(data) {
                $("div#datapart").html(data);
            },
        });
    }

    // $(document).ready(function() {
    //     $(document).on('click', '#editBtn', function() {
    //         $('#menu').val($(this).attr('data-menu'));
    //         $('#role').val($(this).attr('data-role'));
    //         document.forms.formid.action = $(this).attr('data-url');
    //     });

    //     $(document).on('click', '#deleteBtn', function() {
    //         document.forms.formId.action = $(this).attr('data-url');
    //         Swal.fire({
    //             title: "{{ __('Suppression') }}",
    //             text: "{{ __('Voulez-vous vraiment supprimer ?') }}",
    //             icon: "info",
    //             buttonsStyling: false,
    //             showCancelButton: true,
    //             confirmButtonText: "{{ __('Oui, Supprimer') }}",
    //             cancelButtonText: '{{ __('Annuler') }}',
    //             customClass: {
    //                 confirmButton: "btn btn-primary",
    //                 cancelButton: 'btn btn-danger'
    //             }
    //         }).then((result) => {
    //             if (result.isConfirmed) {

    //                 $('#formId').submit();
    //             }
    //         });
    //     });

    //     var currentRequest = null;
    //     $("#searchMenu").keydown(function() {
    //         var search = $(this).val()
    //         $('#blocDatatable').html(
    //             '<div class="text-center"><div class="spinner-border" style="width: 3rem; height: 3rem;" role="status"><span class="visually-hidden">Loading...</span></div></div>'
    //             );
    //         //then you make another ajax request
    //         var path = "{{ route('app_role_menu_search') }}";
    //         currentRequest = $.ajax({
    //             type: "GET",
    //             url: path,
    //             data: {
    //                 search: search
    //             },
    //             beforeSend: function() {
    //                 if (currentRequest != null) {
    //                     currentRequest.abort();
    //                 }

    //             },
    //             success: function(response) {
    //                 $('#blocDatatable').html(response)
    //             }
    //         });
    //     });

    //     $(document).on('click', '#exportBtn', function(){
    //         $('#searchData').val($('#searchMenu').val())
    //     })

    // })       

    $(document).ready(function() {
        $('#addForm').on('submit', function(e) {
            e.preventDefault();

            const formData = $(this).serialize();
            const url = $(this).attr('action')
          
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                success: function(response) {
                    console.log(response);
                    $('#submitBtn').prop('disabled', true);
                    $('#kt_modal_add_role_menu').modal('hide');
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Succès!',
                        text: response
                            .message,
                        showConfirmButton: true,
                        allowOutsideClick: false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });;
                    $('#addForm')[0].reset();
                },
                error: function(xhr) {
                    console.log(xhr);
                    if (xhr.status === 500) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ereur!',
                            text: "Une erreur serveur est survenue",
                            showConfirmButton: true,
                            allowOutsideClick: false,
                        });
                    }

                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        if (errors.code) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Ereur!',
                                text: errors.code[0],
                                showConfirmButton: true,
                                allowOutsideClick: false,
                            })
                        }
                        if (errors.libelle) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Ereur!',
                                text: errors.libelle[0],
                                showConfirmButton: true,
                                allowOutsideClick: false,
                            })
                        }
                    }
                }
            })
        })
    })
</script>
