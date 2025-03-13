<script>
    $(document).ready(function () {
        $(document).on('click', '#editUser', function () {
            $('#id').val($(this).data('id'))
            $('.username').val($(this).data('username'))
            $('.nom').val($(this).data('nom'))
            $('.poste').val($(this).data('poste'))
            $('.prenom').val($(this).data('prenom'))
            $('.role').val($(this).data('role')).trigger('change');
            $('.superieur').val($(this).data('superieur')).trigger('change');
            $('.connexion').val($(this).data('type')).trigger('change');
            $('.superieur').val($(this).data('superieur')).trigger('change');

            $('.agence').val($(this).data('agence')).trigger('change');
            $('.direction').val($(this).data('direction')).trigger('change');
            $('.departement').val($(this).data('departement')).trigger('change');
            $('.service').val($(this).data('service')).trigger('change');


            $('.validateur1').val($(this).data('validateur1')).trigger('change');
            $('.validateur2').val($(this).data('validateur2')).trigger('change');
            $('.validateur3').val($(this).data('validateur3')).trigger('change');

            $('.role').val($(this).data('role')).trigger('change');
            $('.email').val($(this).data('email'))

            const url = $(this).data('url')
            $('#edit_user').attr('action', url);
           
        });
    });

    $(document).ready(function() {
   
        $('#edit_user').on('submit', function(e) {
            e.preventDefault();
            const formData = $(this).serialize() + "&_token=" + $('meta[name="csrf-token"]').attr('content');
            const url = $(this).attr('action')
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                success: function(response) {
                    $('#submitBtn').prop('disabled', true);
                    $('#kt_modal_edit_user').modal('hide');
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
            })
        })
    })

</script>