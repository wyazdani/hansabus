<!-- BEGIN JS-->
<script src='{{ asset('calendar/jquery.min.js')}}'></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/perfect-scrollbar.jquery.min.js') }}"></script>
<script src="{{ asset('js/prism.min.js') }}"></script>
<script src="{{ asset('js/jquery.matchHeight-min.js') }}"></script>
<script src="{{ asset('js/screenfull.min.js') }}"></script>
<script src="{{ asset('js/pace.min.js') }}"></script>
<script src="{{ asset('js/dropzone.min.js') }}"></script>
<script src="{{ asset('js/app-sidebar.js') }}"></script>
<script src="{{ asset('js/notification-sidebar.js') }}"></script>
<script src="{{ asset('calendar/jquery.dataTables.min.js') }}"></script>
<script src='{{ asset('calendar/moment.min.js')}}'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.7.1/fullcalendar.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-select.js') }}"></script>

<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>

@toastr_js
@toastr_render
<script>
    Dropzone.autoDiscover = false;
    $("#dpz-multiple-files").dropzone({   acceptedFiles: ".png, .jpg, .gif,.pdf" });

    $(document).ready(function () {
        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            let charCode = (evt.which) ? evt.which : evt.keyCode;
            if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                evt.preventDefault();
            } else {
                return true;
            }
        }
        $('.has_numeric').attr('min',1);
        $('body').on('keypress','.has_numeric',function () {
            var elem    =   $(this);
            elem.attr('min',1);
            isNumber();
        });
        $('body').on('input','.has_numeric',function () {
            var elem    =   $(this);
            elem.attr('min',1);
        });
        $('body').on('change','.has_numeric',function () {
            var elem    =   $(this);
            elem.attr('min',1);
        });
    });
    $( function() {

        $("#customer_search" ).autocomplete({
            source: function( request, response ) {
                $.ajax( {
                    url: "{{ url('/customer-list') }}?key=auto",
                    dataType: "json",
                    data: {
                        q: request.term
                    },
                    success: function( data ) {

                        console.log(data);
                        response( data.data);
                    }
                } );
            },
            minLength: 2,
            select: function( event, ui ) {
                $( "#customer_search" ).val(ui.item.value);
                $( "#customer_id" ).val(ui.item.id );
            }
        });
        $("#driver_search" ).autocomplete({
            source: function( request, response ) {
                $.ajax( {
                    url: "{{ url('/drivers-list') }}?key=auto",
                    dataType: "json",
                    data: {
                        q: request.term
                    },
                    success: function( data ) {
                        response( data.data);
                    }
                } );
            },
            minLength: 2,
            select: function( event, ui ) {
                $( "#driver_search" ).val(ui.item.value);
                $( "#driver_id" ).val(ui.item.id );
            }
        });
    } );
</script>