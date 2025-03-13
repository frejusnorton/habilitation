<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#end_date", {
            minDate: "today",
            dateFormat: "Y-m-d", // Format de la date
            disableMobile: true, // Désactive le calendrier mobile pour une meilleure expérience sur desktop
        });
    });

    //AJOUT D'UN DEMANDE DE DEROGATION
    $(document).on('click', '#btn-continue', function() {
        let currentStep = $('.current');
        let isValid = true;
        let formData = {};
        //RECUPERER LES DONNEES DE l'ETAPE ACTUELLE
        currentStep.find('input').each(function() {
            formData[$(this).attr('name')] = $(this).val();
        });
        //ENVOYER UNE REQUETTE AJAX A LA ROUTE 
        $.ajax({
            url: "{{ route('derogation.create') }}",
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                    'content')
            },
            data: formData,
            success: function(response) {
                let currentStep = $('.current');
                currentStep.removeClass('current').hide();
                let nextStep = currentStep.next('[data-kt-stepper-element="content"]');
                nextStep.addClass('current').show();
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
                    let hasError = false;
                    const errors = xhr.responseJSON.errors;
                    if (errors.nom) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ereur!',
                            text: errors.nom[0],
                            showConfirmButton: true,
                            allowOutsideClick: false,
                        })
                        hasError = true;
                    }
                    if (errors.prenom) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ereur!',
                            text: errors.prenom[0],
                            showConfirmButton: true,
                            allowOutsideClick: false,
                        })
                        hasError = true;
                    }
                    if (errors.email) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ereur!',
                            text: errors.email[0],
                            showConfirmButton: true,
                            allowOutsideClick: false,
                        })
                        hasError = true;
                    }
                    if (errors.poste) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ereur!',
                            text: errors.poste[0],
                            showConfirmButton: true,
                            allowOutsideClick: false,
                        })
                        hasError = true;
                    }
                    if (hasError) {
                        return;
                    }
                }
            }
        });
    });


    // $(document).ready(function() {
    //     $('#addDerogation').on('submit', function(e) {
    //         e.preventDefault();
    //         console.log('intercepté');


    //         const formData = $(this).serialize();
    //         const url = $(this).attr('action')

    //         $.ajax({
    //             url: url,
    //             method: 'POST',
    //             data: formData,
    //             success: function(response) {
    //                 console.log(response);
    //                 $('#submitBtn').prop('disabled', true);
    //                 $('#kt_modal_add_menu').modal('hide');
    //                 Swal.fire({
    //                     icon: 'success',
    //                     title: 'Succès!',
    //                     text: response
    //                         .message,
    //                     showConfirmButton: true,
    //                     allowOutsideClick: false,
    //                 }).then((result) => {
    //                     if (result.isConfirmed) {
    //                         location.reload();
    //                     }
    //                 });;
    //                 $('#addForm')[0].reset();
    //             },
    //             error: function(xhr) {
    //                 console.log(xhr);
    //                 if (xhr.status === 500) {
    //                     Swal.fire({
    //                         icon: 'error',
    //                         title: 'Ereur!',
    //                         text: "Une erreur serveur est survenue",
    //                         showConfirmButton: true,
    //                         allowOutsideClick: false,
    //                     });
    //                 }
    //                 if (xhr.status === 422) {
    //                     const errors = xhr.responseJSON.errors;
    //                     if (errors.code) {
    //                         Swal.fire({
    //                             icon: 'error',
    //                             title: 'Ereur!',
    //                             text: errors.code[0],
    //                             showConfirmButton: true,
    //                             allowOutsideClick: false,
    //                         })
    //                     }
    //                     if (errors.libelle) {
    //                         Swal.fire({
    //                             icon: 'error',
    //                             title: 'Ereur!',
    //                             text: errors.libelle[0],
    //                             showConfirmButton: true,
    //                             allowOutsideClick: false,
    //                         })
    //                     }
    //                 }
    //             }
    //         })
    //     })
    // })
</script>
