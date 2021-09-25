<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice | Booking</title>

    <style>
        .main {
            width: 800px;
            margin: 0 auto;
        }
        
        .header {
            width: 100%;
            float: left;
            border-bottom: 1px solid #ea863b;
        }
        
        .headerRow {
            width: 100%;
            float: left;
        }
        
        .headerCol {
            width: 50%;
            float: left;
        }
        
        .headerCol ul {
            padding: 0;
            list-style: none;
        }
        
        .headerCol h4 {
            margin: 0;
        }
        
        .logo {
            width: 100%;
            float: left;
        }
        
        .contnt {
            width: 100%;
            float: left;
        }
        
        .sectionOne {
            width: 100%;
            float: left;
        }
        
        .sectionOnecontent {
            width: 50%;
            padding: 0px;
            color: #00000091;
            border-collapse: collapse;
            float: left;
        }
        
        .sectionOnecontent h5 {
            margin: 0;
            font-size: 18px;
            text-decoration: underline;
        }
        
        .sectionOnecontent h4 {
            margin: 10px 0;
        }
        
        .sectionOnecontent ul {
            padding: 0;
            list-style: none;
        }
        
        .sectionOnecontent ul li {
            margin: 2px 0;
        }
        
        .sectionOnecontent ul li span {
            color: #000;
        }
        
        .sectionOnecontent .box {
            min-height: 155px;
            border: 1px solid #eee;
            border-collapse: collapse;
            padding: 10px 20px;
        }
        
        .sectionTwo {
            width: 100%;
            float: left;
        }
        
        .sectionTwocontent {
            width: 100%;
            float: left;
            color: #00000091;
        }
        
        .sectionTwocontent h5 {
            margin: 0;
            font-size: 18px;
            text-decoration: underline;
        }
        
        .sectionTwocontent .box {
            border: 1px solid #eee;
            border-collapse: collapse;
            padding: 10px 20px;
        }
        
        .sectionTwocontent table {
            margin-top: 25px;
            width: 100%;
            text-align: left;
            border-collapse: collapse;
        }
        
        .sectionTwocontent ul {
            padding: 0;
            list-style: none;
        }
        
        .sectionTwocontent table th {
            padding: 10px !important;
            background: #1f2120;
            color: #fff;
        }
        
        .sectionTwocontent table td,
        .sectionTwocontent table th {
            border: 1px solid #eee;
            padding: 0 10px;
        }
        
        .sectionTwocontent table span.nightscount {
            display: block;
        }
        
        .sectionTwocontent table span.nightscharges {
            display: block;
        }
        
        .sectionTwocontent span.servicelist {
            display: block;
        }
        
        .sectionTwocontent span.serviceprice {
            display: block;
        }
        
        .sectionTwocontent span.guestcount {
            display: block;
        }
        
        .sectionTwocontent span.guestprice {
            display: block;
        }
        
        .sectionTwocontent span.guestprice {
            display: block;
        }
        
        .sectionTwocontent span.roomtitle {
            display: block;
        }
        
        .sectionTwocontent span.roomcategory {
            display: block;
        }
        
        .sectionTwocontent span.roomcategory {
            display: inline-block;
            padding: 3px;
            margin-top: 5px;
            font-size: 12px;
            border-radius: 2px;
        }
        
        .sectionTwocontent span.tax {
            display: block;
        }
        
        .sectionTwocontent span.discount {
            display: block;
        }
        
        .sectionTwocontent span.grandtotal {
            display: block;
        }
        
        span.roomAllowedoccupants {
            display: block;
            font-size: 13px;
        }
        
        span.roomMaxAllowedoccupants {
            display: block;
            font-size: 13px;
        }
    </style>
</head>

