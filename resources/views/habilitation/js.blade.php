<script>
    //Fonction de recherche
    $('.filter').on('keyup', function(e) {
        filter()
    });

    function filter() {
        var search = $('#search').val();
        console.log(search);
        var url = "{{ route('app_habilitation_index') }}";
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
 
    $('#choix_application').on('submit', function(e) {
        e.preventDefault(); 
        
        let selectedApplications = [];
        $('input[name="champs[]"]:checked').each(function() {
            selectedApplications.push($(this).val());
        });

        $('#application-container').empty();

        selectedApplications.forEach(function (id) {
        $('#application-container').append(
            `<input type="hidden" name="applications[]" value="${id}" />`
        );
    });
        
        var submitButton = $('#submitButton');
        submitButton.prop('disabled', true);
        submitButton.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Chargement...');

        $.ajax({
            url: "{{ route('loadField') }}",
            method: 'POST',
            data: {
                applications: selectedApplications, 
                _token: '{{ csrf_token() }}' 
            },
            success: function(response) {
                $('#staticBackdrop').modal('hide'); 
                $('#formPart').html(response);
                submitButton.prop('disabled', false); 
                submitButton.html('Continuer');
            },
            error: function(xhr, status, error) {
                console.error(status, error);
                submitButton.prop('disabled', false);
                submitButton.html('Continuer');
            }
        });
});

    //SELECT POUR EXECUTER 
    $(document).on('focus', '#selectFields', function () {
    const url = $(this).data('url');
    const query = $(this).data('query');
    const connexion = $(this).data('connexion');
    const champs = $(this).data('champs');
    $.ajax({
        url: url,
        method: 'POST',
        data: {
            query: query,
            connexion: connexion,
            champs: champs,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
         if (response && Array.isArray(response)) {
        const select = $("#selectFields");
        select.empty();
        select.append('<option disabled selected>Veuillez choisir</option>');
        response.forEach(item => {
            select.append(`<option value="${item.age}">${item.lib.trim()}</option>`);
        });
    } else {
        $("#selectValue").html('<option disabled>Aucune donnée disponible</option>');
    }
        },
        error: function (xhr) {
            console.error('Erreur :', xhr);
        }
    });
});

    //AJOUT D'UNE DEMANDE
    $(document).ready(function() {
    $('#add_demande').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize();
        const url = $(this).attr('action');
        var submitButton = $('#submitBtn');

        // Désactiver le bouton et afficher le spinner
        submitButton.prop('disabled', true);
        submitButton.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Chargement...');

        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            success: function(response) {
              
                submitButton.prop('disabled', false);
                submitButton.html('Enregistrer');

                Swal.fire({
                    icon: 'success',
                    title: 'Succès!',
                    text: response.message,
                    showConfirmButton: true,
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = response.redirect;
                    }
                });
            },
            error: function(xhr) {
                // Réactiver le bouton et réinitialiser le texte
                submitButton.prop('disabled', false);
                submitButton.html('Enregistrer');

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
                    // Parcours dynamique des erreurs
                    $.each(errors, function(key, value) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur!',
                            text: value[0],
                            showConfirmButton: true,
                            allowOutsideClick: false,
                        });
                    });
                }
            }
        });
    });
});

//SUPPRIMER UNE DEAMNDE
$(document).on('click', '#delete_demande', function() {
    let demande_id = $(this).data("id");
    let url = "{{ route('supprimer.demande', ['demande' => ':demande']) }}".replace(':demande', demande_id);

    Swal.fire({
        title: "Êtes-vous sûr de vouloir supprimer cette demande?",
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
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        Swal.fire({
                            text: response.message,
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "OK!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        }).then(() => {
        
        window.location.reload();
    });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            html: response.message,
                            showCloseButton: true,
                            showCancelButton: false,
                            focusConfirm: true
                        });
                    }
                },
                error: function(err) {
                    console.log(err);
                    if (err.responseJSON) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur!',
                            text: err.responseJSON.message,
                            showConfirmButton: true,
                            allowOutsideClick: false,
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur inconnue!',
                            text: 'Une erreur s\'est produite, veuillez réessayer.',
                            showConfirmButton: true,
                            allowOutsideClick: false,
                        });
                    }
                }
            });
        }
    });
});

    // APPROUVER DEAMNDE #
    $(document).on('click', '#approuver_demande', function() {
    let demande_id = $(this).data("id");
    
    let url = "{{ route('valider.approbation', ['demande' => ':demande']) }}".replace(':demande', demande_id);

    Swal.fire({
        title: "Êtes-vous sûr de vouloir approuver cette demande?",
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
                dataType: "json",
                success: function(response) {
                    console.log(response);

                    if (response.success) {
                        // Met à jour immédiatement le statut dans le DOM avant de recharger la page
                        $("#statut_" + demande_id).html('<span class="badge badge-light-success fw-bold">Valider</span>');

                        Swal.fire({
                            text: response.message,
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "OK!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        }).then(() => {
                            location.reload(); // Recharge après affichage du statut
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            html: response.message || "Une erreur est survenue.",
                            showCloseButton: true,
                        });
                    }
                },
                error: function(err) {
                    console.log(err);
                    let message = err.responseJSON ? err.responseJSON.message : "Une erreur inconnue s'est produite.";
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur!',
                        text: message,
                        showConfirmButton: true,
                        allowOutsideClick: false,
                    });
                }
            });
        }
    });
});


</script>