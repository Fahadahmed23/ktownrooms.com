@extends('layouts.app')

@section('scripts')
    <script src="app/bookings-controller.js"></script>
    <script src="app/housekeeping-controller.js"></script>
@endsection


@section('content')


<div class="content" ng-controller='bookingsCtrl' ng-init='init()'>
    <div class="m-auto">
        @include('bookings.search')
        @include('bookings.rooms')
        @include('bookings.form')
        @include('bookings.invoice')
        @include('bookings.invoice_new')
        @include('bookings.show_customer_list')
        @include('bookings.addOccupantsModal')
        @include('bookings.add_partial_pay')
        @include('bookings.add_misc_amount')
        {{-- @include('bookings.add_staging_pay') --}}
        @include('bookings.addBulkOccupants')
        @include('bookings.checkout_extend_modal')
        @include('bookings.send_message_modal')

        @include('bookings.customer_modal')
        @include('bookings.stays_modal')
        @include('bookings.status_change_modal')
        {{-- @include('bookings.booking_detail_calendar_modal') --}}
    </div>
    <div class="d-md-flex admin-panel-section align-items-md-start">
        <!-- Left sidebar component -->
        @include('bookings.filter')
        <!-- /left sidebar component -->
        <!-- datatable component -->
        {{-- <div class="flex-fill overflow-auto"> --}}

        <div class="flex-fill overflow-auto">
            {{--right booking detail box --}}
            @include('bookings.bookdetailRBox')
            {{--right booking detail box --}}

            @include('bookings.table')

        </div>
        <!-- /datatable component -->

    </div>
</div>
<div ng-controller="housekeepingCtrl">
    @include('housekeeping.services')
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


