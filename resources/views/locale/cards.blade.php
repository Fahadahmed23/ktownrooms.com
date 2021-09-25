
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
    
            <div class="col-md-4">
                <!-- countries -->
                <div class="card">
                    <div class="card-header bg-transparent header-elements-inline">
                        <span class="card-title font-weight-semibold">Countries</span>
                        <input type="text" ng-model="searchCountry" class="srch form-control form-control-lg alpha-grey col-md-8" placeholder="Search">
                        <div class="header-elements">
                            <span class="badge bg-info badge-pill">[[countries.length]]</span>
                            <a class="list-icons-item ml-1" data-action="collapse"></a>
                            <a class="list-icons-item" data-action="reload" ng-click="init()"></a>
                        </div>
                    </div>
    
                    <div class="list-group list-group-flush">
                        <div class="list">
                            <a ng-repeat="country in countries | filter:searchCountry" class="list-group-item list-group-item-action legitRipple">
                                <div class="lblbx"><i class="fa fa-angle-right mr-3 fa-1x"></i>[[country.CountryName]]</div>
                                <div class="icnbx">
                                <span  ng-click="editCountry(country)" class="badge bg-success icn"><i class="fa fa-pencil" style="color: white"></i></span>
                                <span  ng-click="deleteCountry(country)" class="badge bg-danger icn"><i class="fa fa-trash" style="color: white"></i></span>
                                </div>
                            </a>
                        </div>    
                        <a class="list-group-item list-group-item-action legitRipple" ng-click="addCountry()">
                            <i class="fa fa-plus mr-3"></i>
                            <strong>Add Country</strong>
                        </a>
                    </div>
                </div>
                <!-- /countries -->
            </div>

            <div class="col-md-4">
                <!-- states -->
                <div class="card">
                    <div class="card-header bg-transparent header-elements-inline">
                        <span class="card-title font-weight-semibold">States</span>
                        <input type="text" ng-model="searchState" class="srch form-control form-control-lg alpha-grey col-md-8" placeholder="Search">
                        <div class="header-elements">
                            <span class="badge bg-info badge-pill">[[states.length]]</span>
                            <a class="list-icons-item ml-1" data-action="collapse"></a>
                            <a class="list-icons-item" data-action="reload" ng-click="init()"></a>
                        </div>
                    </div>
    
                    <div class="list-group list-group-flush">
                        <div class="list">
                            <a ng-repeat="state in states | filter:searchState" class="list-group-item list-group-item-action legitRipple">
                                <div class="lblbx"><i class="fa fa-angle-right mr-3 fa-1x"></i>[[state.StateName]]</div>
                                <div class="icnbx">
                                <span  ng-click="editState(state)" class="badge bg-success icn"><i class="fa fa-pencil" style="color: white"></i></span>
                                <span  ng-click="deleteState(state)" class="badge bg-danger icn"><i class="fa fa-trash" style="color: white"></i></span>

                            </div>
                            </a>
                        </div>    
                        <a class="list-group-item list-group-item-action legitRipple" ng-click="addState()">
                            <i class="fa fa-plus mr-3"></i>
                            <strong>Add State</strong>
                        </a>
                    </div>
                </div>
                <!-- /states -->
            </div>

            <div class="col-md-4">
                <!-- states -->
                <div class="card">
                    <div class="card-header bg-transparent header-elements-inline">
                        <span class="card-title font-weight-semibold">Cities</span>
                        <input type="text" ng-model="searchCity" class="srch form-control form-control-lg alpha-grey col-md-8" placeholder="Search">
                        <div class="header-elements">
                            <span class="badge bg-info badge-pill">[[cities.length]]</span>
                            <a class="list-icons-item ml-1" data-action="collapse"></a>
                            <a class="list-icons-item" data-action="reload" ng-click="init()"></a>
                        </div>
                    </div>
    
                    <div class="list-group list-group-flush">
                        <div class="list">
                            <a ng-repeat="city in cities |filter:searchCity " class="list-group-item list-group-item-action legitRipple">
                                <div class="lblbx"><i class="fa fa-angle-right mr-3 fa-1x"></i>[[city.CityName]]</div>
                                <div class="icnbx">
                                <span  ng-click="editCity(city)" class="badge bg-success icn"><i class="fa fa-pencil" style="color: white"></i></span>
                                <span  ng-click="deleteCity(city)" class="badge bg-danger icn"><i class="fa fa-trash" style="color: white"></i></span>
                            </div>
                            </a>
                        </div>    
                        <a class="list-group-item list-group-item-action legitRipple" ng-click="addCity()">
                            <i class="fa fa-plus mr-3"></i>
                            <strong>Add City</strong>
                        </a>
                    </div>
                </div>
                <!-- /states -->
            </div>
    
           
           
        </div>
    </div>
    
    
    