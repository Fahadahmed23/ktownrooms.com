<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'>
<script src='https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Use the latest (edge) version of IE rendering engine -->
    <meta name="x-apple-disable-message-reformatting">
    <!-- Disable auto-scale in iOS 10 Mail entirely -->
    <title>Welcome - [Plain HTML]</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,500" rel="stylesheet">
    <style>
        html,
        body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
        }
        /* What it does: Stops email clients resizing small text. */
        
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }
        /* What it does: Centers email on Android 4.4 */
        
        div[style*="margin: 16px 0"] {
            margin: 0 !important;
        }
        /* What it does: Stops Outlook from adding extra spacing to tables. */
        
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }
        
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }
        
        table table table {
            table-layout: auto;
        }
        
        img {
            -ms-interpolation-mode: bicubic;
        }
        
        *[x-apple-data-detectors],
        /* iOS */
        
        .x-gmail-data-detectors,
        /* Gmail */
        
        .x-gmail-data-detectors *,
        .aBn {
            border-bottom: 0 !important;
            cursor: default !important;
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }
        
        .a6S {
            display: none !important;
            opacity: 0.01 !important;
        }
        
        img.g-img+div {
            display: none !important;
        }
        /* What it does: Prevents underlining the button text in Windows 10 */
        
        .button-link {
            text-decoration: none !important;
        }
        
        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
            .email-container {
                min-width: 375px !important;
            }
        }
    </style>
    <style>
        .button-td,
        .button-a {
            transition: all 100ms ease-in;
        }
        
        .button-td:hover,
        .button-a:hover {
            background: #555555 !important;
            border-color: #555555 !important;
        }
        /* Media Queries */
        
        @media screen and (max-width: 480px) {
            .fluid {
                width: 100% !important;
                max-width: 100% !important;
                height: auto !important;
                margin-left: auto !important;
                margin-right: auto !important;
            }
            .stack-column,
            .stack-column-center {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                direction: ltr !important;
            }
            /* And center justify these ones. */
            .stack-column-center {
                text-align: center !important;
            }
            .center-on-narrow {
                text-align: center !important;
                display: block !important;
                margin-left: auto !important;
                margin-right: auto !important;
                float: none !important;
            }
            table.center-on-narrow {
                display: inline-block !important;
            }
            .email-container p {
                font-size: 17px !important;
                line-height: 22px !important;
            }
        }
    </style>
</head>

<body width="100%" bgcolor="#F1F1F1" style="margin: 0; ">
    <center style="width: 100%; background: #F1F1F1; text-align: left;">
        <!-- <div style="display:none;font-size:1px;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;mso-hide:all;font-family: sans-serif;"> (Optional) This text will appear in the inbox preview, but not the email body. </div> -->
        <div style="max-width: 680px; margin: auto;" class="email-container">
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 680px;" class="email-container">
                <tr>
                    <td bgcolor="#3f51b5">
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tr>
                                <td style="padding: 30px 40px 30px 40px; text-align: center;"><img src="https://www.ktownrooms.com/resources/assets/web/img/logo.png"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td background="" bgcolor="#222222" align="center" valign="top" style="text-align: center; background-position: center center !important; background-size: cover !important;">
                        <div>
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" align="center" width="100%" style="max-width:500px; margin: auto;">
                                <tr>
                                    <td height="20" style="font-size:20px; line-height:20px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center" valign="middle">
                                        <table>
                                            <tr>
                                                <td valign="top" style="text-align: center; padding: 60px 0 10px 20px;">
                                                    <h4 style="margin: 0; font-family: 'Montserrat', sans-serif;   color: #ffffff; font-weight: bold;">Welcome to Ktown Rooms!</h4>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td valign="top" style="text-align: center; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #fff;">
                                                    <p style="margin: 0;"></p>
                                                    <p>Dear {{$user->name}}, your password on
                                                        <a style="color:#fff;" href="{{site_url()}}">Ktown</a> is : {{$password}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td valign="top " align="center " style="text-align: center; padding: 15px 0px 60px 0px; ">
                                                    <center>
                                                        <table role="presentation " align="center " cellspacing="0 " cellpadding="0 " border="0 " class="center-on-narrow " style="text-align: center; ">
                                                            <tr>
                                                                <td style="border-radius: 50px; background: #3f51b5; text-align: center; " class="button-td ">
                                                                    <a href="{{site_url()}} " style="background: #3f51b5; border: 15px solid #3f51b5; font-family: 'Montserrat', sans-serif; font-size: 14px; line-height: 1.1; text-align: center; text-decoration:
                                                            none; display: block; border-radius: 50px; font-weight: bold; " class="button-a "> <span style="color:#ffffff; " class="button-link ">ACCESS ACCOUNT</span> </a>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </center>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="20 " style="font-size:20px; line-height:20px; ">&nbsp;</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>

                <!-- INTRO : END -->
                <!-- CTA : BEGIN -->

            </table>
        </div>
    </center>
</body>

</html>
