<div ng-if="formType == 'edit'" class="card p-2 d-none">
    <div class="row">
        <div  class="col ">
            <a href="http://localhost:8000/nrooms" target="_blank">
                <div class="card card-body bg-blue-400 has-bg-image" style="min-height: 95px;">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="mb-0">[[hotel.RoomCount]]</h3>
                            <span class="text-uppercase font-size-xs">Total Rooms</span>
                        </div>
        
                        <div class="ml-3 align-self-center">
                            <i class="icon-city icon-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    
         <div class="col">
             <a href="http://localhost:8000/bookings" target="_blank">
                <div class="card card-body bg-success-400 has-bg-image" style="min-height: 95px;">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="mb-0">[[hotel.BookingCount]]</h3>
                            <span class="text-uppercase font-size-xs">Total Bookings</span>
                        </div>
        
                        <div class="ml-3 align-self-center">
                            <i class="far fa-calendar-check fa-4x opacity-75"></i>
                        </div>
                    </div>
                </div>
             </a>
        </div>


        <div class="col">
               <div class="card card-body bg-indigo-400 has-bg-image" style="min-height: 95px;">
                   <div class="media">
                       <div class="media-body">
                           <h3 class="mb-0">[[hotel.BookingRevenueSum |currency ]]</h3>
                           <span class="text-uppercase font-size-xs">Total Revenue</span>
                       </div>
       
                       <div class="ml-3 align-self-center">
                        <i class="far fa-money-bill-alt fa-4x opacity-75"></i>
                           {{-- <i class="far fa-calendar-check fa-4x opacity-75"></i> --}}
                       </div>
                   </div>
               </div>
       </div>
    </div>
</div>