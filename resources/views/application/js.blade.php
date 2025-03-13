<script>
    //Fonction de recherche
    $('.filter').on('keyup', function(e) {
        filter()
    });

    $('.filter').on('change', function(e) {
        filter()
    });

     //filtrage
    function filter() {
        var search = $('#search').val();
        var url = "{{ route('app_application_index') }}";

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

    //AJOUT D'UNE APPLICATION
    $(document).ready(function() {
        $('#addForm').on('submit', function(e) {
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
                        if (errors.libelle) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Ereur!',
                                text: errors.libelle[0],
                                showConfirmButton: true,
                                allowOutsideClick: false,
                            })
                        }
                        if (errors.application_role) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Ereur!',
                                text: errors.application_role[0],
                                showConfirmButton: true,
                                allowOutsideClick: false,
                            })
                        }
                        if (errors.application_type) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Ereur!',
                                text: errors.application_type[0],
                                showConfirmButton: true,
                                allowOutsideClick: false,
                            })
                        }
                    }
                }
            })
        })
    })

    //AJOUT APPLICATION ROLE
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
                    console.log(response);
                    $('#submitBtn').prop('disabled', true);
                    $('#kt_modal_add_menu_role').modal('hide');
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


    //MODIFICATION APPLICATION
    $(document).on('click', '#editBtn', function() {
        const appicationId = $(this).data('id');
        const libelle = $(this).data('libelle');
        const application_type_id = $(this).data('application_type');
        const application_role_id = $(this).data('application_role');
        const url = $(this).data('url')

        $('.libelle').val(libelle);
        $('.application_type').val(application_type_id).trigger('change');
        $('.application_role').val(application_role_id).trigger('change');

        $('#editRoleForm').attr('action', url);
    });

    $(document).ready(function() {
        $('#editRoleForm').on('submit', function(e) {
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
                    $('#kt_modal_edit_role').modal('hide');
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

    //AJOUTER ROLE POUR APPLICATION
    $(document).on('click','#role_menu',function(){
        const application_id = $(this).data('id');
        $('#add_role_menu').data('application_id',application_id);
    })
    $(document).ready(function() {
        $('#add_role_menu').on('submit', function(e) {
            e.preventDefault();
            const formData =  $(this).serializeArray();
            const application_id = $(this).data('application_id');
            formData.push({ name: 'application_id', value: application_id });
            const url = $(this).attr('action')
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                success: function(response) {
                    console.log(response);
                    $('#submitBtn').prop('disabled', true);
                    $('#kt_modal_add_menu_role').modal('hide');
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

    //SUPPRESSION APPLICATION
    $(document).on('click', '#deleteRole', function() {
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
                    beforeSend: function() {
                    },
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

    //AJOUTER UN CHAMP POUR APPLICATION
    $(document).on('click','#champ_menu',function(){
        const application_id = $(this).data('id');
        $('#add_champ_menu').data('application_id',application_id);
    })

    $(document).ready(function() {
        $('#add_champ_menu').on('submit', function(e) {
            e.preventDefault();
            const formData =  $(this).serializeArray();
            const application_id = $(this).data('application_id');
           
            formData.push({ name: 'application_id', value: application_id });
            const url = $(this).attr('action')
            console.log(url);
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                success: function(response) {
                    console.log(response);
                    $('#submitBtn').prop('disabled', true);
                    $('#kt_modal_add_menu_role').modal('hide');
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
                        if (errors.champs_id) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Ereur!',
                                text: errors.champs_id[0],
                                showConfirmButton: true,
                                allowOutsideClick: false,
                            })
                        }
                    }
                }
            })
        })
    })

    //AFFICHER LES PROFILS LIES A UNE APPLICATION 
    $(document).on('click','#role_menu',function(){
        const application_id = $(this).data('id');
        const url = "{{ route('loadProfils', ['application' => ':id']) }}".replace(':id', application_id);
        const formData = {
        application_id: application_id,
    };
    $.ajax({
                url: url,
                method: 'GET',
                data: formData,
                beforeSend: function() {
                    $("#permdata").html(
                        '<div class="col-xs-12 text-center" style="padding-top: 3em;">' +
                        '<i class="fa fa-spin fa-spinner" style="color: lightgrey; font-size: 4em;"></i>' +
                        ' </div>'
                    );
                },
                success: function(response) {
                    $('#permdata').html(response);
                },
                error: function(xhr) {
                    console.log(xhr);
                    Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: 'Impossible de charger les rôles.'
            });
                   
                }
            })
    })

    //AFFICHER LES CHAMPS LIEES A UNE APPLICATION
    $(document).on('click','#champ_menu',function(){
        const application_id = $(this).data('id');
        const url = "{{ route('loadChamps', ['application' => ':id']) }}".replace(':id', application_id);
        const formData = {
        application_id: application_id,
    };
    $.ajax({
                url: url,
                method: 'GET',
                data: formData,
                beforeSend: function() {
                    $("#champsdata").html(
                        '<div class="col-xs-12 text-center" style="padding-top: 3em;">' +
                        '<i class="fa fa-spin fa-spinner" style="color: lightgrey; font-size: 4em;"></i>' +
                        ' </div>'
                    );
                },
                success: function(response) {
                    console.log(response);
                    $('#champsdata').html(response);
                },
                error: function(xhr) {
                    console.log(xhr);
                    Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: 'Impossible de charger les champs.'
            });
                   
                }
            })
    })

    //MODIFIER ROLE APPLICATION
    $(document).on('click','#edit_apk',function(){
        const libelle = $(this).data('libelle');
        const application_id = $(this).data('id');
        const url = $(this).data('url')
     
        $('#edit_role_form').attr('action', url);
        $('.libelle').val(libelle);
        $('.application_id').val(application_id);
    })

    $(document).ready(function() {
    $('#edit_role_form').on('submit', function(e) {
        e.preventDefault();  
        const url = $(this).attr('action');  
        console.log(url);
        
        const formData = $(this).serializeArray();  
        const application_id = $('#application_id').val();  

        formData.push({ name: 'application_id', value: application_id });
        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            success: function(response) {
                $('#save').prop('disabled', true);
                $('#kt_modal_edit_apk').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Succès!',
                    text: response.message,
                    showConfirmButton: true,
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload(); 
                    }
                });

                $('#edit_role_form')[0].reset();
            },
            error: function(xhr) {
                console.log(xhr);

                if (xhr.status === 500) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur!',
                        text: "Une erreur serveur est survenue",
                        showConfirmButton: true,
                        allowOutsideClick: false,
                    });
                }

                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    if (errors.libelle) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur!',
                            text: errors.libelle[0],
                            showConfirmButton: true,
                            allowOutsideClick: false,
                        });
                    }
                }
            }
        });
    });

   
  
});

</script>