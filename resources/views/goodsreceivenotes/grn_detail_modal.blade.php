<!--grn detail modal-->
<style>
    .table-grn-detail td 
    {
    padding-top: 5px;
    padding-bottom: 5px;
    }
    </style>
    <div id="grnDetail" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-2">
                    <h5 class="modal-title">Goods Receive Note Detail</h5>
                    <button ng-click="hidegrnDetail()" type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                    <div class="card-body">
                        <div class="row bg-light py-3 po-modal-header">
                            <div class="col-md-6">
                                <div class="">
                                    <div class="mb-0">
                                        <h4 class="font-weight-semibold"> <span> <i class="icon-star-full2"></i></span> [[grn.GRN_Number]]</h4>
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
                                                  <strong class="d-block col-lg-12">[[grn.puchase_order.HotelName]]</strong>
                                                </div>
                          
                                                <div class="form-group">
                                                  <label class="col-lg-6 col-form-label pb-0">Vendor: </label>
                                                  <strong class="d-block col-lg-12">[[grn.puchase_order.VendorName]]</strong>
                                                </div>
                                            </div> 
                                            <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label class="col-lg-6 col-form-label pb-0 ">Invoice No: </label>
                                                    <strong class="d-block col-lg-12">[[grn.InvoiceNumber]]</strong>
                                                  </div>
                                                <div class="form-group">
                                                  <label class="col-lg-6 col-form-label pb-0 pt-0">Purchase Order Date: </label>
                                                  <strong class="d-block col-lg-12">[[grn.puchase_order.PurchaseOrderDate | date]]</strong>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-lg-6 col-form-label pb-0 pt-0">Received Date: </label>
                                                    <strong class="d-block col-lg-12">[[grn.GRN_Date | date]]</strong>
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
                                            <table class="table table-user table-striped hover display datatable-basic table-bordered table-grn-detail">
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
                                                    <tr ng-repeat="grnd in grn.grn_details">
                                                        <td>[[grnd.inventory.Title]]</td>
                                                        <td>[[grnd.Description]]</td>
                                                        <td>[[grnd.ReceivedQuantity]]</td>
                                                        <td class="text-right">[[grnd.Rate | currency ]]</td>
                                                        <td class="text-right">[[grnd.Total | currency]]</td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="text-right bg-light">
                                                        <th colspan="4">Grand Total:</th>
                                                        <th>[[grn.gTotal | currency]]</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
    
                            </fieldset>
                        </div>
                    </div>  
            </div>
        </div>
    </div>
    <!--/grn detail modal-->