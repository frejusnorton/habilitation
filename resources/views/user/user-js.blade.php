
<script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/css/jquery-confirm.min.css') }}">
<script src="{{ asset('assets/js/jquery-confirm.min.js') }}"></script>
<script>

    $(".date").flatpickr({
        enableTime: false,
        dateFormat: "d-m-Y",
    });
    
    $('.filter').on('keyup', function(e) {
        filter()
    });

    // $('.filter').on('change', function(e) {
    //     filter()
    // });

    function filter() {
     
        
        var search = $('#searchUser').val();
        // console.log(search);
        var url = "{{ route('app_user_index') }}";

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
    //Fonction de recherche
    // $('.filter').on('change', function(e) {
    //     var poste = $('#searchPoste').val();
    //     var statut = $('#searchStatut').val();
    //     var search = $('#searchUser').val();
    //     var role = $('#SearchRole').val();

    //     console.log($('#searchUser').val())
    //     var url = "{{ route('app_user_index') }}";

    //     $("div#datatoload").html('<div class="col-xs-12 text-center" style="padding-top: 3em;">' +
    //         '<i class="fa fa-spin fa-spinner" style="color: lightgrey; font-size: 4em;;"></i>' +
    //         ' </div>'
    //     )
    //     window.ajaxControl = null;

    //     if (window.ajaxControl) {
    //         window.ajaxControl.abort()
    //     };

    //     if (ajaxControl) ajaxControl.abort();
    //     ajaxControl = $.ajax({
    //         url: url,
    //         data: {

    //             'search': search,
    //             'role': role,
    //             'statut': statut,

    //         },
    //         type: 'GET',
    //         success: function(data) {
    //             $("div#datatoload").html(data);
    //             $('[data-bs-toggle="tooltip"]').tooltip();
    //         },

    //     });
    // });

    //ENREGISTREMENT D'UN UTILISATEUR
    $(document).on('click', '#save', function(e) {
    e.preventDefault();

    let button = $(this); 
    let url = $('#addForm').attr('action');
    const formData = $('#addForm').serialize() + $('meta[name="csrf-token"]').attr('content'); 
    $.ajax({
        url: url,
        method: 'POST',
        data: formData,
        success: function(response) {
            console.log(response);
            button.attr('data-kt-indicator', 'off'); 
            button.attr('disabled', false);

            if (response.success) {
                Swal.fire({
                    text: response.message, 
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
                    html: response.message, 
                    showCloseButton: true,
                    showCancelButton: false,
                    focusConfirm: true
                });
            }
        },
        error: function(xhr) {
            console.log(xhr);
            button.attr('data-kt-indicator', 'off'); // Réactiver le bouton en cas d'erreur
            button.attr('disabled', false);

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
                Object.keys(errors).forEach(field => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur!',
                        text: errors[field][0],
                        showConfirmButton: true,
                        allowOutsideClick: false,
                    });
                });
            }
        }
    });
});

</script>