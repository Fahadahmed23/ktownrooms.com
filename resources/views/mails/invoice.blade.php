<?php
// $start_date = str_replace("/", "-", $hotel[0]->CheckInDate);
// $end_date = str_replace("/", "-", $hotel[0]->CheckOutDate);

// $start_date = new DateTime(date('Y-m-d', strtotime($start_date)));
// $end_date = new DateTime(date('Y-m-d', strtotime($end_date)));

// $nights = $end_date->diff($start_date)->format("%d");
// $nights = $nights > 0 ? $nights : 1;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Ktown Rooms." />
    <title>Booking | Confirmation</title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="{{ url('resources/assets/web') }}/img/favicon.png" type="image/x-icon" />
    <link href="{{ url('resources/assets/web') }}/css/skins/square/grey.css" rel="stylesheet" />

    <style>
        table td{      
            word-wrap: break-word;
        }
        .mainDiv{
            width: 800px;
            background: #fff; 
            margin: 0 auto;
        }
        .paddingDiv{
            padding-top: 60px;
        }
        .logoContainer{
            width: 50%;
            float: left;
        }
        .addressDiv{
            width: 50%;
            float: left;
        }
        .variableWidth{
            width: 50%;
        }
        .hotelName{
            border: none !important;
            width: 50%;
        }
        /* .col-xs-6{
            width: 48%;
            float: left; 
            margin: 20px 0;
            padding-right: 15px;
        } */
        .col-xs-6{
            width: 50%;
            float: left;
            padding: 0;
        }
       



        @media  print {
            .page-header {
                display: none;
            }
            @page  {
                size: auto;
                margin: 0mm;
            }
        }
        @media only screen and (max-width: 380px) {
          .mainDiv{
            width: 360px
          }
          .logo{
            width: 170px;
          }
          .paddingDiv{
            padding-top: 0px;
          }
           .logoContainer{
            width: 100%;
            float: none;
          }
          .addressDiv{
            width: 100%;
            float: none;
        }
        .variableWidth{
            width: 28%;
        }
        .hotelName{
            width: 100%;
        }
        .col-xs-6{
            width: 100%;
        }
    }
    @media only screen and (max-width: 414px) and (min-width: 381px) {
          .mainDiv{
            width: 400px
          }
          .logo{
            width: 170px;
          }
          .paddingDiv{
            padding-top: 0px;
          }
           .logoContainer{
            width: 100%;
            float: none;
          }
          .addressDiv{
            width: 100%;
            float: none;
        }
        .variableWidth{
            width: 28%;
        }
        .hotelName{
            width: 100%;
        }
        .col-xs-6{
            width: 100%;
        }
    }

    </style>
</head>

