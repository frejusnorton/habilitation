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
        var url = "{{ route('app_validateur_index') }}";

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

  

    //Confirmation de validation: 
    $(document).on('click', '#valider_demande', function() {
        let demande_id = $(this).data("id");
        let url = "{{ route('validation.demande', ['demande' => ':demande']) }}".replace(':demande', demande_id);
         console.log(demande_id)
         Swal.fire({
             title: "Êtes vous sur de vouloir confirmer?",
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
                     success: function(response) {
                        //  console.log(response);
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
                  error: function(err) {
                    if (err.responseJSON) {
            Swal.fire({
                icon: 'error',
                title: 'Erreur!',
                text: err.responseJSON.message,
                showConfirmButton: true,
                allowOutsideClick: false,
            });
        }else {
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

      //Rejeter la demande: 
    $(document).on('click', '#rejeter_demande', function() {
        let demande_id = $(this).data("id");
        let url = "{{ route('rejet.demande', ['demande' => ':demande']) }}".replace(':demande', demande_id);
         console.log(demande_id)
         Swal.fire({
             title: "Êtes vous sur de vouloir rejeter la demande?",
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
                     success: function(response) {
                        //  console.log(response);
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
                  error: function(err) {
                    if (err.responseJSON) {
            Swal.fire({
                icon: 'error',
                title: 'Erreur!',
                text: err.responseJSON.message,
                showConfirmButton: true,
                allowOutsideClick: false,
            });
        }else {
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
</script>