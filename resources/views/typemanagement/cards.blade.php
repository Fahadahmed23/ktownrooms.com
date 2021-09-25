
<style>
.icnbx {
    width: 20%;
    float: left;
    text-align: right;
}
.lblbx {
    width: 80%;
    float: left;
}
.frm {
    width: 100%;
    float: left;
}
.frm input.form-control {
    width: 70%;
    float: left;
  
}
.list {
    height: 220px;
    overflow: auto;
}
.validation-invalid-label {
    float: left;
}
.formactionbtnspan {
    width: 30%;
    float: right;
    text-align: right;
}
.formactionbtnspan button {
    border: none;
    padding: 10px;
}
</style>
<div class="cardsmain card p-3">
    <div class="row">
        <div class="col-md-3">
            <!-- Channels -->
            <div class="card">
                <div class="card-header bg-transparent header-elements-inline">
                    <span class="card-title font-weight-semibold">Channels</span>
                    <div class="header-elements">
                        <span class="badge bg-info badge-pill">[[channels.length]]</span>
                        <a class="list-icons-item ml-1" data-action="collapse"></a>
                    </div>
                </div>

                <div class="list-group list-group-flush">
                    <div class="list">
                        <a ng-repeat="channel in channels" class="list-group-item list-group-item-action legitRipple">
                            <div class="lblbx"><i class="fa fa-angle-right mr-3 fa-1x"></i>[[channel.Channel]]</div>
                            <div class="icnbx">
                            <span  ng-click="deleteChannel(channel)" class="badge bg-danger icn"><i class="fa fa-trash" style="color: white"></i></span>
                            <span  ng-click="editChannel(channel)" class="badge bg-success icn"><i class="fa fa-pencil" style="color: white"></i></span>
                            </div>
                        </a>
                    </div>    
                    <a class="list-group-item list-group-item-action legitRipple" ng-click="addChannel()">
                        <i class="fa fa-plus mr-3"></i>
                        <strong>Add Channel</strong>
                    </a>
                </div>
            </div>
            <!-- /Contact Type -->
        </div>

        <div class="col-md-3">
            <!-- Services -->
            <div class="card">
                <div class="card-header bg-transparent header-elements-inline">
                    <span class="card-title font-weight-semibold">Service Types</span>
                    <div class="header-elements">
                        <span class="badge bg-info badge-pill">[[servicetypes.length]]</span>
                        <a class="list-icons-item ml-1" data-action="collapse"></a>
                    </div>
                </div>

                <div class="list-group list-group-flush">
                    <div class="list">
                        <a ng-repeat="servicetype in servicetypes" class="list-group-item list-group-item-action legitRipple">
                            <div class="lblbx"><i class="fa fa-angle-right mr-3 fa-1x"></i>[[servicetype.ServiceType]]</div>
                            <div class="icnbx">
                            <span  ng-click="deleteSType(servicetype)" class="badge bg-danger icn"><i class="fa fa-trash" style="color: white"></i></span>
                            <span  ng-click="editSType(servicetype)" class="badge bg-success icn"><i class="fa fa-pencil" style="color: white"></i></span>
                            </div>
                        </a>
                    </div>    
                    <div id="sTypeAdd" class="list-group-item" style="display: none;">
                       <form id="STypeForm" class="form-validate-jquery frm" confirm-on-exit ng-submit="saveSType()"> 
                            <input required ng-model="servicetype.ServiceType" type="text" class="form-control alphabets" maxlength="15" placeholder="Enter Service Type"> 
                            <span class="formactionbtnspan">
                                <button type="submit" class="badge bg-success formactionbtn "><i class="fa fa-save" style="color: white"></i></button>
                                <button type="button" ng-click="closeStypebtn()" class="badge bg-danger formactionbtn"><i class="fa fa-close" style="color: white"></i></button>
                            </span>
                        </form>
                    </div>
                    <a class="list-group-item list-group-item-action legitRipple" ng-click="addSType()">
                        <i class="fa fa-plus mr-3"></i>
                        <strong>Add Service Type</strong>
                    </a>
                </div>
            </div>
            <!-- /Services -->
        </div>

        <div class="col-md-3">
            <!-- Rooms -->
            <div class="card">
                <div class="card-header bg-transparent header-elements-inline">
                    <span class="card-title font-weight-semibold">Room Types</span>
                    <div class="header-elements">
                        <span class="badge bg-info badge-pill">[[roomtypes.length]]</span>
                        <a class="list-icons-item ml-1" data-action="collapse"></a>
                    </div>
                </div>

                <div class="list-group list-group-flush">
                    <div class="list">
                        <a ng-repeat="roomtype in roomtypes" class="list-group-item list-group-item-action legitRipple">
                            <div class="lblbx"><i class="fa fa-angle-right mr-3 fa-1x"></i>[[roomtype.RoomType]]</div>
                            <div class="icnbx">
                            <span  ng-click="deleteRType(roomtype)" class="badge bg-danger icn"><i class="fa fa-trash" style="color: white"></i></span>
                            <span  ng-click="editRType(roomtype)" class="badge bg-success icn"><i class="fa fa-pencil" style="color: white"></i></span>
                            </div>
                        </a>
                    </div>  
                    <div id="rTypeAdd" class=" list-group-item" style="display: none;">
                       <form id="RTypeForm" class="form-validate-jquery frm" confirm-on-exit ng-submit="saveRType()"> 
                            <input required ng-model="roomtype.RoomType" type="text" class="form-control alphabets" maxlength="15" placeholder="Enter Room Type"> 
                            <span class="formactionbtnspan">
                                <button type="submit" class="badge bg-success formactionbtn "><i class="fa fa-save" style="color: white"></i></button>
                                <button type="button" ng-click="closeRtypebtn()" class="badge bg-danger formactionbtn"><i class="fa fa-close" style="color: white"></i></button>
                            </span>
                        </form>
                    </div>
                    <a class="list-group-item list-group-item-action legitRipple" ng-click="addRType()">
                        <i class="fa fa-plus mr-3"></i>
                        <strong>Add Room Type</strong>
                    </a>
                </div>
            </div>
            <!-- /Rooms -->
        </div>

        <div class="col-md-3">
            <!-- Relations -->
            <div class="card">
                <div class="card-header bg-transparent header-elements-inline">
                    <span class="card-title font-weight-semibold">Relations</span>
                    <div class="header-elements">
                        <span class="badge bg-info badge-pill">[[relations.length]]</span>
                        <a class="list-icons-item ml-1" data-action="collapse"></a>
                    </div>
                </div>

                <div class="list-group list-group-flush">
                    <div class="list">
                        <a ng-repeat="relation in relations" class="list-group-item list-group-item-action legitRipple">
                            <div class="lblbx"><i class="fa fa-angle-right mr-3 fa-1x"></i>[[relation.Relation]]</div>
                            <div class="icnbx">
                            <span  ng-click="deleteRel(relation)" class="badge bg-danger icn"><i class="fa fa-trash" style="color: white"></i></span>
                            <span  ng-click="editRel(relation)" class="badge bg-success icn"><i class="fa fa-pencil" style="color: white"></i></span>
                            </div>
                        </a>
                    </div>    
                    <div id="relAdd" class=" list-group-item" style="display: none;">
                       <form id="RelForm" class="form-validate-jquery frm" confirm-on-exit ng-submit="saveRel()"> 
                            <input required ng-model="relation.Relation" aria-invalid="true" name="Relation" type="text" class="form-control alphabets" maxlength="15" placeholder="Enter Relation"> 
                            <span class="formactionbtnspan">
                                <button type="submit" class="badge bg-success formactionbtn "><i class="fa fa-save" style="color: white"></i></button>
                                <button type="button" ng-click="closeRelbtn()" class="badge bg-danger formactionbtn"><i class="fa fa-close" style="color: white"></i></button>
                            </span>
                        </form>
                    </div>
                    <a class="list-group-item list-group-item-action legitRipple" ng-click="addRel()">
                        <i class="fa fa-plus mr-3"></i>
                        <strong>Add Relation</strong>
                    </a>
                </div>
            </div>
            <!-- /Relations -->
        </div>


        <div class="col-md-3">
            <!-- Relations -->
            <div class="card">
                <div class="card-header bg-transparent header-elements-inline">
                    <span class="card-title font-weight-semibold">Tax Rates</span>
                    <div class="header-elements">
                        <span class="badge bg-info badge-pill">[[taxrates.length]]</span>
                        <a class="list-icons-item ml-1" data-action="collapse"></a>
                    </div>
                </div>

                <div class="list-group list-group-flush">
                    <div class="list">
                        <a ng-repeat="taxrate in taxrates" class="list-group-item list-group-item-action legitRipple">
                            <div class="lblbx"><i class="fa fa-angle-right mr-3 fa-1x"></i>[[taxrate.Tax]]</div>
                            <div class="icnbx">
                            <span  ng-click="deleteTaxRate(taxrate)" class="badge bg-danger icn"><i class="fa fa-trash" style="color: white"></i></span>
                            <span  ng-click="editTaxRate(taxrate)" class="badge bg-success icn"><i class="fa fa-pencil" style="color: white"></i></span>
                            </div>
                        </a>
                    </div>    
                    <a class="list-group-item list-group-item-action legitRipple" ng-click="addTaxRate()">
                        <i class="fa fa-plus mr-3"></i>
                        <strong>Add Tax Rate</strong>
                    </a>
                </div>
            </div>
            <!-- /Relations -->
        </div>
       
    </div>
</div>


