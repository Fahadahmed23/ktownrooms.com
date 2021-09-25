@extends('layouts.app')

@section('scripts')
    <script src="app/accountlookups-controller.js"></script>
@endsection


@section('content')


<div class="content" ng-controller='accountlookupsCtrl' ng-init='init()'>
    <div class="m-auto">
        @include('accountinglookups.modals/accountTypeModal')
        @include('accountinglookups.modals/accountSubTypeModal')
        @include('accountinglookups.modals/accountLevelModal')
        @include('accountinglookups.modals/voucherTypeModal')
        @include('accountinglookups.modals/accountSalesTaxModal')
    </div>
    <div class="d-md-flex admin-panel-section align-items-md-start">
        <!-- datatable component -->
        <div class="flex-fill">    
            @include('accountinglookups.cards')
        </div>
        <!-- /datatable component -->
    </div>    
</div>        
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

@endsection