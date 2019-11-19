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
            <tr><td style="">
                    <dt style="font-weight: bold; font-size:16px; width: 100%;text-align: left; color: #000000">
                        Hi {!! $inquiry->name !!},
                    </dt>
                    <dt style="font-weight: normal;width: 100%;text-align: left; color: #000000">
                        {{ __('offer.thankyou_for_inquiry') }}.
                    </dt>
                </td>

            </tr>
            <tr>
                <td>
                    <table id="table" style="font-size: 12px;color: #0A160A">
                        <tbody>
                        <tr>
                            <dt><strong style="display: block;text-transform: capitalize">{{__('offer.offer_no')}}</strong> </dt>
                            <td>O{!!  $inquiry->offer->id !!}/-{!! date('Y',strtotime( $inquiry->offer->created_at)) !!}</td>
                        </tr>
                        <tr>
                            <dt><strong style="display: block;text-transform: capitalize">{{__('offer.customer_name')}}</strong> </dt>
                            <td>{!!  $inquiry->name !!}</td>
                        </tr>
                        <tr>
                            <dt><strong style="display: block;text-transform: capitalize">{{__('offer.email')}}</strong> </dt>
                            <td>{!! $inquiry->email!!}</td>
                        </tr>
                        <tr>
                            <dt><strong style="display: block;text-transform: capitalize">{{__('offer.description')}}</strong> </dt>
                            <td>{!! $inquiry->description!!}</td>
                        </tr>
                        <tr>
                            <dt><strong style="display: block;text-transform: capitalize">{{__('offer.from')}}</strong> </dt>
                            <td>{!! $inquiry->inquiryaddresses[0]->from_address !!}</td>
                        </tr>
                        <tr>
                            <dt><strong style="display: block;text-transform: capitalize">{{__('offer.to')}}</strong> </dt>
                            <td>{!! $inquiry->inquiryaddresses[0]->to_address !!}</td>
                        </tr>
                        <tr>
                            <dt><strong style="display: block;text-transform: capitalize">{{__('offer.departure')}}</strong> </dt>
                            <td>{!! !empty($inquiry->inquiryaddresses[0]->time)?date('M j, Y, g:i a',strtotime($inquiry->inquiryaddresses[0]->time)):'' !!}</td>
                        </tr>
                        <tr>
                            <dt><strong style="display: block;text-transform: capitalize">{{__('offer.arrival')}}</strong> </dt>
                            <td>{!! !empty($inquiry->inquiryaddresses[1])?date('M j, Y, g:i a',strtotime($inquiry->inquiryaddresses[1]->time)):'Not Available' !!}</td>
                        </tr>
                        <tr>
                            <dt><strong style="display: block;text-transform: capitalize">{{__('offer.type')}}</strong> </dt>
                            <td>{!! !empty($inquiry->inquiryaddresses[1])?__('offer.two_way'):__('offer.one_way') !!}</td>
                        </tr>
                        <tr>
                            <dt><strong style="display: block;text-transform: capitalize">{{__('offer.price')}}</strong> </dt>
                            <td>{!! $inquiry->offer->price !!}</td>
                        </tr>
                        <tr>
                            <dt><strong style="display: block;text-transform: capitalize">{{__('offer.comment')}}</strong> </dt>
                            <td>{!! $inquiry->offer->comment !!}</td>
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
