
    <div id="countBboxModal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xs modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-2 border-bottom">
                    <h6 class="modal-title">How many would you like to add in [[roomcategoryname]]?</h6>
                    <button type="button" class="close" ng-click="hideCountBboxModal()">&times;</button>
                </div>
                
                <form name="RoomCountForm" id="RoomCountForm">
                    <div class="modal-body">
                        <div class="row">
                                <strong for="" class="col-md-3 mt-2">Count:</strong>
                                <input  class="col-md-9 form-control" type="number" min="1" max="100" ng-model="count" >
                        </div>
                    </div>
                    <div class="modal-footer border-top bg-light p-2">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <small><button type="button" ng-click="addRooms()" class="btn btn-success btn-sm">Add Rooms<i class="icon-check2 ml-1"></i></button></small>
                            </div>
                        </div>
                    </div>  
                </form>    
            </div>
        </div>
    </div>