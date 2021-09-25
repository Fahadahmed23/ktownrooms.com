<div class="card mt-3">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Hotel Check Out Rule</h5>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card-header px-1 d-flex">
            <span class="card-title"> 
                <div class="col-md-12 d-flex">
                    <strong class="col-6 m-auto">Check Out Time:</strong>
                    <input ng-model="hotel.check_out_limit" type="text" class="form-control pickatime" name="check_out_limit">
                </div> 
                {{-- <strong>Check Out Time:</strong>
                <span>[[tConvert(default_rule.checkout_time)]]</span> --}}
            </span>
        </div>
        <fieldset class="py-2 px-2">
        <div class="row">
            <div class="col-md-12">
            <table class="table table-user table-striped hover display datatable-basic table-bordered">
                <thead>
                <tr>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Charges</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="hcout in check_out_rules track by $index">
                    <td>
                        <input type="time" ng-model="hotel.checkout[$index].start_time" class="form-control px-2 pickatime-startTimeout pickatime" placeholder="12:30 AM" ng-value="'[[hcout.start_time]]'">
                    </td>
                    <td>
                        <input type="time"  ng-model="hotel.checkout[$index].end_time" class="form-control px-2 pickatime-endTimeout pickatime" placeholder="12:30 AM" ng-value="'[[hcout.end_time]]'">
                    </td>
                    <td><input type="text" currency data-type="currency" ng-model="hotel.checkout[$index].charges" class="form-control px-2" placeholder="0.00" ng-value="[[hcout.charges]]"></td>
                    <td><i ng-click="removeCheckOutRule($index)" class="btn btn-danger fa fa-minus"></i></td>
                </tr>
                
                </tbody>
            </table>
            </div>
            
        </div>
        </fieldset>
      </div>
</div>