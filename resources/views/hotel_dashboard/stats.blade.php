
<div class="card p-3">


    <div class="row">

        {{-- <div class="col-sm-6 col-xl-3">

            <!-- Members online -->
            <div class="card text-black">
                <div class="card-body">
                    <div class="d-flex">
                        <h3 class="font-weight-semibold mb-0">Booking Statistics</h3>
                        <!-- <div class="list-icons ml-auto">
                            <div class="dropdown position-static">
                                <md-select md-no-asterisk  name="month" class="m-0" ng-model="hotel_dashboard.month" placeholder="Select a Month ">
                                    <md-option ng-repeat="month in months" ng-value="month.name">[[month.name]]</md-option>
                                </md-select>
                            </div>
                        </div> -->
                    </div>
                    <div class="row text-center">
                        <div class="col-4">
                            <p><i class="icon-watch2 icon-2x d-inline-block text-info"></i></p>
                            <h5 class="font-weight-semibold mb-0">[[records.rooms_occupied]]</h5>
                            <span class="font-size-sm">Occupied Rooms</span>
                        </div>

                        <div class="col-4">
                            <p><i class="icon-checkmark-circle icon-2x d-inline-block text-success"></i></p>
                            <h5 class="font-weight-semibold mb-0">[[records.bookingApprovedCount]]</h5>
                            <span class="font-size-sm">Confirmed</span>
                        </div>

                        <div class="col-4">
                            <p><i class="icon-cancel-circle2 icon-2x d-inline-block text-danger"></i></p>
                            <h5 class="font-weight-semibold mb-0">[[records.bookingCancelledCount]]</h5>
                            <span class="font-size-sm">Cancelled</span>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="p-2 mt-2">
                            <i class="icon-price-tag2 icon-2x d-inline-block text-dark"></i>
                        </div>
                        <div class="p-2">
                            <h5 class="font-weight-semibold mb-0">Total Bookings</h5>

                            <div class="font-size-sm opacity-75">[[records.bookingCount]]</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /members online -->

        </div> --}}
        <div class="col-sm-6 col-xl-3 d-flex">

            <!-- Pie with progress -->
            <div class="card card-body text-center flex-fill">
                <h6 class="font-weight-semibold mb-0 mt-1">Rooms Statistics</h6>
                <div class="font-size-sm text-muted mb-3">[[current_date]]</div>
                <div class="svg-center" id="pie_progress_bar">
                </div>

                
            </div>
            <!-- /pie with progress -->

        </div>

        {{-- <div class="col-sm-6 col-xl-4">

            <!-- Progress arc - multiple colors -->
            <div class="card card-body text-center">
                <div class="media">
                    <div class="list-icons text-right ml-auto">
                        <div class="dropdown position-static">
                            <md-select ng-change="getCheckouts()" md-no-asterisk name="checkout_period" class="m-0"
                                ng-model="hotel_dashboard.checkout_period" placeholder="Select a Period ">
                                <md-option ng-repeat="period in periods" ng-value="period.name">[[period.name]]
                                </md-option>
                            </md-select>
                        </div>
                    </div>

                </div>
                <div class="media">
                    

                    <div class="media-body text-left">
                        <h3 class="font-weight-semibold mb-0">[[records.expectedCheckoutCount]]</h3>
                        <span class="text-uppercase font-size-sm text-muted">Expected Checkout</span>
                    </div>
                    <div class="media-body text-right">
                        <h3 class="font-weight-semibold mb-0">[[records.todayCheckoutCount]]</h3>
                        <span class="text-uppercase font-size-sm text-muted">Checked Outs</span>
                    </div>
                </div>
            </div>
            <!-- /progress arc - multiple colors -->

            <div class="card card-body text-center">
                <div class="media">

                    <div class="list-icons text-right ml-auto">
                        <div class="dropdown position-static">
                            <md-select ng-change="getCheckins()" md-no-asterisk name="checkin_period" class="m-0"
                                ng-model="hotel_dashboard.checkin_period" placeholder="Select a Period ">
                                <md-option ng-repeat="period in periods" ng-value="period.name">[[period.name]]
                                </md-option>
                            </md-select>
                        </div>
                    </div>
                </div>
                <div class="media">
                    <div class="media-body text-left">
                        <h3 class="font-weight-semibold mb-0">[[records.expectedCheckinCount]]</h3>
                        <span class="text-uppercase font-size-sm text-muted">Expected CheckIn</span>
                    </div>
                    <div class="media-body text-right">
                        <h3 class="font-weight-semibold mb-0">[[records.todayCheckinCount]]</h3>
                        <span class="text-uppercase font-size-sm text-muted">Checked Ins</span>
                    </div>
                </div>
            </div>

        </div> --}}


        <div class="col-sm-6 col-xl-3 d-flex">
            <div class="card card-body text-center bg-white text-black has-bg-image flex-fill">
                <div class="list-icons ml-auto">
                    <div class="dropdown position-static">
                        <a href="#" class="list-icons-item dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="icon-filter3"></i></a>
                        <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(157px, 48px, 0px);">
                            {{-- <a ng-click="getCheckouts('today')" class="dropdown-item"> Today</a> --}}
                            <a ng-click="getCheckouts('as of today')" class="dropdown-item cstClassCO aot-co active"> As of Today</a> {{-- All records before today  --}}
                            <a ng-click="getCheckouts('this week')" class="dropdown-item cstClassCO tw-co"> This Week</a>
                            <a ng-click="getCheckouts('next week')" class="dropdown-item cstClassCO nw-co"> Next Week</a>
                            <a ng-click="getCheckouts('this month')" class="dropdown-item cstClassCO tm-co"> This Month</a>
                            <a ng-click="getCheckouts('next month')" class="dropdown-item cstClassCO nm-co"> Next Month</a>
                        </div>
                    </div>
                </div>
                <div class="svg-center position-relative" id="progress_icon_three">
                    {{-- <svg width="84" height="84"><g transform="translate(42,42)"><path class="d3-progress-background" d="M0,42A42,42 0 1,1 0,-42A42,42 0 1,1 0,42M0,39.5A39.5,39.5 0 1,0 0,-39.5A39.5,39.5 0 1,0 0,39.5Z" style="fill: rgb(255, 255, 255); opacity: 0.1;"></path><path class="d3-progress-foreground" filter="url(#blur)" d="M6.661338147750939e-16,-40.7308237088326A1.25,1.25 0 0,1 1.2883435582822094,-41.98023547904219A42,42 0 1,1 -41.48773651930016,6.539703242894765A1.25,1.25 0 0,1 -40.40964899818112,5.104925841165514L-40.40964899818112,5.104925841165514A1.25,1.25 0 0,1 -39.01822839315133,6.150435192722457A39.5,39.5 0 1,0 1.2116564417177922,-39.48141193862301A1.25,1.25 0 0,1 6.661338147750939e-16,-40.7308237088326Z" style="fill: rgb(255, 255, 255); stroke: rgb(255, 255, 255);"></path><path class="d3-progress-front" d="M6.661338147750939e-16,-40.7308237088326A1.25,1.25 0 0,1 1.2883435582822094,-41.98023547904219A42,42 0 1,1 -41.48773651930016,6.539703242894765A1.25,1.25 0 0,1 -40.40964899818112,5.104925841165514L-40.40964899818112,5.104925841165514A1.25,1.25 0 0,1 -39.01822839315133,6.150435192722457A39.5,39.5 0 1,0 1.2116564417177922,-39.48141193862301A1.25,1.25 0 0,1 6.661338147750939e-16,-40.7308237088326Z" style="fill: rgb(255, 255, 255); fill-opacity: 1;"></path></g></svg><i class="icon-bag counter-icon" style="color: rgb(255, 255, 255); top: 26px;"></i> --}}
                </div>
                {{-- <h2 class="pt-1 mt-2 mb-1">[[ records.expectedCheckoutCount > 0 ? (records.todayCheckoutCount / records.expectedCheckoutCount)*100 : (records.todayCheckoutCount > 0 ? 100 : 0) | number:0]]%</h2> --}}
                {{-- <h2 class="pt-1 mt-2 mb-1">[[ records.expectedCheckoutCount <= records.todayCheckoutCount ? (records.expectedCheckoutCount / records.todayCheckoutCount)*100 : (records.todayCheckoutCount <= records.expectedCheckoutCount ? (records.todayCheckoutCount / records.expectedCheckoutCount)*100 : 0) | number:0]]%</h2> --}}
                <h2 class="pt-1 mt-2 mb-1">[[ (records.completedCheckoutCount > 0 ? (records.todayCheckoutCount / records.completedCheckoutCount)*100 : 100) | number:0]]%</h2>

                Checkout processed
                <div class="font-size-sm opacity-75">[[records.expectedCheckoutCount]] checkouts are pending</div>
                
            </div>
        </div>
        <div class="col-sm-6 col-xl-3 d-flex">

            <!-- Order shipped -->
            <div class="card card-body text-center bg-white text-black has-bg-image flex-fill">
                <div class="list-icons ml-auto">
                    <div class="dropdown position-static">
                        <a href="#" class="list-icons-item dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="icon-filter3"></i></a>
                        <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(157px, 48px, 0px);">
                            {{-- <a ng-click="getCheckins('today')" class="dropdown-item"> Today</a> --}}
                            <a ng-click="getCheckins('as of today')" class="dropdown-item cstClassCI aot-ci active"> As of Today</a>
                            <a ng-click="getCheckins('this week')" class="dropdown-item cstClassCI tw-ci"> This Week</a>
                            <a ng-click="getCheckins('next week')" class="dropdown-item cstClassCI nw-ci"> Next Week</a>
                            <a ng-click="getCheckins('this month')" class="dropdown-item cstClassCI tm-ci"> This Month</a>
                            <a ng-click="getCheckins('next month')" class="dropdown-item cstClassCI nm-ci"> Next Month</a>
                        </div>
                    </div>
                </div>
                <div class="svg-center position-relative" id="progress_icon_four">
                    {{-- <svg width="84" height="84"><g transform="translate(42,42)"><path class="d3-progress-background" d="M0,42A42,42 0 1,1 0,-42A42,42 0 1,1 0,42M0,39.5A39.5,39.5 0 1,0 0,-39.5A39.5,39.5 0 1,0 0,39.5Z" style="fill: rgb(255, 255, 255); opacity: 0.1;"></path><path class="d3-progress-foreground" filter="url(#blur)" d="M6.661338147750939e-16,-40.7308237088326A1.25,1.25 0 0,1 1.2883435582822094,-41.98023547904219A42,42 0 0,1 3.9217621022559332,41.81650131244016A1.25,1.25 0 0,1 2.557509581534405,40.65045073231489L2.557509581534405,40.65045073231489A1.25,1.25 0 0,1 3.6883238818835555,39.327423853366334A39.5,39.5 0 0,0 1.2116564417177922,-39.48141193862301A1.25,1.25 0 0,1 6.661338147750939e-16,-40.7308237088326Z" style="fill: rgb(255, 255, 255); stroke: rgb(255, 255, 255);"></path><path class="d3-progress-front" d="M6.661338147750939e-16,-40.7308237088326A1.25,1.25 0 0,1 1.2883435582822094,-41.98023547904219A42,42 0 0,1 3.9217621022559332,41.81650131244016A1.25,1.25 0 0,1 2.557509581534405,40.65045073231489L2.557509581534405,40.65045073231489A1.25,1.25 0 0,1 3.6883238818835555,39.327423853366334A39.5,39.5 0 0,0 1.2116564417177922,-39.48141193862301A1.25,1.25 0 0,1 6.661338147750939e-16,-40.7308237088326Z" style="fill: rgb(255, 255, 255); fill-opacity: 1;"></path></g></svg><i class="icon-truck counter-icon" style="color: rgb(255, 255, 255); top: 26px;"></i> --}}
                </div>
                {{-- <h2 class="pt-1 mt-2 mb-1">[[ records.expectedCheckinCount > 0 ? (records.todayCheckinCount / records.expectedCheckinCount)*100 : (records.todayCheckinCount > 0 ? 100 : 0)  | number:0]]%</h2> --}}
                {{-- <h2 class="pt-1 mt-2 mb-1">[[ (records.expectedCheckinCount <= records.todayCheckinCount ? (records.expectedCheckinCount / records.todayCheckinCount)*100 : (records.todayCheckinCount <= records.expectedCheckinCount ? (records.todayCheckinCount / records.expectedCheckinCount)*100 : 0)) | number:0]]%</h2> --}}
                <h2 class="pt-1 mt-2 mb-1">[[ (records.completedCheckinCount > 0 ? (records.todayCheckinCount / records.completedCheckinCount)*100 : 100) | number:0]]%</h2>


                Checkin processed
                <div class="font-size-sm opacity-75">[[records.expectedCheckinCount]] checkins are pending</div>
            </div>
            <!-- /orders shipped -->

        </div>
        {{-- <div class="col-sm-6 col-xl-3">

            <!-- Current server load -->
            <div class="card text-black">
                <div class="card-body">
                    <div class="d-flex">
                        <h3 class="font-weight-semibold mb-0">CheckOut/CheckIn Statistics</h3>
                        <!-- <div class="list-icons ml-auto">
                            <div class="dropdown position-static">
                                <md-select md-no-asterisk  name="month" class="m-0" ng-model="hotel_dashboard.month" placeholder="Select a Month ">
                                    <md-option ng-repeat="month in months" ng-value="month.name">[[month.name]]</md-option>
                                </md-select>
                            </div>
                        </div> -->
                    </div>
                    <div class="row text-center">
                        <div class="col-4">
                            <p><i class="icon-watch2 icon-2x d-inline-block text-info"></i></p>
                            <h5 class="font-weight-semibold mb-0">[[records.expectedCheckoutCount]]</h5>
                            <span class="font-size-sm">Expected Checkout's</span>
                        </div>

                        <div class="col-4">
                            <p><i class="icon-forward2 icon-2x d-inline-block text-success"></i></p>
                            <h5 class="font-weight-semibold mb-0">[[records.todayCheckoutCount]]</h5>
                            <span class="font-size-sm">Today Checkout's</span>
                        </div>

                        <div class="col-4">
                            <p><i class="icon-backward icon-2x d-inline-block text-danger"></i></p>
                            <h5 class="font-weight-semibold mb-0">[[records.expectedCheckinCount]]</h5>
                            <span class="font-size-sm">Expected Checkin's</span>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="p-2 mt-2">
                            <i class="icon-price-tag2 icon-2x d-inline-block text-dark"></i>
                        </div>
                        <div class="p-2">
                            <h5 class="font-weight-semibold mb-0">Total Bookings</h5>

                            <div class="font-size-sm opacity-75">[[records.bookingCount]]</div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /current server load -->

        </div> --}}

        <div class="col-sm-6 col-xl-3 d-flex">

            <!-- Basic area chart -->
            <div class="card flex-fill">
                <div class="card-body">
                    <div class="d-flex">
                        <h3 class="font-weight-semibold mb-0">[[records.today_earning | currency ]]
                        </h3>
                        <div class="list-icons ml-auto">
                            <a class="list-icons-item" data-action="reload"></a>
                        </div>
                    </div>

                    <div>
                        Today's revenue
                        <div class="text-muted font-size-sm">[[records.monthly_earning/30 | currency]]avg
                        </div>
                    </div>

                </div>

                <div id="chart_area_basic">
                    {{-- <svg width="509.328125" height="50">
                        <g transform="translate(0,0)" width="509.328125">
                            <path class="d3-area"
                                d="M0,7.730147575544621C0.8736033146003909,9.037345263111979,11.815860683539412,31.531803394531963,16.977604166666666,33.134223471539S28.82403553407788,19.917285225276846,33.95520833333333,18.271257905832748S46.544305001164936,24.603193551258983,50.932812500000004,22.241742796907943S63.193791115275374,2.1085011926165045,67.91041666666666,0S80.33004574703388,4.8221506407326125,84.88802083333333,7.062543921293041S96.28680869140243,17.35975813678346,101.86562500000001,16.69009135628953S114.02951616956248,0.9692390788044309,118.84322916666667,2.98664792691497S130.98234808588202,28.92784773408523,135.82083333333333,30.920590302178496S149.09405774276718,19.662172893950864,152.7984375,16.97118763176388S164.49065823126872,4.8487708363397015,169.77604166666666,6.2543921293042875S181.74078579088192,24.201400284345766,186.7536458333333,26.001405481377372S198.69541928348352,20.21871879171868,203.73125000000002,18.446943078004217S215.05982133231177,13.81514212658231,220.70885416666667,14.0548137737175S233.34727489694382,17.494279217444124,237.68645833333335,19.887561489810263S249.1414910668328,33.65150074872244,254.6640625,32.78285312719606S265.9994367659951,14.237285914279855,271.64166666666665,14.546732255797611S283.3811759010971,33.15992384459778,288.6192708333333,34.64511595221364S300.8657243570379,26.269690839779628,305.596875,24.174279690794098S317.28909573126873,18.200843921371327,322.57447916666666,19.606465214335913S334.0725765244176,32.21220843208862,339.5520833333333,33.20449754040759S351.97544775778437,27.998716229639413,356.52968749999997,25.755446240337314S369.0507064924872,18.794341846750143,373.5072916666666,16.479269149683766S385.54242679076674,6.234521209471608,390.4848958333334,8.116654954321856S402.2977349231249,27.81168424301725,407.46250000000003,29.409697821503865S419.0478144389771,19.8223219647902,424.4401041666667,18.622628250175687S436.22309331210965,23.40873061417395,441.41770833333334,21.855235418130707S453.02712271540645,9.717907501664918,458.3953125,8.468025298664795S470.5273867036432,11.963787079700548,475.3729166666667,13.949402670414617S486.69676819244523,22.557806954993765,492.35052083333335,22.382290934645116S507.17183096597506,14.10021783219269,509.328125,12.895291637385803L509.328125,50C506.4985243055556,50,498.00972222222225,50,492.35052083333335,50S481.0321180555556,50,475.3729166666667,50S464.0545138888889,50,458.3953125,50S447.07690972222224,50,441.41770833333334,50S430.0993055555556,50,424.4401041666667,50S413.12170138888894,50,407.46250000000003,50S396.1440972222223,50,390.4848958333334,50S379.1664930555555,50,373.5072916666666,50S362.18888888888887,50,356.52968749999997,50S345.2112847222222,50,339.5520833333333,50S328.23368055555557,50,322.57447916666666,50S311.2560763888889,50,305.596875,50S294.2784722222222,50,288.6192708333333,50S277.30086805555555,50,271.64166666666665,50S260.3232638888889,50,254.6640625,50S243.34565972222225,50,237.68645833333335,50S226.36805555555554,50,220.70885416666667,50S209.39045138888892,50,203.73125000000002,50S192.4128472222222,50,186.7536458333333,50S175.43524305555553,50,169.77604166666666,50S158.45763888888888,50,152.7984375,50S141.48003472222223,50,135.82083333333333,50S124.50243055555556,50,118.84322916666667,50S107.5248263888889,50,101.86562500000001,50S90.54722222222222,50,84.88802083333333,50S73.56961805555555,50,67.91041666666666,50S56.59201388888889,50,50.932812500000004,50S39.61440972222222,50,33.95520833333333,50S22.636805555555554,50,16.977604166666666,50S2.8296006944444443,50,0,50Z"
                                style="fill: rgb(92, 107, 192);"></path>
                        </g>
                    </svg> --}}
                </div>
            </div>
            <!-- /basic area chart -->

        </div>
    </div>



</div>