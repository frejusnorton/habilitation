
<link rel="stylesheet" href="{{asset("assets/css/jquery-confirm.min.css")}}">
<script src="{{asset('assets/js/jquery-confirm.min.js')}}"></script>
<script>
    console.log('in')
    $(".dateRange").daterangepicker(
        {
            defaultDate: null,
            locale: {
                format: "DD/MM/YYYY"
            }
        }
    );

    //Fonction de recherche
    $('.filter').on('keyup', function(e) {
       // filter()
    });
    $('.filter').on('change', function(e) {
        filter()
    });

    function filter(){
        var user = $('#user').val();
        var search = $('#search').val();
        var periode = $('#periode').val();

        var url = "{{ route('app_activity_index') }}";

        $("#datatoload").html('<div class="col-xs-12 text-center" style="padding-top: 3em;">' +
            '<i class="fa fa-spin fa-spinner" style="color: lightgrey; font-size: 4em;;"></i>' +
            ' </div>'
        )
        window.ajaxControl = null;

        if (window.ajaxControl) {
            window.ajaxControl.abort()
        }
        ;

        if (ajaxControl) ajaxControl.abort();
        ajaxControl = $.ajax({
            url: url,
            data: {
                'user' : user,
                'search' : search,
                'periode' : periode,
                'filter': true
            },
            type: 'GET',
            success: function(data) {
                $("div#datatoload").html(data);
                $('[data-bs-toggle="tooltip"]').tooltip();
            },

        });
    }

</script>
