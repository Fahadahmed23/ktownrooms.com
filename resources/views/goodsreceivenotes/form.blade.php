
<div id="addNewGoodReceiveNote" class="card" style="display:none;">
    <div class="card-header bg-white header-elements-inline">
		  <h5 class="card-title" style="text-transform:capitalize;">[[goods_receive_note.id?'Update':'Add New']] Goods Receive Notes</h5>
      <div class="header-elements">
        <div class="list-icons">
                  <a class="list-icons-item" data-action="collapse"></a>
          <a class="list-icons-item new-rec-close" ng-click="revert()"><i class="icon-cross2"></i></a>
        </div>
      </div>
	  </div>
        {{-- @include('layouts.form_messages') --}}
        <form name="good_receive_noteForm" id="good_receive_noteForm" class="card-body" enctype="multipart/form-data" >
          <div class="col-md-6">
            <div class="py-2 px-2">
              <fieldset>
                <legend class="font-weight-semibold text-uppercase font-size-sm">
                  <i class="icon-city mr-2"></i>
                  Purchase order information
                  <a href="#" class="float-right text-default collapsed" data-toggle="collapse" data-target="#demo1" aria-expanded="false">
                    <i class="icon-circle-down2"></i>
                  </a>
                </legend>
                <div class="collapse show" id="demo1" style="">
                  <div class="row row m-0 p-2 bg-light">
                    <div  ng-hide="!is_admin" class="col-md-6"> 
                      <div class="form-group">
                        <label class="col-lg-6 col-form-label">Hotels</label>
                        <md-select asterisk name="hotel_id" class="m-0" ng-change="getHotel(good_receive_note.hotel_id)" ng-model="good_receive_note.hotel_id" ng-change="getPurchaseOrderDetails(good_receive_note.hotel_id)" placeholder="Select Hotel" required>
                          <md-option ng-repeat="h in hotels" ng-value="h.id">[[h.HotelName]]</md-option>
                        </md-select>
                        <div ng-messages="good_receive_noteForm.hotel_id.$error" ng-if='good_receive_noteForm.hotel_id.$touched || good_receive_noteForm.$submitted' ng-cloak style="color:#e9322d;">
                          <div class="text-danger" ng-message="required">Hotel is required</div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6"> 
                      <div class="form-group">
                        <label class="col-lg-6 col-form-label">Purchase Order</label>
                        <md-select asterisk name="PurchaseOrderId" class="m-0" ng-model="good_receive_note.purchase_order_id" ng-change="getPurchaseOrderDetails(good_receive_note.purchase_order_id)" placeholder="Select a Purchase Order" required>
                          <md-option ng-repeat="purchase_order in purchase_orders" ng-value="purchase_order.id">[[purchase_order.PurchaseOrderNumber]]</md-option>
                        </md-select>
                        <div ng-messages="good_receive_noteForm.PurchaseOrderId.$error" ng-if='good_receive_noteForm.PurchaseOrderId.$touched || good_receive_noteForm.$submitted' ng-cloak style="color:#e9322d;">
                          <div class="text-danger" ng-message="required">Purchase Order Number is required</div>
                        </div>
                      </div>
                    </div>
                    
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-lg-6 col-form-label">Invoice No.</label>
                        <input type="text" name="InvoiceNumber" ng-model="good_receive_note.InvoiceNumber" class="form-control px-2 num3" placeholder="001" required>

                        <div ng-messages="good_receive_noteForm.InvoiceNumber.$error" ng-if='good_receive_noteForm.InvoiceNumber.$touched || good_receive_noteForm.$submitted' ng-cloak style="color:#e9322d;">
                          <div class="text-danger" ng-message="required">Invoice Number is required</div>
                        </div>
                      </div>

                    </div> 
                    <div class="col-md-6">  
                      <div class="form-group">
                        <label class="col-lg-6 col-form-label">Received Date</label>
                        <input type="text" date placeholder="MM/DD/YYYY" class="form-control pickadate" ng-model="good_receive_note.GRN_Date" name="ReceivedDate" id="ReceivedDate" required>
                        <div ng-messages="good_receive_noteForm.ReceivedDate.$error" ng-if='good_receive_noteForm.ReceivedDate.$touched || good_receive_noteForm.$submitted' ng-cloak style="color:#e9322d;">
                          <div class="text-danger" ng-message="required">Received Date is required</div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">  
                      <div class="form-group">
                        <label class="col-lg-6 col-form-label">Status</label>
                        <md-select asterisk name="Status" class="m-0" ng-model="good_receive_note.Status" placeholder="Pending" required>
                          <md-option value="Pending">Pending</md-option>
                          <md-option value="Approved">Approved</md-option>
                          <md-option value="Rejected">Rejected</md-option>
                        </md-select>

                        <div ng-messages="good_receive_noteForm.Status.$error" ng-if='good_receive_noteForm.Status.$touched || good_receive_noteForm.$submitted' ng-cloak style="color:#e9322d;">
                          <div class="text-danger" ng-message="required">Status is required</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </fieldset>
            </div>
          </div>

          <div class="col-md-6">
            <fieldset class="py-2 px-2">
              <legend class="font-weight-semibold text-uppercase font-size-sm mb-0 bg-light p-2">
                <i class="icon-grid7 mr-2"></i>
                Purchase Order Details
                <a href="#" class="float-right text-default collapsed" data-toggle="collapse" data-target="#demo2" aria-expanded="false">
                  <i class="icon-circle-down2"></i>
                </a>
              </legend>

              <div class="collapse" id="demo2" style="">
                <div class="row">
                  <div class="col-md-12">
                    <table class="table table-user table-striped hover display datatable-basic table-bordered">
                      <thead>
                        <tr>
                          <td>Name</td>
                          <td>Description</td>
                          <td>Quantitty</td>
                          <td>Unit Price</td>
                          <td>Total</td>
                        </tr>
                      </thead>
                      <tbody>

                        <tr ng-repeat="po in products track by $index">
                          <td>
                            <md-select readonly disabled name="InventoryId" class="m-0" ng-model="po.inventory_id" placeholder="Select a Product" required>
                              <md-option ng-repeat="inventory in inventories" ng-value="inventory.id" >[[inventory.Title]]</md-option>
                            </md-select>
                          </td>
                          <td>
                            <textarea name="Description" ng-model="po.Description" class="form-control px-2" rows="1" placeholder="Description" readonly></textarea>
                          </td>
                          <td>
                            <input type="text" ng-change="calculateUnitPrice(po.Quantity,$index)" ng-pattern="/^[0-9]*$/" name="quantity" ng-model="po.Quantity" class="form-control px-2 num3" placeholder="1" required>
                          </td>
                          <td>
                            <input type="text" currency data-type="currency" name="rate" ng-model="po.Rate" class="form-control px-2" placeholder="1" readonly >
                          </td>
                          <td>
                            <input type="text" currency data-type="currency" name="total" ng-model="po.Total" class="form-control px-2" placeholder="1" readonly >
                          </td>
                        </tr>
                      </tbody>
                      <tfoot>
                        <tr class="text-right">
                          <th colspan="4">
                            Grand Total:
                          </th>
                          <th><input type="text" data-type="currency" currency name="gTotal" ng-model="good_receive_note.gTotal" class="form-control px-2 inv_gTotal" placeholder="1" readonly></th>
                        </tr>
                      </tfoot>
                      
                    </table>
                  </div>
                  
                </div>
              </div>
            </fieldset>
          </div>

           
            <div class="text-right mt-2">
              <button  type="button" ng-click="saveGoodRecieve()" id="btn-save" class="btn btn-sm bg-success"><i class="icon-floppy-disk mr-1"></i> [[good_receive_note.id?'Update':'Save']]</button>
            </div>
        </form>

        
</div>