<body>
    @php
        $nights = $booking->invoice->nights
    @endphp
    <div class="main" style="width: 80%;margin: 0 auto;padding: 15px 15px;">
        <div class="header" style="width: 100%;float: left;border-bottom: 1px solid #ea863b;">
            <div class="headerRow" style="width: 100%;float: left;">
                <div class="headerCol" style="width: 50%;float: left;">
                    <div class="logo">
                        <img src="https://www.ktownrooms.com/resources/assets/web/img/logo.png" alt="">
                    </div>
                </div>
                <div class="headerCol" style="width: 50%;float: left;">
                    <h4 style="margin: 0; margin: 0;font-size: 16px;font-weight: 600;">Head Office</h4>
                    <ul style="padding: 0;list-style: none; margin: 0;">
                        <li style="margin-left:0;"> <b> Address :</b> <span>73C Jami Commercial Phase VII DHA Karachi
                        </span></li>
                        <li style="margin-left:0;"><b>Phone :</b><span>(92)-311-1222418
                        </span></li>
                        <li style="margin-left:0;"><b>Website:</b> <span><a href="https://www.ktownrooms.com" target="_blank">www.ktownrooms.com</a></span></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="contnt" style="width: 100%;float: left;">
            <div class="sectionOne" style="width: 100%;float: left;">
                <div class="sectionOnecontent" style="width: 50%;padding: 0px;color: #00000091;border-collapse: collapse;float: left;">
                    <div class="box" style="min-height: 175px; border: 1px solid #eee;border-collapse: collapse; padding: 10px 20px;">
                        <h5 style="margin: 0;font-size: 18px;text-decoration: underline;">Booking Detail</h5>
                        <div class="">
                            <ul style=" padding: 0;list-style: none;">
                                <li style=" margin: 2px 0;"><b> Booking # :</b> <span style=" color: #000;font-weight:bold">{{$booking->booking_no}}</span></li>
                                <li style=" margin: 2px 0;"><b> Hotel Name :</b> <span style=" color: #000;">{{$booking->hotel->HotelName}}</span></li>
                                <li style=" margin: 2px 0;"><b> Booking From :</b> <span style=" color: #000;">{{(new \DateTime($booking->BookingFrom))->format('m/d/Y')}}</span></li>
                                <li style=" margin: 2px 0;"><b>Booking To :</b> <span style=" color: #000;">{{(new \DateTime($booking->BookingTo))->format('m/d/Y')}}</span></li>
                                <li style=" margin: 2px 0;"><b>Website :</b> <span style=" color: #000;"> <a href="https://www.ktownrooms.com" target="_blank">www.ktownrooms.com</a></span></li>
                            </ul>
                        </div>
                    </div>

                </div>

                <div class="sectionOnecontent" style="width: 50%;padding: 0px;color: #00000091;border-collapse: collapse;float: left;">
                    <div class=" box " style="min-height: 175px; border: 1px solid #eee;border-collapse: collapse; padding: 10px 20px;">
                        <h5 style="margin: 0;font-size: 18px;text-decoration: underline;">Customer Detail</h5>
                        <div class=" ">

                            <ul style=" padding: 0;list-style: none;">
                                <li style=" margin: 2px 0;"><b> Customer Name :</b> <span style=" color: #000;">{{$booking->customer->FirstName . ' ' . $booking->customer->LastName}}</span></li>
                                <li style=" margin: 2px 0;"><b> Email :</b> <span style=" color: #000;">{{$booking->customer->Email}}</span></li>
                                <li style=" margin: 2px 0;"><b> Phone :</b> <span style=" color: #000;">{{$booking->customer->Phone}}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sectionTwo " style=" width: 100%;float: left;">
                <div class="sectionTwocontent " style="width: 100%;float: left;color: #00000091;">
                    <div class="box " style=" border: 1px solid #eee;border-collapse: collapse;padding: 10px 20px;">
                        <h5 style=" margin: 0;font-size: 18px;text-decoration: underline;">Invoice Detail</h5>
                        <div class=" ">

                            <table style="margin-top: 25px;width: 100%;text-align: left;border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <th style="padding: 10px !important;background: #1f2120;color: #fff;">Room Title</th>
                                        <th style="padding: 10px !important;background: #1f2120;color: #fff;">Night(s)</th>
                                        <th style="padding: 10px !important;background: #1f2120;color: #fff;display:none">Services</th>
                                        <th style="padding: 10px !important;background: #1f2120;color: #fff;">Add. Guest</th>
                                        <th style="padding: 10px !important;background: #1f2120;color: #fff;">Total</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($booking->rooms as $room)
                                    <tr>
                                        <td style="color: #000;background: #828c9d4f; border: 1px solid #eee; padding: 0 15px;">
                                            <span class="roomtitle " style=" margin:5px 0 ; display: block;">{{$room->room_title}}</span>
                                            <span style=" background-color: #4caf50;display: inline-block;padding: 3px;margin-top: 5px;font-size: 12px;border-radius: 2px; color:#fff;" class="roomcategory ">{{$room->category->RoomCategory}}</span>
                                            <span class="  roomAllowedoccupants " style=" display: block; font-size: 13px;    margin: 5px 0; ">Allowed: {{$room->hotel_room_category->allowed}}</span>
                                            <span class="  roomMaxAllowedoccupants " style=" display: block; font-size: 13px;    margin: 5px 0; ">Max Allowed Occupants: {{$room->hotel_room_category->max_allowed}}</span>
                                        </td>
                                        <td style="border: 1px solid #eee; padding: 0 15px;">
                                            <span class=" nightscount " style="  margin:5px 0 ;display: block; ">{{$nights}} Night(s)</span>
                                            <span class="nightscharges " style=" margin:5px 0 ; display: block; ">{{$nights}} x Rs. {{$room->pivot->room_charges}}</span>
                                            <span class="nightscharges " style="  margin:5px 0 ;display: block; ">Rs. {{$room->pivot->room_charges * $nights}}</span>
                                        </td>
                                        <td style="border: 1px solid #eee; padding: 0 15px;display:none">
                                            <span class="services" style="display: block;">Service 1</span>
                                            <span class="services" style="display: block;">Service 2</span>
                                            <span class="services" style="display: block;">Service 3</span>

                                            <span class="serviceprice" style="  margin:5px 0 ;display: block; ">Rs.2000</span>
                                        </td>
                                        <td style="border: 1px solid #eee; padding: 0 15px;">
                                            @if($room->pivot->occupants > $room->pivot->allowed_occupants)
                                            <span class="guestcount " style=" display: block; ">{{$room->pivot->occupants - $room->pivot->allowed_occupants}} Guest(s)</span>
                                            <span class="guestprice " style=" display: block; ">{{$room->pivot->occupants - $room->pivot->allowed_occupants}} x Rs. {{$room->pivot->additional_guest_rate * $nights}}</span>
                                            <span class="guestprice " style=" display: block; ">Rs. {{$room->pivot->additional_guest_charges}}</span>
                                            @endif
                                        </td>
                                        <td style="border: 1px solid #eee; padding: 0 15px;">
                                            Rs. {{$room->pivot->room_charges + $room->pivot->additional_guest_charges}}
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="2 ">

                                        </td>
                                        <td colspan="3 " style="border: 1px solid #eee; padding: 0 10px; background: #828c9d4f; color:#000;">
                                            <div class="total">
                                                <span class="subtotal " style="  margin:5px 0 ;display: block; ">Sub Total: Rs. {{$booking->invoice->total}}</span>
                                                <span class="tax " style="  margin:5px 0 ;display: block; ">Tax ({{$booking->invoice->tax_name}} {{$booking->invoice->tax_rate}} %): Rs. {{$booking->invoice->tax_charges}}</span>
                                                @if ($booking->invoice->discount_amount > 0)
                                                <span class="discount" style="  margin:5px 0 ;display: block; ">Discount: Rs. {{$booking->invoice->discount_amount}} @if($booking->invoice->per_night==1) ({{$booking->invoice->discount_per_night}} / Night) @endif</span>
                                                @endif
                                                @if ($booking->promo_id)
                                                <span class="discount " style="  margin:5px 0 ;display: block; ">Discount ({{$booking->invoice->promo_code}}): @if($booking->invoice->promo_id_percentage==0)<span>Rs. </span>@endif @if($booking->invoice->promo_is_percentage=='1')<span>%</span>@endif</span>
                                                @endif
                                                <span class="grandtotal " style="  margin:5px 0 ;display: block; ">GRAND TOTAL:<b> Rs. {{$booking->invoice->net_total}}</b></span>
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            {{-- <p style="margin: 0;text-align: right;"><small>*All prices are inclusive of tax</small></p> --}}
                            @if ($booking->status == 'CheckedIn')
                            <div class="ComplainViewbtn">
                                <p style="margin: 10px 0 0;">For any complain or to request a service. Click on the button below!</p>
                                <a href="{{url('customerservices') . '/' . encrypt($booking->booking_no)}}" style="border: none;background: #4caf50;padding: 5px 10px;color: #fff;cursor: pointer;font-weight: 400;margin: 5px 0;text-decoration: none;display: inline-block;">
                                    Customer Portal
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>

</html>