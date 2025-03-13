<script>
    $(document).ready(function() {
        $(document).on('click', '#editBtn', function() {
            console.log($(this).attr('data-titre'));
            $('#titre').val($(this).attr('data-titre'));
            $('#titreSecondaire').val($(this).attr('data-titresecondaire'));
            $('#routeName').val($(this).attr('data-routename'));
            $('#icone').val($(this).attr('data-icone'));

            if ($(this).attr('data-issubmenu') == true) {
                $('#isSubMenu').prop("checked", true);
                $('#blocParent').attr('style', 'display:bloc');
            }
            if ($(this).attr('data-hassubmenu') == true) {
                $('#hasSubMenu').prop("checked", true);
            }

            if ($(this).attr('data-statut') == true) {
                $('#statut').prop("checked", true);
            }
            $('#parent')
                .val($(this).attr('data-parent'))
                .trigger('change');
                
            $('#position').val($(this).attr('data-position'));

            $('#modalTitle').text('Modification du menu');

            $('#addForm').attr('action', $(this).attr('data-url'));
            console.log($(this).attr('data-url'));

        });

        $(document).on('click', '#deleteBtn', function() {
            console.log($(this).attr('data-url'));
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

                                console.log(response.message);
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

        $(document).on('click', '#save', function(e) {
            e.preventDefault();
            let url = $('#addForm').attr('action');

            $.ajax({
                url: url,
                type: 'POST',
                data: $('#addForm').serialize(),
                beforeSend: function() {
                    $(this).attr('data-kt-indicator', 'on');
                    $(this).attr('disabled', true);
                },
                success: function(submitresponse) {
                    console.log(submitresponse);

                    $(this).attr('data-kt-indicator', 'off');
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
                                location.reload();
                            }
                        });

                        console.log(response.message);
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
                    $(this).attr('data-kt-indicator', 'off');
                    $(this).attr('disabled', false);
                    error_alert(err);

                }
            });
        });

        $(document).on('click', '#permissionBtn', function() {
            let url = $(this).attr('data-url');

            window.ajaxControl = null;

            if (window.ajaxControl) {
                window.ajaxControl.abort()
            };

            if (ajaxControl) ajaxControl.abort();

            $.ajax({
                url: url,
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                type: 'GET',
                beforeSend: function() {
                    $("#permdata").html(
                        '<div class="col-xs-12 text-center" style="padding-top: 3em;">' +
                        '<i class="fa fa-spin fa-spinner" style="color: lightgrey; font-size: 4em;"></i>' +
                        ' </div>'
                    );
                },
                success: function(submitresponse) {
                    $("div#permdata").html(submitresponse);
                },
                error: function(err) {
                    console.log('Request failed:', err.status);
                    error_alert(err);

                }
            });

        });

        $(document).on('click', '#addAction', function(e) {
            e.preventDefault();

            let url = $('#ActionForm').attr('action');
            console.log(url);

            window.ajaxControl = null;

            if (window.ajaxControl) {
                window.ajaxControl.abort()
            };

            if (ajaxControl) ajaxControl.abort();

            $.ajax({
                url: url,
                data: $('#ActionForm').serialize(),
                type: 'POST',
                beforeSend: function() {
                    $("#permdata").html(
                        '<div class="col-xs-12 text-center" style="padding-top: 3em;">' +
                        '<i class="fa fa-spin fa-spinner" style="color: lightgrey; font-size: 4em;"></i>' +
                        ' </div>'
                    );
                },
                success: function(submitresponse) {

                    if (submitresponse.success) {
                        console.log(submitresponse.message);

                        // location.reload();
                        $("div#permdata").html(submitresponse.message);

                    } else {
                        $("div#errorActSec").html(submitresponse.message);
                    }

                },
                error: function(err) {
                    // Handle the error
                    console.log('Request failed:', err.status);


                    error_alert(err);

                }
            });

        });

        $(document).on('click', '#deleteAction', function(e) {
            e.preventDefault();

            let url = $(this).attr('data-url');
            console.log(url);

            window.ajaxControl = null;

            if (window.ajaxControl) {
                window.ajaxControl.abort()
            };

            if (ajaxControl) ajaxControl.abort();

            $.ajax({
                url: url,
                data: {

                },
                type: 'GET',
                beforeSend: function() {
                    $("#permdata").html(
                        '<div class="col-xs-12 text-center" style="padding-top: 3em;">' +
                        '<i class="fa fa-spin fa-spinner" style="color: lightgrey; font-size: 4em;"></i>' +
                        ' </div>'
                    );
                },
                success: function(submitresponse) {

                    if (submitresponse.success) {
                        console.log(submitresponse.message);
                        // location.reload();
                        $("div#permdata").html(submitresponse.message);

                    } else {
                        $("div#errorActSec").html(submitresponse.message);
                    }

                },
                error: function(err) {
                    // Handle the error
                    console.log('Request failed:', err.status);


                    error_alert(err);

                }
            });

        })


        //Fonction de recherche
        $('.filter').on('keyup', function(e) {
            filter()
        });

        $('.filter').on('change', function(e) {
            filter()
        });

        function filter() {
            var search = $('#search').val();

            var url = "{{ route('app_menu_index') }}";

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

        $('#export').on('click', function(e) {
            $('#sortForm').attr('action', "{{ route('export.menu') }}");
            $('#sortForm').submit();
        });


    });
</script>
