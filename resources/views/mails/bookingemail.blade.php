<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="viewport" content="width=device-width">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="telephone=no" name="format-detection">
    <title>Booking Confirmation</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,500" rel="stylesheet">
</head>
<style>
    html,
    body {
        font-family: 'Montserrat', sans-serif;
    }
    .roomtable {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }
    
    .roomtable td,
    .roomtable th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }
    
    .roomtable tr:nth-child(even) {
        background-color: #dddddd;
    }
</style>

<body>
<div class="es-wrapper-color">
<table class="es-wrapper" width="100%">
        <tbody>
        <tr>
        <td class="esd-email-paddings" valign="top">
            <table class="es-header esd-header-popover" align="center">
                <tbody>
                    <tr>
                        <td class="esd-stripe" align="center" esd-custom-block-id="81780">
                            <table class="es-header-body" width="600" bgcolor="#ffffff" align="center">
                                <tbody>
                                    <tr>
                                        <td class="esd-structure es-p10t es-p10b es-p20r es-p20l" align="left" bgcolor="" style="background-color: ;">
                                            <table align="left" class="es-left">
                                                <tbody>
                                                    <tr>
                                                        <td width="270" class="esd-container-frame" align="left">
                                                            <table width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="left" class="esd-block-text es-m-txt-c">
                                                                            <p style=""><img alt="logo" src="https://www.ktownrooms.com/resources/assets/web/img/logo.png"></p>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="esd-structure" align="left">
                                            <table width="100%">
                                                <tbody>
                                                    <tr>
                                                        <td width="600" class="esd-container-frame" align="center" valign="top">
                                                            <table width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="center" class="esd-block-spacer" style="font-size:0">
                                                                            <table border="0" width="100%" height="100%">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td style="border-bottom: 1px solid #cccccc; background:none; height:1px; width:100%; margin:0px 0px 0px 0px;"></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="es-content" align="center">
                <tbody>
                    <tr>
                        <td class="esd-stripe" align="center" esd-custom-block-id="83919">
                            <table class="es-content-body" style="background-" width="600" bgcolor="#ffffff" align="center">
                                <tbody>
                                    <tr>
                                        <td class="esd-structure es-p40t es-p20b es-p40r es-p40l" align="left">
                                            <table width="100%">
                                                <tbody>
                                                    <tr>
                                                        <td class="esd-container-frame" width="520" valign="top" align="center">
                                                            <table width="100%">
                                                                <tbody>
                                                                    <tr>   
                                                                        <td class="esd-block-text es-p20b es-m-txt-l" align="left">
                                                                            <h3 style="margin-bottom: 5px;">Dear {{$booking->FirstName}} {{$booking->LastName}}</h3>
                                                                            <h2 style="margin-top: 0;">Thankyou for booking in KtownRooms!</h2>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <h3 style="color: #6aa38b;margin-top: 0;">Request for booking has been placed with booking id({{$booking->id}}), we'll confirm you our availability soon.</h3>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="esd-structure es-p10t es-p10b es-p20r es-p20l" align="left" bgcolor="" style="background-color: ;">
                                            <table align="left" class="es-left">
                                                <tbody>
                                                    <tr>
                                                        <td width="270" class="esd-container-frame" align="left">
                                                            <table width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="left" class="esd-block-text es-m-txt-c">
                                                                            <h2 style="">Booking # {{$booking->id}}</h2>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <table class="es-content-body roomtable" style="background- text-align:left;" width="600" bgcolor="#ffffff">
                                        <thead>
                                            <th>Rooms</th>
                                            <th>Hotel</th>
                                            <th>Category</th>
                                            <th>Charges</th>
                                        </thead>
                                        <tbody>
                                            @foreach($booking->rooms as $room)
                                            <tr>
                                                <td>{{$room->room_title}}</td>
                                                <td>({{$room->hotel->HotelName}})</td>
                                                <td>{{$room->category->RoomCategory}}</td>
                                                <td>Rs.{{$room->RoomCharges}}</td>
                                            </tr>
                                            @endforeach  
                                        </tbody>
                                    </table>

                                    <tr>
                                        <td class="esd-structure es-p10t es-p10b es-p20r es-p20l" align="left" bgcolor="" style="background-color: ;">
                                            <table class="es-right" align="right">
                                                <tbody>
                                                    <tr>
                                                        <td width="270" class="esd-container-frame" align="left">
                                                            <table width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="right" class="esd-block-text es-m-txt-c" esd-links-color="#ffffff">
                                                                            <p style="">Rs.{{$booking->invoice->total}}</p>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="270" class="esd-container-frame" align="left">
                                                            <table width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="right" class="esd-block-text es-m-txt-c" esd-links-color="#ffffff">
                                                                            <p style="">Rs.{{$booking->invoice->tax_charges}}</p>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="270" class="esd-container-frame" align="left">
                                                            <table width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="right" class="esd-block-text es-m-txt-c" esd-links-color="#ffffff">
                                                                            <p style="">Rs.{{$booking->invoice->discount_amount}}</p>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="270" class="esd-container-frame" align="left">
                                                            <table width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="right" class="esd-block-text es-m-txt-c" esd-links-color="#ffffff">
                                                                            <p style="">Rs.{{$booking->invoice->net_total}}</p>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table align="left" class="es-left">
                                                <tbody>
                                                    <tr>
                                                        <td width="270" class="esd-container-frame" align="left">
                                                            <table width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="left" class="esd-block-text es-m-txt-c" esd-links-color="#ffffff">
                                                                            <p style="">Sub Total</p>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="270" class="esd-container-frame" align="left">
                                                            <table width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="left" class="esd-block-text es-m-txt-c" esd-links-color="#ffffff">
                                                                            <p style="">Tax Chrages</p>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="270" class="esd-container-frame" align="left">
                                                            <table width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="left" class="esd-block-text es-m-txt-c" esd-links-color="#ffffff">
                                                                            <p style="">Discount</p>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="270" class="esd-container-frame" align="left">
                                                            <table width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="left" class="esd-block-text es-m-txt-c" esd-links-color="#ffffff">
                                                                            <p style="">Total</p>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table style="display: ;" class="es-footer" align="center">
                <tbody>
                    <tr>
                        <td class="esd-stripe" align="center" esd-custom-block-id="81788">
                            <table class="es-footer-body" width="600" bgcolor="#ffffff" align="center">
                                <tbody>

                                    <tr>
                                        <td class="esd-structure es-p20t es-p20b es-p20r es-p20l" align="left">
                                            <table align="left" class="es-left">
                                                <tbody>
                                                    <tr>
                                                        <td width="270" class="esd-container-frame es-m-p20b" align="center" valign="top">
                                                            <table width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="left" class="esd-block-image es-m-txt-c" style="font-size:0">
                                                                            <a href="#" target="_blank"><img src="https://www.ktownrooms.com/resources/assets/web/img/logo.png" alt style="display: block;" width="120"></a>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table class="es-right" align="right">
                                                <tbody>
                                                    <tr>
                                                        <td width="270" align="left" class="esd-container-frame">
                                                            <table width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="right" class="esd-block-social es-m-txt-c es-p5t es-p5b" style="font-size:0">
                                                                            <table class="es-table-not-adapt es-social">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td align="center" valign="top" class="es-p10r">
                                                                                            <a target="_blank" href><img title="Facebook" src="https://tlr.stripocdn.email/content/assets/img/social-icons/square-colored/facebook-square-colored.png" alt="Fb" width="32"
                                                                                                    height="32"></a>
                                                                                        </td>
                                                                                        <td align="center" valign="top" class="es-p10r">
                                                                                            <a target="_blank" href><img title="Twitter" src="https://tlr.stripocdn.email/content/assets/img/social-icons/square-colored/twitter-square-colored.png" alt="Tw" width="32"
                                                                                                    height="32"></a>
                                                                                        </td>
                                                                                        <td align="center" valign="top" class="es-p10r">
                                                                                            <a target="_blank" href><img title="Instagram" src="https://tlr.stripocdn.email/content/assets/img/social-icons/square-colored/instagram-square-colored.png" alt="Inst" width="32"
                                                                                                    height="32"></a>
                                                                                        </td>
                                                                                        <td align="center" valign="top">
                                                                                            <a target="_blank" href><img title="Youtube" src="https://tlr.stripocdn.email/content/assets/img/social-icons/square-colored/youtube-square-colored.png" alt="Yt" width="32"
                                                                                                    height="32"></a>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="esd-structure" align="left">
                                            <table width="100%">
                                                <tbody>
                                                    <tr>
                                                        <td width="600" class="esd-container-frame" align="center" valign="top">
                                                            <table width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="center" class="esd-block-spacer" style="font-size:0">
                                                                            <table border="0" width="100%" height="100%">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td style="border-bottom: 1px solid #cccccc; background:none; height:1px; width:100%; margin:0px 0px 0px 0px;"></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="esd-structure es-p20t es-p20b es-p20r es-p20l" align="left">
                                            <table width="100%">
                                                <tbody>
                                                    <tr>
                                                        <td width="560" class="esd-container-frame" align="center" valign="top">
                                                            <table width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="center" class="esd-block-text">
                                                                            <p>© 2017-2019 copyright Ktown Rooms - All rights reserved</br>
                                                                                <a target="_blank" href="https://www.ktownrooms.com/terms-conditions">Terms & Conditions</a> | <a target="_blank" class="unsubscribe" href="https://www.ktownrooms.com/web-privacy-policy">Privacy Policy</a></p>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
        </tr>
        </tbody>
</table>
</div>
</body>

</html>