<body>
    <div class="mainDiv">
    <?php if(isset($email)) { ?>
        <p>Thank you for your booking at KTown Rooms and Homes. Details of your booking are mentioned below:</p>
        <ol>
            <li>KTown Rooms and Homes ({{$booking->hotel->HotelName}}) is expecting you on {{date_format(date_create($booking->BookingFrom), 'd-m-Y')}} at 14:00 - 15:00.</li>
            <li>Your payment will be handled by KTown Rooms and Homes ({{$booking->hotel->HotelName}}).</li>
        </ol>
    <?php } ?>
        <div class="paddingDiv">

            <div class="row" style="width:100%;float:left;">
            
                <div class="logoContainer" style="width:50%; float:left;">
                    <!-- <div style="">
                        <img class="logo" src="https://www.ktownrooms.com/resources/assets/web/img/logo.png" />
                    </div> -->
                    @php
                        $img = \App\Models\DefaultRule::first()->picture;
                        $default_rule = \App\Models\DefaultRule::first();
                    @endphp
                    @if($img)
                        <img class="logo"  src="{{$img}}" alt="" style="width: 75%;">
                    @else 
                        <img class="logo"  src="https://www.ktownrooms.com/resources/assets/web/img/logo.png" alt="">
                    @endif
                </div>
                @if(isset($booking->hotel->mailimage))
                    <div class="logoContainer" style="width:50%; float:left;">
                        <div style="">
                            <img class="logo" src="{{$booking->hotel->mailimage}}" />
                        </div>
                    </div>
                @endif
            
            </div>
            <div class="row" style="width:100%;float:left;">

                <div class="addressDiv" style="width:50%; float:left;">
                    <h5 style="font-size: 22px;margin: 4px 0;">Head Office</h5>
                    <table style="width: 100%;">
                        <tr>
                            <td class="variableWidth"><b style="font-size: 15px;">Address:</b></td>
                            <td>{{$default_rule->address}}</td>
                        </tr>
                        <tr>
                            <td><b style="font-size: 15px;">Phone No:</b></td>
                            <td>{{$default_rule->phone}}</td>
                        </tr>
                        <tr>
                            <td><b style="font-size: 15px;">Website:</b></td>
                            <td>{{$default_rule->website}}</td>
                        </tr>
                    </table>
                </div>

                <div class="addressDiv" style="width:50%; float:left;">
                <h5 style="font-size: 22px;margin: 4px 0;">Hotel Detail</h5>
                    <table class="table" style="border: none !important; width: 100%;">
                        <tr style="border: none !important;">
                            <td class="hotelName">
                                <b style="">Hotel Name:</b>
                            </td>
                            <td>
                                {{ $booking->hotel->HotelName }}
                            </td>
                        </tr> 
                        <tr>   
                            <td class="hotelName">
                                <b style="">Hotel Address:</b>
                            </td>
                            <td>
                                {{$booking->hotel->Address}}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="">
            <div class="">
                <div class="">
                    <a href="{{$booking->hotel->address}}" target="_blank">
                    <img  src="{{ url('public/uploads/website/maps') . '/' . str_replace(' ','%20',$booking->hotel->address)}}" alt="" style="width: 100%;max-width: 100%;object-fit: unset"></a>
                </div>
                {{-- <hr style="border-color: #ea873a;" /> --}}
                <table class="table " style="border-collapse: collapse; width: 100%;">
                    <tr>
                        <td class="" style="width: 25%;border: 1px solid #ddd; text-align: center;border-collapse: collapse; padding: 5px; ">Booking #</td>
                        <td class="" style="width: 25%;border: 1px solid #ddd; text-align: center;border-collapse: collapse; padding: 5px; ">Customer</td>
                        <td class="" style="width: 25%;border: 1px solid #ddd; text-align: center;border-collapse: collapse; padding: 5px; ">Paid On</td>
                        <td class="" style="width: 25%;border: 1px solid #ddd; text-align: center;border-collapse: collapse; padding: 5px; ">Status</td>
                    </tr>
                    <tr style="background: #f5f5f5;">
                        <td class="text-center" style="width: 25%;border: 1px solid #ddd; text-align: center;border-collapse: collapse; padding: 5px; ">{{ $booking->booking_no }}</td>
                        <td class="text-center" style="width: 25%;border: 1px solid #ddd; text-align: center;border-collapse: collapse; padding: 5px; ">{{ $booking->customer->FirstName.' '.$booking->customer->LastName }}</td>
                        <td class="text-center" style="width: 25%;border: 1px solid #ddd; text-align: center;border-collapse: collapse; padding: 5px; ">{{ ($booking->invoice->payment_amount == $booking->invoice->net_total ? date_format(date_create($booking->invoice->updated_at), 'd-m-Y') : 'Unpaid') }}</td>
                        <td class="text-center" style="width: 25%;border: 1px solid #ddd; text-align: center;border-collapse: collapse; padding: 5px; ">{{ ($booking->invoice->payment_amount == $booking->invoice->net_total ? 'Paid' : 'Unpaid') }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="" style="float: left; width:100%;">
            <div class="col-xs-6" style="width: 48%;float: left;padding: 15px 0;">
                <div style="background: #f5f5f5;padding: 25px 10px;border: 1px solid #ddd; height: 120px;">
                    <p style="margin: 0;font-size: 11px;"><b style="font-size: 15px;">Booking Issued To</b></p>
                    <table style="width: 100%;  table-layout: fixed; ">
                        <tr>
                            <td style="width:30%;">Name:</td>
                            <td>{{ $booking->customer->FirstName.' '.$booking->customer->LastName }}</td>
                        </tr>
                        <tr>
                            <td>Cell:</td>
                            <td>{{ $booking->customer->Phone }}</td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td style="word-wrap: break-word;"> <span>{{ $booking->customer->Email }}</span></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-xs-6" style="width: 48%;float: right;padding: 15px 0;">
                <div style="background: #f5f5f5;padding: 25px 10px;border: 1px solid #ddd; height: 120px;">
                    <p style="margin: 0;font-size: 11px;"><b style="font-size: 15px;">Booking Issued By</b></p>
                    <table style="width: 100%;  table-layout: fixed; ">
                        <tr>
                            <td colspan="2">KTown Rooms</td>
                        </tr>
                        <tr>
                            <td style="width:30%;">Phone No.:</td>
                            <td>(92)-311-1222418</td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td style="word-wrap: break-word;"><span> bookings@ktownrooms.com</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <br />
        <div class="" style="">
            <div class="">
                <table class="table" style="margin-bottom:2px; border-collapse: collapse;border: 1px solid #ddd; width: 100%;">
                    <tr style="background: #ea873a;
                            color: #fff; text-align:center">
                        <th style="border: 1px solid #ddd; border-collapse: collapse; padding: 5px 8px;">Hotel</th>
                        <th style="border: 1px solid #ddd; border-collapse: collapse; padding: 5px 8px;">Check In - Check Out Date</th>
                        <th style="border: 1px solid #ddd; border-collapse: collapse; padding: 5px 8px;">Guests</th>
                        <th style="border: 1px solid #ddd; border-collapse: collapse; padding: 5px 8px;"> Rooms</th>
                        <th style="border: 1px solid #ddd; border-collapse: collapse; padding: 5px 8px;">Subtotal</th>
                    </tr>
                    @foreach($booking->rooms as $room)
                    <tr style="background: #f5f5f5; text-align:center">
                        <td style="border: 1px solid #ddd; border-collapse: collapse; padding: 5px 8px;">{{ $booking->hotel->HotelName }}</td>
                        <td style="border: 1px solid #ddd; border-collapse: collapse; padding: 5px 8px;">{{ date_format(date_create($booking->BookingFrom), 'd/m/Y') }} - {{ date_format(date_create($booking->BookingTo), 'd/m/Y') }}</td>
                        <td style="border: 1px solid #ddd; border-collapse: collapse; padding: 5px 8px;">{{ ($booking->booking_occupants->count()) }}</td>
                        <td style="border: 1px solid #ddd; border-collapse: collapse; padding: 5px 8px;">1</td>
                        <td style="border: 1px solid #ddd; border-collapse: collapse; padding: 5px 8px;">PKR {{ number_format($room->pivot->room_charges_onbooking , 0) }} x {{$booking->invoice->nights}} nights</td>

                    </tr>
                    

                    <?php if ($room->pivot->additional_guest_charges > 0) { ?>
                    <tr style="text-align:center">
                        <td style="border: none !important; padding: 5px 8px;" colspan="4">Additional Guest Charges: <?php echo $room->pivot->additional_occupants . ' @ ' . $room->pivot->additional_guest_rate; ?></td>
                        <td class="" style="background: #f5f5f5; border: 1px solid #ddd; border-collapse: collapse; padding: 5px 8px;">PKR {{ number_format($room->pivot->additional_guest_charges, 0) }}</td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td style="border: none !important; padding: 5px 8px;" colspan="4">Sub Total: </td>
                        <td class="" style="text-align:center;background: #f5f5f5; border: 1px solid #ddd; border-collapse: collapse; padding: 5px 8px;"><b style="font-size: 15px;">PKR {{ number_format($room->pivot->room_charges_onbooking , 0) }}</b></td>
                    </tr>
                    @endforeach

                    <?php
                        $show_discount = true;

                        foreach ($booking->rooms as $r) {
                            if ($r->pivot->room_charges != $r->pivot->room_charges_onbooking) {
                                $show_discount = false;
                                break;
                            }
                        }
                    ?>

                    <?php if ($booking->invoice->discount_amount > 0 && $show_discount) { ?>
                        
                    <tr style="text-align:center">
                        <td style="border: none !important; padding: 5px 8px;" colspan="4">Discount:</td>
                        <td class="" style="background: #f5f5f5; border: 1px solid #ddd; border-collapse: collapse; padding: 5px 8px;">PKR {{ number_format($booking->invoice->discount_amount, 0) }}</td>
                    </tr>
                    <?php } ?>

                    <?php if ($booking->invoice->promo_id > 0) { ?>
                    <tr style="text-align:center">
                        <td style="border: none !important; padding: 5px 8px;" colspan="4">Promo Discount:</td>
                        <td class="" style="background: #f5f5f5; border: 1px solid #ddd; border-collapse: collapse; padding: 5px 8px;">PKR {{ number_format($booking->invoice->promo_value, 0) }}</td>
                    </tr>
                    <?php } ?>

                    <?php if ($booking->invoice->tax_rate_id > 0) { ?>
                    <tr style="text-align:center">
                        <td style="border: none !important; padding: 5px 8px;text-align:left;" colspan="4">Tax ({{$booking->invoice->tax_name}} {{$booking->invoice->tax_rate}}%):</td>
                        <td class="" style="background: #f5f5f5; border: 1px solid #ddd; border-collapse: collapse; padding: 5px 8px;">PKR {{ number_format($booking->invoice->tax_charges, 0) }}</td>
                    </tr>
                    <?php } ?>

                    <tr>
                        <td style="border: none !important; padding: 5px 8px;" colspan="4">Grand Total (in words) Rupees {{ $in_words }} Only</td>
                        <td class="" style="text-align:center;background: #f5f5f5; border: 1px solid #ddd; border-collapse: collapse; padding: 5px 8px;"><b style="font-size: 15px;">PKR {{ number_format($booking->invoice->net_total, 0) }}</b></td>
                    </tr>
                </table>
                {{-- <p style="margin: 0;font-size: 11px;">*All prices are inclusive of tax</p> --}}
                @if ($booking->status == 'CheckedIn')
                <div class="ComplainViewbtn">
                    <p style="margin: 10px 0 0;">For any complain or to request a service. Click on the button below!</p>
                    <a href="{{url('cportal') . '/' . $booking->booking_code}}" style="border: none;background: #4caf50;padding: 5px 10px;color: #fff;cursor: pointer;font-weight: 400;margin: 5px 0;text-decoration: none;display: inline-block;">
                        Customer Portal
                    </a>
                </div>
                @endif
            </div>
        </div>
        <br /> <br />
    </div>
</body>

</html>