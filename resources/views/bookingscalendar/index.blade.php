@extends('layouts.app')

@section('scripts')
    <script src="app/bookingscalendar-controller.js"></script>
@endsection

<style>
.booking-counts strong {
    font-size: 28px;
    margin: 0 5px 0 0 !important;
    /* font-style: italic; */
}
.booking-counts label {
    margin: 0;
    font-size: 12px;
}
.fc-button {
    background: #26c6da !important;
    color: #fff !important;
    margin: 0 !important;
}
.fc-toolbar h2 {
    font-weight: 600 !important;
    font-size: 22px !important;
    float: left !important;
    margin:0 !important;
    
}
.fc-today-button {
    text-transform: uppercase !important;
    font-weight: 500 !important;
    cursor: pointer !important;
    float: left !important;
    padding: 5px 10px !important;
}
.fc-view-container{
    margin-top: 15px;
}
</style>
@section('content')


<div class="content" ng-controller='bookingsCalendarCtrl' ng-init='init()'>
    <div class="m-auto">
        @include('bookingscalendar.event_bookings_modal')
    </div>
    <div class="d-md-flex admin-panel-section align-items-md-start">
        <div class="flex-fill overflow-auto">
            @include('bookingscalendar.calendar')
        </div>
    </div>    
</div>
<!-- calendar view script -->
<script>
     var currentMonthValue = moment().format("YYYY-MM");
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
                        left: 'prev',
                        center: 'title,today',
                        right: 'next'
                    },
                    events: slots,
                    eventClick: function(info) {
                        let start= moment(info.event.start).format('YYYY-MM-DD');
                        angular.element(document.querySelector('[ng-controller="bookingsCalendarCtrl"]')).scope().getBookings(start);
                    },

                    datesRender: function(info)
                    {
                        var nextMonthValue = moment(info.view.currentStart).format("YYYY-MM-DD");
                        if (currentMonthValue != nextMonthValue) {
                            currentMonthValue = nextMonthValue;
                            angular.element(document.querySelector('[ng-controller="bookingsCalendarCtrl"]')).scope().getMonthsData(nextMonthValue);
                        }

                    }
                });
            }
            bookingCalendarSlotsInit.render();
        }
    }
</script>
<!-- calendar view script -->

@endsection


