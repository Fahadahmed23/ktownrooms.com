<!--po detail modal-->
<style>
.table-order-detail td 
{
padding-top: 5px;
padding-bottom: 5px;
}
</style>
<div id="poDetail" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header p-2">
				<h5 class="modal-title">Purchase Order Detail</h5>
				<button ng-click="hidepoDetail()" type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
                <div class="card-body">
                    <div class="row bg-light py-3 po-modal-header">
                        <div class="col-md-6">
                            <div class="">
                                <div class="mb-0">
                                    <h4 class="font-weight-semibold"> <span> <i class="icon-star-full2"></i></span> [[pod.PurchaseOrderNumber]]</h4>
                                </div>
                            </div>
                        </div> 
                    </div>

                    <div class="row po-info-sec pt-2">
                        <fieldset class="w-100">
                            <legend class="font-weight-semibold text-uppercase font-size-sm mb-0 bg-light p-2">
                              <i class="icon-clipboard3 mr-2"></i>
                                Order Information
                              <a href="#" class="float-right text-default collapsed" data-toggle="collapse" data-target="#demo1" aria-expanded="false">
                                <i class="icon-circle-down2"></i>
                              </a>
                            </legend>
                            <div class="collapse show" id="demo1" style="">
                                <div class="po-info">
                                    <div class="row m-0" style="background: #eaeaea8c;">
                                        <div class="col-md-6"> 
                                            <div class="form-group">
                                              <label class="col-lg-6 col-form-label pb-0">Hotel: </label>
                                              <strong class="d-block col-lg-12">[[pod.HotelName]]</strong>
                                            </div>
                      
                                            <div class="form-group">
                                              <label class="col-lg-6 col-form-label pb-0">Vendor: </label>
                                              <strong class="d-block col-lg-12">[[pod.VendorName]]</strong>
                                            </div>
                                        </div> 
                                        <div class="col-md-6"> 
                                            <div class="form-group">
                                              <label class="col-lg-6 col-form-label pb-0">Purchase Order Date: </label>
                                              <strong class="d-block col-lg-12">[[pod.PurchaseOrderDate | date]]</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    </div>

                    <div class="row products-table-sec pt-2">
                        <fieldset class="w-100">
                            <legend class="font-weight-semibold text-uppercase font-size-sm mb-0 bg-light p-2">
                              <i class="icon-clipboard3 mr-2"></i>
                              Order Details
                              <a href="#" class="float-right text-default collapsed" data-toggle="collapse" data-target="#demo2" aria-expanded="false">
                                <i class="icon-circle-down2"></i>
                              </a>
                            </legend>

                            <div class="collapse show" id="demo2" style="">
                                <div class="">
                                    <div class="itemtable">
                                        <table class="table table-user table-striped hover display datatable-basic table-bordered table-order-detail">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Description</th>
                                                    <th>Quantity</th>
                                                    <th class="text-right">Rate</th>
                                                    <th class="text-right">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="p in pod.details">
                                                    <td>[[p.inventory.Title]]</td>
                                                    <td>[[p.Description]]</td>
                                                    <td>[[p.Quantity]]</td>
                                                    <td class="text-right">[[p.Rate | currency ]]</td>
                                                    <td class="text-right">[[p.Total | currency]]</td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr class="text-right bg-light">
                                                    <th colspan="4">Grand Total:</th>
                                                    <th>[[pod.gTotal | currency]]</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </fieldset>
                    </div>

                    <div ng-if="pod.Status == 'Pending'" class="row p-2 bg-light">
                        <div class="text-right float-right w-100 d-block">
                            <a href="{{url('/goods_receive_notes')}}" target="_blank" type="button" class="btn btn-info">Receive Goods <i class="ml-1 icon-arrow-right7"></i></a>
                        </div>
                    </div>

                </div>  
		</div>
	</div>
</div>
<!--/Customer Card-->