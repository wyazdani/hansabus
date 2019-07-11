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
@toastr_js
@toastr_render
<style>
    .dropzone {
        border: dashed 3px #B4B4B4;
    }
    .fc-time {

        letter-spacing: 1px !important;
        font-family: 'Montserrat', 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif !important;
        font-weight: 100 !important;
        line-height: 1.2em !important;
        color: #454545 !important;
    }
    .fc-title {

        letter-spacing: 1px !important;
        font-family: 'Montserrat', 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif !important;
        font-weight: 100 !important;
        line-height: 1.2em !important;
        color: #454545 !important;
    }
</style>