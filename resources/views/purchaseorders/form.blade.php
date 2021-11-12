
<div id="addNewPurchaseOrder" class="card" style="display:none;">
    <div class="card-header bg-white header-elements-inline">
		  <h5 class="card-title" style="text-transform:capitalize;">[[room.id?'Update':'Add New']] Purchase Order</h5>
      <div class="header-elements">
        <div class="list-icons">
                  <a class="list-icons-item" data-action="collapse"></a>
          <a class="list-icons-item new-rec-close" ng-click="revert()"><i class="icon-cross2"></i></a>
        </div>
      </div>
	  </div>
        <form name="purchase_orderForm" id="purchase_orderForm" class="card-body" enctype="multipart/form-data" >
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
                    <div class="col-md-6"> 
                      <div class="form-group">
                        <label class="col-lg-6 col-form-label">Hotel</label>
                        <md-select md-no-asterisk name="hotel_id" class="m-0" ng-model="purchase_order.hotel_id" placeholder="Select a Hotel" required>
                          <md-option ng-repeat="hotel in hotels" ng-value="hotel.id">[[hotel.HotelName]]</md-option>
                        </md-select>

                        <div ng-messages="purchase_orderForm.hotel_id.$error" ng-if='purchase_orderForm.hotel_id.$touched || purchase_orderForm.$submitted' ng-cloak style="color:#e9322d;">
                          <div class="text-danger" ng-message="required">Hotel is required</div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-lg-6 col-form-label">Vendor</label>
                        <md-select asterisk name="vendor_id" class="m-0" ng-model="purchase_order.vendor_id" placeholder="Select a Vendor" required>
                          <md-option ng-repeat="vendor in vendors" ng-value="vendor.id">[[vendor.Name]]</md-option>
                        </md-select>
                        <div ng-messages="purchase_orderForm.vendor_id.$error" ng-if='purchase_orderForm.vendor_id.$touched || purchase_orderForm.$submitted' ng-cloak style="color:#e9322d;">
                          <div class="text-danger" ng-message="required">Vendor is required</div>
                        </div>
                      </div>
                    </div> 
                    <div class="col-md-6">  
                      <div class="form-group">
                        <label class="col-lg-6 col-form-label">Purchase Date</label>
                        <input ng-change="getPurchaseDate(purchase_order.purchase_date)" type="text" date placeholder="MM/DD/YYYY" class="form-control pickadate" ng-model="purchase_order.purchase_date" name="purchase_date" id="PurchaseDate" required>
                        <div ng-messages="purchase_orderForm.purchase_date.$error" ng-if='purchase_orderForm.purchase_date.$touched || purchase_orderForm.$submitted' ng-cloak style="color:#e9322d;">
                          <div class="text-danger" ng-message="required">Purchase Date is required</div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-lg-6 col-form-label">Status</label>
                        <md-select name="Status" class="m-0" ng-model="purchase_order.Status" placeholder="Approved" disabled>
                          <md-option value="Approved" ng-selected="true">Approved</md-option>
                        </md-select>
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
                Order Details
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

                        <tr ng-repeat="purchase_order in details track by $index" class="pro_row">
                          <td>
                            <md-select md-no-asterisk ng-change="getProDetail(purchase_order.inventory_id, $index)" name="inventory_id_[[$index]]" class="m-0" ng-model="purchase_order.inventory_id" placeholder="Select a Product" required>
                              <md-option ng-repeat="inventory in inventories" ng-value="inventory.id" >[[inventory.Title]]</md-option>
                            </md-select>
                            <div ng-messages="purchase_orderForm['inventory_id_' + $index].$error" ng-if="purchase_orderForm['inventory_id_' + $index].$touched || purchase_orderForm.$submitted" ng-cloak style="color:#e9322d;">
                              <div class="text-danger" ng-message="required">Inventory is required</div>
                            </div>

                          </td>
                          <td>
                            <textarea name="Description" ng-model="purchase_order.Description" class="form-control px-2 inv_Desc" rows="1" placeholder="Description" readonly></textarea>
                          </td>
                          <td>
                            <input ng-disabled="!purchase_order.inventory_id" type="text" number data-type="number_format" ng-change="calculateUnitPrice(purchase_order.Quantity,$index)" name="Quantity_[[$index]]" ng-model="purchase_order.Quantity" class="form-control num3 px-2 inv_Quantity" placeholder="1" required>
                         
                            <div ng-messages="purchase_orderForm['Quantity_' + $index].$error" ng-if="purchase_orderForm['Quantity_' + $index].$touched || purchase_orderForm.$submitted" ng-cloak style="color:#e9322d;">
                              <div class="text-danger" ng-message="required">Quantity is required</div>
                            </div>
                          </td>
                          <td>
                            <input type="text" currency data-type="currency" name="rate" ng-model="purchase_order.Rate" class="form-control px-2 inv_Rate" placeholder="1" readonly>
                          </td>
                          <td>
                            <input type="text" data-type="currency" currency name="total" ng-model="purchase_order.Total" class="form-control px-2 inv_Total" placeholder="1" readonly>
                          </td>
                        </tr>
                      </tbody>
                      <tfoot>
                        <tr class="text-right">
                          <th colspan="4">
                            Grand Total:
                          </th>
                          <th><input type="text" data-type="currency" currency name="gTotal" ng-model="purchase_order.gTotal" class="form-control px-2 inv_gTotal" placeholder="1" readonly></th>
                        </tr>
                        <tr class="text-right">
                          <th colspan="5">
                            <button disabled type="button" ng-click="addProduct()" id="add-more-product-btn" class="btn btn-sm bg-primary">Add Product<i class="icon-plus22 ml-1"></i></button>
                          </th>
                        </tr>
                      </tfoot>
                      
                    </table>
                  </div>
                  
                </div>
              </div>
            </fieldset>
          </div>

            
            <div class="text-right mt-2">
              <button  type="button" ng-click="savePurchaseOrder()" id="btn-save" class="btn btn-sm bg-success">[[purchase_order.id?'Update':'Save']]<i class="icon-floppy-disk ml-1"></i></button>
            </div>
        </form>

        
</div>

