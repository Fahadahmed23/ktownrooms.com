@extends('layouts.app')

@section('scripts')
    <script src="app/bookings-controller.js"></script>
    <script src="app/housekeeping-controller.js"></script>
@endsection


@section('content')


<div class="content" ng-controller='bookinglistcltr' ng-init='init()'>
    <div class="m-auto">
        @include('Customer-Booking-modal')


    </div>

</div>



<!-- calendar view script -->
{{-- <script>

    // Define element
    var bookingCalendarSlotsElement = document.querySelector('.fullcalendar-event-colors');
    var bookingCalendarSlotsInit = null;
    function loadBookingsInCalendar(slots, scope) {
        //alert(slots.length);
        if (typeof FullCalendar == 'undefined') {
            console.warn('Warning - Fullcalendar files are not loaded.');
            return;
        }
        // Initialize
        if (bookingCalendarSlotsElement) {
            if (bookingCalendarSlotsInit != null) {
                bookingCalendarSlotsInit.batchRendering(() => {
                    bookingCalendarSlotsInit.getEvents().forEach(event => event.remove());
                    slots.forEach(event => bookingCalendarSlotsInit.addEvent(event));
                });
            } else {
                bookingCalendarSlotsInit = new FullCalendar.Calendar(bookingCalendarSlotsElement, {
                    plugins: ['dayGrid', 'interaction'],
                    header: {
                        left: 'prev,next',
                        center: 'title',
                        right: 'today'
                    },
                    events: slots,
                    eventClick: function(info) {
                        let booking_id = info.event.id;
                        // if (info.event.extendedProps.status == 'pending') {
                            angular.element(document.querySelector('[ng-controller="bookingsCtrl"]')).scope().showCalendarBookingDetail(booking_id);
                        //  }
                    },
                });
            }
            bookingCalendarSlotsInit.render();
        }
    }
</script> --}}
<!-- calendar view script -->
@endsection


