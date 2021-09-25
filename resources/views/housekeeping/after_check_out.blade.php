<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js"></script>
    <title>Booking Services</title>
</head>
<body>

    <div class="jumbotron text-center">
        @if($booking->status == 'Pending')
            <h3 class="">Thank You!  {{$booking->customer->FirstName .' '.$booking->customer->LastName}} </h3>
            <p class="lead"><strong>For your for booking in Ktown Rooms & Bookings</strong></p>
            <p>Please wait a while for we will confirmed your booking soon</p>
            <hr>
            <p>
              For any query? <a href="https://www.ktownrooms.com/contact" target="_blank">Contact us</a>
            </p>

        @elseif ($booking->status == 'Confirmed')
        
            <h3 class="">Thank You!  {{$booking->customer->FirstName .' '.$booking->customer->LastName}} </h3>
            <p class="lead"><strong>For your for booking in Ktown Rooms & Bookings</strong></p>
            <p>your booking# '{{$booking->booking_no }}' has been confirmed you can avail your room services after checkedIn </p>
            <hr>
            <p>
              For any query? <a href="https://www.ktownrooms.com/contact" target="_blank">Contact us</a>
            </p>
            
        @else
        
            <h3 class="">Thank You!  {{$booking->customer->FirstName .' '.$booking->customer->LastName}} </h3>
            <p class="lead"><strong>For your recent stay with us.</strong></p>
            <p>We hope you enjoyed your stay and will back in future visits</p>
            <hr>
            <p>
              For any query? <a href="https://www.ktownrooms.com/contact" target="_blank">Contact us</a>
            </p>
        @endif
        
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
</html>