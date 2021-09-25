<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{@csrf_token()}}">
    <link rel="stylesheet" href="{{asset('assets/css/toastr.css')}}">
    <title>Document</title>
</head>

<body>
@php
    $date = date('d-m-y h:i:s');
@endphp
    <div class="pos">
        <div class="pos-content">
            <div class="window">
                <div class="subwindow">
                    <div class="subwindow-container">
                        <div class="subwindow-container-fix screens">
                            <div class="receipt-screen screen">
                                <div class="screen-content">

                                    <div class="centered-content">

                                        <div class="button print">
                                            <button id="btnPrint" type="button" class="btn btn-default">Print</button>
                                            <button type="button" class="checkout_btn btn btn-xs btn-warning" data-id="{{$booking->id}}">CheckOut</button>
                                            <button id="btnCancel" class="btn btn-default">Cancel</button>
                                        </div>
                                        <div class="pos-receipt-container">
                                            <div class="pos-sale-ticket"><br><br>
                                                <div class="pos-center-align"><span id="compname">Ktown Rooms & Bookings</span></div><br><span class="boldre">Booking # </span><span class="ordernum">{{$booking->booking_no}}</span>
                                                <br>
                                                <br>
                                                <span class="boldre">Date &amp; Time:</span>{{$date}}
                                                <br>
                                                <br>
                                                <span class="boldre">Customer: </span>{{$booking->customer['FirstName'].' '.$booking->customer['LastName']}}
                                                <br>
                                                <br>
                                                <table class="receipt-orderlines">
                                                    <colgroup>
                                                        <col width="50%">
                                                        <col width="25%">
                                                        <col width="25%">
                                                    </colgroup>
                                                    <thead>
                                                        <tr>
                                                            <th>Room</th>
                                                            <th class="pos-right-align">Night(s)</th>
                                                            <th class="pos-right-align">Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>{{$booking->rooms[0]['room_title']}}</td>
                                                            <td class="pos-right-align">{{$booking->invoice['nights']}}</td>
                                                            <td class="pos-right-align">Rs. {{$booking->invoice['nights'] * $booking->rooms[0]->pivot['room_charges']}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <br>
                                                <table class="receipt-orderlines">
                                                    <colgroup>
                                                        <col width="50%">
                                                        <col width="25%">
                                                        <col width="25%">
                                                    </colgroup>
                                                    <thead>
                                                        <tr>
                                                            <th>Services</th>
                                                            <th class="pos-right-align">count(s)</th>
                                                            <th class="pos-right-align">Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($booking->services as $service)
                                                        <tr>
                                                            <td>{{$service->service_name}}</td>
                                                            <td class="pos-right-align">{{$service->excludes}}</td>
                                                            <td class="pos-right-align">Rs. {{$service->amount}}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <br>
                                                <table class="receipt-total">
                                                    <tbody>
                                                        <tr>
                                                            <td>Discount:</td>
                                                            <td class="pos-right-align">Rs. {{$booking->invoice['discount_amount']}}</td>
                                                        </tr>
                                                       
                                                        @if ($booking->invoice->tax_rate_id > 0)
                                                            
                                                        <tr>
                                                            <td>Tax: <small>({{$booking->invoice->tax_name}}: {{$booking->invoice->tax_rate}} %)</small></td>
                                                            <td class="pos-right-align">Rs. {{$booking->invoice->tax_charges}}</td>
                                                        </tr>
                                                            
                                                        @endif

                                                        @if ($booking->invoice->paid > 0)
                                                        <tr>
                                                            <td>Paid Before:</td>
                                                            <td class="pos-right-align">Rs. {{$booking->invoice->paid}}</td>
                                                        </tr>
                                                       
                                                        <tr>
                                                            <td>Balance:</td>
                                                            <td class="pos-right-align">Rs. {{$booking->invoice->net_total - $booking->invoice->paid}}</td>
                                                        </tr>
                                                        @endif
                                                      
                                                        <tr class="emph">
                                                            <td><span class="boldre">Total:</span></td>
                                                            <td class="pos-right-align"><span class="boldre">Rs. {{$booking->invoice['net_total']}}</span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <br>
                                               <br>
                                                <hr><span class="boldre">User: </span>{{auth()->user()->name}}
                                                <hr>
                                                <div class="pos-center-align thnote">Thank you for your visit</div>
                                                <hr><span style="font-size: 12px;">Software Developed by Manhattan Datanet INC.</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- </body> -->
<script src="{{asset('global_assets/js/main/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/toastr.js')}}"></script>
<script>
    function printReceipt() {
        window.print();
    }

    document.getElementById("btnPrint").onclick = function () {
        printElement(document.getElementById("printThis"));
    }

    function printElement(elem) {
        var domClone = elem.cloneNode(true);
        
        var $printSection = document.getElementById("printSection");
        
        if (!$printSection) {
            var $printSection = document.createElement("div");
            $printSection.id = "printSection";
            document.body.appendChild($printSection);
        }
        
        $printSection.innerHTML = "";
        $printSection.appendChild(domClone);
        window.print();
    }

    $(document).ready(function () {
        $('.checkout_btn').on('click', function() {
            $.post("{{url('bookings/checkout')}}", {
                _token: $("meta[name='csrf-token']").attr('content'),
                booking: {id: $(this).data('id')}
            }).done(function (response) {
                if (response.success) {
                    toastr.success(response.message[0]);

                    // $('#printThis').hide();
                    $('.modal-backdrop').hide();
                } else {
                    toastr.error(response.message[0]);
                }
            }).fail(function (x, s, m) {
                console.log(m);
            })
        });

        $('#btnCancel').on('click', function() {
            // $("#posDetail").modal('hide');
            $('#printThis').hide();
            $('.modal-backdrop').hide();
        });
    });
    </script>
</html>