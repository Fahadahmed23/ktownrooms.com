@extends('layouts.app')

@section('scripts')
    <script src="app/defaultsetting-controller.js"></script> 
	<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.15/dist/summernote.min.css" rel="stylesheet">
	<script src="{{ asset_path('global_assets/js/plugins/editors/summernote/summernote.min.js') }}"></script>
@endsection



@section('content')

<style>
	.border-textarea{
		border: 1px solid #ddd !important;
	}
	.col-form-label{font-weight: 700}
	.font-w-500{font-weight:500}
	.txt-unln{text-decoration:underline}
	 .note-editor{
		width: 100%;
	}
	.note-editing-area{
		margin-top: 20px;
		padding: 5px;
	}
</style>

<div id="main-content" class="content" ng-controller='adminDefaultCtrl' ng-init='init()'>
    <div class="m-auto">
		@include('default_setting.form')
    </div>

	
    {{-- <div class="d-md-flex admin-panel-section align-items-md-start">
        <!-- Left sidebar component -->
        
        <!-- /left sidebar component -->
        <div class="flex-fill overflow-auto">
				<div class="card">
                
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Income Statement 
						</h5>
						<div class="header-elements">
							<div class="list-icons">
								<a class="list-icons-item" data-action="collapse"></a>
								<a class="list-icons-item" data-action="reload" ng-click="getLedger()"></a>
			
							</div>
						</div>
					</div>
					@include('default_setting.record')
				</div>
        </div>        
			
			
    </div> --}}
	
</div>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
			<script>
 
$(document).on('click', '.confirmBtn', function () { 
  $('#InsertTokenModal').modal('show');
  $('.portal_link').css('display', 'none');
  $('#module').val('confirm');
  
}) 
$(document).on('click', '.cancelBtn', function () { 
  $('#InsertTokenModal').modal('show');
  $('.portal_link').css('display', 'none');
  $('#module').val('cancel');
})
 
$(document).on('click', '.amendmentBtn', function () { 
  $('#InsertTokenModal').modal('show');
  $('.portal_link').css('display', 'none');
  $('#module').val('amendment');
  
})

$(document).on('click', '.checkoutBtn', function () { 
  $('#InsertTokenModal').modal('show');
  $('.portal_link').css('display', 'none');
  $('#module').val('checkout');
})
// $(document).on('click', function (event) {
$(document).on('click', '.checkinBtn', function () {
   
  $('#InsertTokenModal').modal('show');
  $('.portal_link').css('display', 'list-item');
  $('#module').val('checkin');
})

$(document).on('click', '.reminderBtn', function () {
   
   $('#InsertTokenModal').modal('show');
   $('.portal_link').css('display', 'list-item');
   $('#module').val('reminder');
 })
                 
                function disableEndTime(){
					$('.pickatime-disabled').val('');
                    var time = ( moment( $("#opening-time").val() ,"h:mm A").format("H:mm") ).split(":");
                    end_time.pickatime('picker').set('disable', [{ from: [0,0] , to: [ time[0], time[1] ] }] )
                   
                }

                var end_time = $('.pickatime-disabled').pickatime({});
                var TokenButton = function(context) {
					
					var ui = $.summernote.ui;
					// var class = context.$note.attr('class');
					var button = ui.button({
						className: context.$note.attr('class')+'Btn',
						contents: '<i class="icon-diamond"/> Insert Token',
						tooltip: 'Insert Token',
						// click: function() {
						// 	$('#InsertTokenModal').modal('show');
						// }
					});

					return button.render(); // return button as jquery object
				}
				
				
            </script>
@endsection