<div class=" mt-3">
    <div class="card-header header-elements-inline bg-light p-2">
        <h5 class="card-title">Hotel Check In Rule</h5>
        <div class="header-elements">
            <!-- <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
            </div> -->
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="row m-0 my-2">
                    <strong class="mt-2">Check In Time:</strong>
                    <input ng-model="hrules_cin.check_in_limit"  type="text" class="form-control col-md-2 pickatime" name="check_in_limit">
                </div>
            </div> 
        </div>
            <div class="row">
                <div class="col-md-12">
                <table class="table-striped hover table-bordered w-100">
                    <thead>
                    <tr>
                        <th class="p-1">Start Time</th>
                        <th class="p-1">End Time</th>
                        <th class="p-1">Charges</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="hcin in hrules_cin track by $index">
                        <td class="p-1">
                            <input type="text" id="cin_start_time" name="cin_start_time" ng-model="hrules_cin[$index].start_time" class="form-control px-2 pickatime-startTime pickatime" placeholder="12:30 AM">
                        </td>
                        <td class="p-1">
                            <input type="text" id="cin_end_time" name="cin_end_time" ng-model="hrules_cin[$index].end_time" class="form-control px-2 pickatime-endTime pickatime" placeholder="12:30 AM">
                        </td>
                        <td class="p-1"><input type="text" currency data-type="currency" name="cin_charges" ng-model="hrules_cin[$index].charges" class="form-control px-2" placeholder="0.00"></td>
                        <td class="text-center"><i data-ng-click="removeCheckInRule($index)" class="btn btn-danger fa fa-minus"></i></td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td class="text-center">
                            <button ng-click="addMoreChekInrule()" class="btn btn-info"><i class="fa fa-plus"></i></button>
                        </td>
                    </tr>                    

                    
                    </tbody>
                </table>
                </div>
                
            </div>
    </div>

</div>
    