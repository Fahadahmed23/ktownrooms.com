<div id="addNewPromotion" class="card" style="display: none">
    <div class="card-header bg-white header-elements-inline">
		<h5 class="card-title" style="text-transform:capitalize;">[[promotion.id?'Update':'Add New']] Promotion</h5>
		<div class="header-elements">
			<div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
				<a class="list-icons-item new-rec-close" ng-click="revert()"><i class="icon-cross2"></i></a>
			</div>
		</div>
	</div>
        @include('layouts.form_messages')
        <form name="promotionForm" id="promotionForm" class="card-body">
            <div class="form-group row">
                <div class="col-md-3">        
                 <label class="col-lg-6 col-form-label">Promotion Title <span class="text-danger">*</span></label>
                 <input required name="promotionName" id="promotionName" type="text" maxlength="50" class="form-control " ng-model="promotion.PromoName" placeholder="Enter Promotion">
                
                <div ng-messages="promotionForm.promotionName.$error" ng-if='promotionForm.promotionName.$touched || promotionForm.$submitted' ng-cloak style="color:#e9322d;">
                    <div class="text-danger" ng-message="required">Promotion Title is required</div>
                </div>

                </div>
               
                <div class="col-md-3">        
                 <label class="col-lg-6 col-form-label">Promotion Code <span class="text-danger">*</span></label>
                 <input id="promoCode" required name="Code" type="text" maxlength="25" class="form-control" ng-model="promotion.Code" placeholder="Enter Promotion Code">
                    
                <div ng-messages="promotionForm.Code.$error" ng-if='promotionForm.Code.$touched || promotionForm.$submitted' ng-cloak style="color:#e9322d;">
                    <div class="text-danger" ng-message="required">Promotion Code is required</div>
                </div>

                </div>

              
                <div class="col-md-6">
                    <fieldset class="">
                        <legend class="font-weight-semibold text-uppercase font-size-sm border-0 mb-0">
                            <i class="fa fa-calender mr-2"></i>
                            Validity
                        </legend> 
                        <div class="col-md-6 float-left">
                            <label class="">From <span class="required">*</span></label>
                            <div class="input-group">
                                <span class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-calendar"></i></span>
                                </span>
                                <input ng-change="checkfromdate(promotion.ValidFrom)" required name="ValidFrom" type="text" placeholder="MM/DD/YYYY" id="ValidFrom"  ng-model="promotion.ValidFrom" class="form-control pickadate">
                                <input type="hidden" id="hdnValidFrom">

                                
                            </div>
                            <div ng-messages="promotionForm.ValidFrom.$error" ng-if='promotionForm.ValidFrom.$touched || promotionForm.$submitted' ng-cloak style="color:#e9322d;">
                                <div class="text-danger" ng-message="required">From Date is required</div>
                            </div>
                        </div>

                        <div class="col-md-6 float-left">
                            <label class=""> To <span class="required">*</span></label>
                            <div class="input-group">
                                <span class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-calendar"></i></span>
                                </span>
                                <input ng-change="checktodate(promotion.ValidTo)" required  name="ValidTo" type="text" placeholder="MM/DD/YYYY" id="ValidTo"  ng-model="promotion.ValidTo" class="form-control pickadate">
                                <input type="hidden" id="hdnValidTo">

                                
                            </div>
                            <div ng-messages="promotionForm.ValidTo.$error" ng-if='promotionForm.ValidTo.$touched || promotionForm.$submitted' ng-cloak style="color:#e9322d;">
                                <div class="text-danger" ng-message="required">To Date is required</div>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <div class="col-md-3">        
                    <label class="col-lg-6 col-form-label">Discount Value <span class="text-danger">*</span></label>
                    <input id="discountValue" data-type="currency" maxlength="4"  required name="DiscountValue" type="text" class="form-control px-2 discountValInput" ng-model="promotion.DiscountValue" placeholder="Enter Discount">
                    <input id="discountValue" maxlength="4" required name="DiscountValue" type="text" class="form-control px-2 percentInput percent" ng-model="promotion.DiscountValue" placeholder="Enter Discount" style="display: none;">
                   
                    <div ng-messages="promotionForm.DiscountValue.$error" ng-if='promotionForm.DiscountValue.$touched || promotionForm.$submitted' ng-cloak style="color:#e9322d;">
                        <div class="text-danger" ng-message="required">Discount Value is required</div>
                    </div>
                </div>

                <div class="col-md-3">
                    <label class="col-lg-6 col-form-label">Is Percentage</label>
                    <md-switch ng-change="applypercent(promotion.IsPercentage)" ng-model="promotion.IsPercentage" ng-true-value="1" ng-false-value="0" style="display:block"></md-switch>
                  </div>
   
                   
            

            </div>
            
            <div class="text-right">
			<button type="button" ng-click="savePromotion()" id="btn-save"  class="btn btn-sm bg-success"><i class="icon-floppy-disk mr-1"></i> [[promotion.id?'Update':'Save']]</button>
			</div>
        </form>
</div>


<script>

$(".pickadate").pickadate({
    min: true
        });
// $.extend($.fn.pickadate.defaults, {
//             formatSubmit: 'yyyy-mm-dd',
//             format: 'dd/mm/yyyy',
//             hiddenName: true,
//             hiddenSuffix: '_submit',
//         })

</script>