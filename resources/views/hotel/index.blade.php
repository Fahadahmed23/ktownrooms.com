@extends('layouts.app')

@section('scripts')
    <script src="app/hotel-controller.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.15/dist/summernote.min.css" rel="stylesheet">
	<script src="{{ asset_path('global_assets/js/plugins/editors/summernote/summernote.min.js') }}"></script>
@endsection

@section('content')

<div id="main-content" class="content" ng-controller='hotelCtrl' ng-init='init()'>
    <div class="m-auto">
        @permission('can-add-hotel')
        @include('hotel.countsboxes')
        @include('hotel.form')
        @include('hotel.hotel_contacts_form')
        @endpermission
    </div>
    <div class="d-md-flex admin-panel-section align-items-md-start">
         <!-- Left sidebar component -->
         @include('hotel.filter')
         <!-- /left sidebar component -->
        <div class="flex-fill">
            <div class="row">
                <div class="col-lg-12">
                    @permission('can-view-hotel')
                    @include('hotel.hotel_table')
                    @endpermission
                </div>
            </div>
        </div> 
    </div>   
</div>        

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script>
    $(document).on('click', '.confirmBtn', function () { 
        $('#InsertTokenModal').modal('show');
        $('.portal_link').css('display', 'list-item');
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
    $(document).on('click', '.checkinBtn', function () {
        $('#InsertTokenModal').modal('show');
        $('.portal_link').css('display', 'list-item');
        $('#module').val('checkin');
    })

    var TokenButton = function(context) {
        var ui = $.summernote.ui;
        var button = ui.button({
            className: context.$note.attr('class')+'Btn',
            contents: '<i class="icon-diamond"/> Insert Token',
            tooltip: 'Insert Token',
        });
        return button.render();
    }
</script>
@endsection