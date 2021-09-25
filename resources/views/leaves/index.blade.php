@extends('layouts.app')

@section('scripts')
    <script src="app/leaves-controller.js"></script>
@endsection

@section('content')
<style>
.fc-widget-content .fc-scroller { height: auto !important;}   
.no-cursor{cursor: default;}
.leave_detail div {margin: 0px;line-height: 12px;}
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
<div id="main-content" class="content" ng-controller='leavesCtrl' ng-init='init()'>
    <div class="m-auto">
        @include('leaves.aprove_reject_leave_modal')
    </div>
    <div class="d-md-flex admin-panel-section align-items-md-start">
         <!-- Left sidebar component -->
         @include('leaves.filter')
         <!-- /left sidebar component -->
        <div class="flex-fill overflow-auto">	
            @include('leaves.calendar')
        </div>        
	</div>
	<script>

    // Define element
    var currentMonthValue = moment().format("YYYY-MM");
    var leaveCalendarSlotsElement = document.querySelector('.fullcalendar-event-colors');
    var leaveCalendarSlotsInit = null;
    function loadLeavesInCalendar(slots, scope) {
        if (typeof FullCalendar == 'undefined') {
            console.warn('Warning - Fullcalendar files are not loaded.');
            return;
        }
        // Initialize
        if (leaveCalendarSlotsElement) {
            if (leaveCalendarSlotsInit != null) {
                leaveCalendarSlotsInit.batchRendering(() => {
                    leaveCalendarSlotsInit.getEvents().forEach(event => event.remove());
                    slots.forEach(event => leaveCalendarSlotsInit.addEvent(event));
                });
            } else {
                leaveCalendarSlotsInit = new FullCalendar.Calendar(leaveCalendarSlotsElement, {
                    plugins: ['dayGrid', 'interaction'],
                    header: {
                        left: 'prev',
                        center: 'title,today',
                        right: 'next'
                    },
                    events: slots,
                    eventClick: function(info) {
                        let leave_id = info.event.id;
                        if (info.event.extendedProps.status == 'pending') {
                            angular.element(document.querySelector('[ng-controller="leavesCtrl"]')).scope().showApporveRejectModal(leave_id);
                         }
                    },

                    datesRender: function(info)
                    {
                        var nextMonthValue = moment(info.view.currentStart).format("YYYY-MM-DD");
                        if (currentMonthValue != nextMonthValue) {
                            currentMonthValue = nextMonthValue;
                            angular.element(document.querySelector('[ng-controller="leavesCtrl"]')).scope().getMonthsData(nextMonthValue);
                        }

                    }
                });
            }
            leaveCalendarSlotsInit.render();
        }
    }
    </script>
@endsection