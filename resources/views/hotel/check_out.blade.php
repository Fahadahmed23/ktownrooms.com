<div class=" mt-3">
    <div class="card-header header-elements-inline bg-light p-2">
        <h5 class="card-title">Hotel Check Out Rule</h5>
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
                    <strong class="mt-2">Check Out Time:</strong>
                    <input ng-model="hrules_cout.check_out_limit"  type="text" class="form-control col-md-2 pickatime" name="check_out_limit">
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
                    <tr ng-repeat="hcout in hrules_cout track by $index">
                        <td class="p-1">
                            <input type="text" ng-model="hrules_cout[$index].start_time" class="form-control px-2 pickatime-startTimeout pickatime" placeholder="12:30 AM">
                        </td>
                        <td class="p-1">
                            <input type="text" ng-model="hrules_cout[$index].end_time" class="form-control px-2 pickatime-endTimeout pickatime" placeholder="12:30 AM">
                        </td>
                        <td class="p-1"><input type="text" currency data-type="currency" ng-model="hrules_cout[$index].charges" class="form-control px-2" placeholder="0.00"></td>
                        <td class="text-center"><i ng-click="removeCheckOutRule($index)" class="btn btn-danger fa fa-minus"></i></td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td class="text-center">
                            <button ng-click="addMoreChekOutrule()" class="btn btn-info"><i class="fa fa-plus"></i></button>
                        </td>
                    </tr>                    
                    </tbody>
                </table>
                </div>
                
        </div>
    </div>

</div>