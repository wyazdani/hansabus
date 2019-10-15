<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="noindex,nofollow">
    <meta name="x-apple-disable-message-reformatting">
    <title></title>
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i" rel="stylesheet">
</head>
<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly;font-family: 'Montserrat', sans-serif;font-size: 13px;line-height: 1.8;color: #000;">
<center style="width: 100%; background-color: #fff;">
    <div style="display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
    </div>
    <div style="max-width: 900px; margin: 0 auto;
           background-size: cover;background-position: center center;background-repeat: no-repeat;" class="email-container">
        <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;color: #fff;">
            @include('mail.header')
            <tr>
                <td>
                    <table style="width: 100%;">
                        <tbody><tr><td style="padding:50px 15px 0 15px;">
                                <dt style="font-weight: bold; font-size:16px; width: 80%;text-align: left;padding: 5px 15px; color: #000000">
                                    {{ __('offer.offer_no') }} O{!! $offer !!}/-{!! date('y') !!}
                                </dt>
                                <dt style="font-weight: bold; font-size:16px; width: 80%;text-align: left;padding: 5px 15px; color: #000000">
                                    Hi {!! $inquiry->name !!},
                                </dt>
                                <dt style="font-weight: normal;width: 80%;text-align: left;padding: 5px 15px; color: #000000">
                                    {{ __('offer.thankyou_for_inquiry') }}.

                                </dt>

                                <dt style="font-weight: bold;width: 80%;text-align: left;padding: 5px 15px; color: #000000">
                                    {{ __('offer.departure_time') }}
                                </dt>
                                <dt style="font-weight: normal;width: 80%;text-align: left;padding: 5px 15px; color: #000000">
                                    {!! !empty($inquiry->inquiryaddresses[0]->time)?date('M j, Y, g:i a',strtotime($inquiry->inquiryaddresses[0]->time)):'' !!}
                                </dt>
                                <dt style="font-weight: bold; font-size:16px; width: 80%;text-align: left;padding: 5px 15px; color: #000000">
                                    {{__('offer.price')}}:
                                </dt>
                                <dt style="font-weight: normal;width: 80%;text-align: left;padding: 5px 15px; color: #000000">
                                    {!! $price!!}
                                </dt>

                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
        @include('mail.footer')
    </div>
</center>
</body>
</html>