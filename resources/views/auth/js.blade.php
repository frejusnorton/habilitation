<script>
    $(document).ready(function() {
        $('#connexion').on('submit', function(e) {
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
                    Swal.fire({
                        icon: 'success',
                        title: 'Succès!',
                        text: response
                            .message,
                        showConfirmButton: true,
                        allowOutsideClick: false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = response.redirect;
                        }
                    });;
                },
                error: function(xhr) {
                    console.log(xhr);
                    if (xhr.status === 500) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ereur!',
                            text: "Une erreur serveur est survenue lors de la connexion",
                            showConfirmButton: true,
                            allowOutsideClick: false,
                        });
                    }
                    if (xhr.status === 401) {
                        const errorResponse = xhr.responseJSON; 
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur!',
                            text: errorResponse.message ||
                                'Une erreur est survenue.',
                            showConfirmButton: true,
                            allowOutsideClick: false,
                        });
                    }
                    
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        if (errors.password) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Ereur!',
                                text: errors.password[0],
                                showConfirmButton: true,
                                allowOutsideClick: false,
                            })
                        }
                        if (errors.username) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Ereur!',
                                text: errors.username[0],
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
