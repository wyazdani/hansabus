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

<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>

@toastr_js
@toastr_render
<script>
    $(".searchable").select2({
        // placeholder: 'Select a country',
        // maximumSelectionSize: 6,
        // // width: 'resolve',
        // // theme: 'bootstrap',
    });
</script>
<style>
    .ChangedHeight{
        height: 200px!important;
    }
    .select2-container .select2-choice, .searchable{
        display: block!important;
        height: 46px!important;
        white-space: nowrap!important;
        line-height: 26px!important;
    }
    .errorStar{
        color: #FE3600;
        font-size: 18px;
    }
    .dropzone {
        border: dashed 3px #B4B4B4;
    }
    .fc-time {
        display:block;
        padding-left: 10px !important;
        letter-spacing: 1px !important;
        font-family: 'Montserrat', 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif !important;
        font-weight: 100 !important;
        font-size: 14px !important;
        line-height: 1.2em !important;
        color: black !important;
    }
    .fc-title {
        display: inline-block !important;
        padding: 0 0 10px 10px !important;
        letter-spacing: 1px !important;
        font-family: 'Montserrat', 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif !important;
        font-weight: 100 !important;
        font-size: 16px !important;
        line-height: 1.2em !important;
        color: black !important;
    }
</style>