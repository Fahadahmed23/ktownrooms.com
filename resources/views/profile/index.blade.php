@extends('layouts.app')

@section('scripts')
    <script src="app/profile-controller.js"></script>
@endsection

@section('content')
<style>
    .fc-widget-content .fc-scroller {
    height: auto !important;
}
</style>
<div id="main-content" class="content" ng-controller='profileCtrl' ng-init='init()'>
    <div class="m-auto">
         @include('profile.profile-sidebar')
        @include('profile.form')
    </div>
    <div class="d-md-flex admin-panel-section align-items-md-start">
        <div class="flex-fill overflow-auto">
			
        </div>        
	</div>
	<script>
 
        $('.icon-pencil').click(function(){
            $('.basicInfo2').show('slow');
            $('.basicInfo1').hide('slow');
        })
        $('.icon-backspace2').click(function(){
            $('.basicInfo2').hide('slow');
            $('.basicInfo1').show('slow');
        })


    // Define element
    var leaveCalendarSlotsElement = document.querySelector('.fullcalendar-event-colors');
    var leaveCalendarSlotsInit = null;
    function loadLeavesInCalendar(slots, scope) {
        //alert(slots.length);
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
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,dayGridWeek,dayGridDay'
                    },
                    events: slots,
                    eventClick: function(info) {
                        console.log('Event: ' + info.event.title);
                    },
                });
            }
            leaveCalendarSlotsInit.render();
        }
    }
    </script>
@endsection