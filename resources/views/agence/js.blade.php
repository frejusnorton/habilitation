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
            var url = "{{ route('app_agence_index') }}";

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

</script>