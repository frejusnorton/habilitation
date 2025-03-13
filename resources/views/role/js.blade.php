<script>
    $(document).ready(function() {
        $('#checkAllToggle').click(function() {
            console.log('click');

            if ($(this).prop('checked')) {
                $('.ckeck').prop('checked', true);
            } else {
                $('.ckeck').prop('checked', false);
            }
        });

        $(document).on('click', '#save', function(e) {
            e.preventDefault();
            let url = $('#addForm').attr('action');
            console.log(url );
            $.ajax({
                url: url,
                type: 'POST',
                data: $('#addForm').serialize(),
                beforeSend: function() {
                    $(this).attr('disabled', true);
                },
                success: function(submitresponse) {
                    console.log(submitresponse);
                    $(this).attr('disabled', false);
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
                                window.location.href = submitresponse.route
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
                    // Handle the error
                    console.log('Request failed:', err.status);

                    $(this).attr('data-kt-indicator', 'off');
                    $(this).attr('disabled', false);

                    error_alert(err);

                }
            });
        });

        $(document).on('click', '#deleteBtn', function() {
         
            let url = $(this).attr('data-url');
            Swal.fire({
                title: "Êtes vous sur de vouloir supprimer?",
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
                            console.log(submitresponse);
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

                                console.log(submitresponse.message);
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

        $(document).on('click', '#activateBtn', function() {
            console.log($(this).attr('data-url'));
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
                            console.log(submitresponse);
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

                                console.log(submitresponse.message);
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
    })
</script>
