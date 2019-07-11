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


{{--<script src='{{ asset('calendar/fullcalendar.js')}}'></script>
<script src='{{ asset('calendar/scheduler.js')}}'></script>
<script src="{{ asset('calendar/jquery-ui.js')}}"></script>--}}



<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.7.1/fullcalendar.min.js"></script>
{{--<script src='http://fullcalendar.io/js/fullcalendar-2.7.1/fullcalendar.js'></script>--}}
{{--<script src='http://fullcalendar.io/js/fullcalendar-scheduler-1.3.1/scheduler.js'></script>--}}
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
@toastr_js
@toastr_render
<style>
    .dropzone {
        max-height: 100px !important;
        border: dashed 3px #B4B4B4;
        /*background-color: lightblue;*/
    }
</style>