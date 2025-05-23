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
        var url = "{{ route('app_application_type_index') }}";

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

    //AJOUT APPLICATION TYPE
    $(document).ready(function() {
        $('#addType').on('submit', function(e) {
            e.preventDefault();
            const formData = $(this).serialize();
            const url = $(this).attr('action')
            console.log(url)
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                success: function(response) {
                    console.log(response);
                    $('#submitBtn').prop('disabled', true);
                    $('#kt_modal_add_menu').modal('hide');
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

    //AJOUT APPLICATION TYPE 
    $(document).ready(function() {
        $('#addRole').on('submit', function(e) {
            e.preventDefault();
            const formData = $(this).serialize();
            const url = $(this).attr('action')
            console.log(url)
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                success: function(response) {
                    $('#submitBtn').prop('disabled', true);
                    $('#kt_modal_add_menu_type').modal('hide');
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

    //ACTIVATION ET DESACTIVATION
    $(document).on('click', '#activateBtn', function() {
        let url = $(this).attr('data-url');
        Swal.fire({
            title: "Êtes vous sur de vouloir effectuer cette action?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#50cd89",
            cancelButtonColor: "#d33",
            confirmButtonText: "Confirmer",
            cancelButtonText: "Annuler",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    type: 'POST',
                    beforeSend: function() {},
                    success: function(submitresponse) {
                        if (submitresponse.success) {
                            Swal.fire({
                                text: submitresponse.message,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "OK!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreurs',
                                html: submitresponse.message,
                                showCloseButton: true,
                                showCancelButton: false,
                                focusConfirm: true
                            });
                        }
                    },
                    error: function(err) {
                        console.log('Request failed:', err.status);
                        error_alert(err);

                    }
                });

            }
        });
    });

    //MODIFICATION APPLICATION TYPE
    $(document).on('click', '#editType', function() {
        const typeId = $(this).data('id');
        const code = $(this).data('code');
        const libelle = $(this).data('libelle');
        const statut = $(this).data('statut');
        const url = $(this).data('url');

        $('.code').val(code);
        $('.libelle').val(libelle);

        if (statut == 1) {
            $('.statut').prop('checked', true);
        } else {
            $('.statut').prop('checked', false);
        }
        $('#editTypeForm').attr('action', url);

    });

    $(document).ready(function() {
        $('#editTypeForm').on('submit', function(e) {
            e.preventDefault();
            const formData = $(this).serialize();
            const url = $(this).attr('action')
            console.log(url)
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                success: function(response) {
                    console.log(response);
                    $('#submitBtn').prop('disabled', true);
                    $('#kt_modal_edit_type').modal('hide');
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
