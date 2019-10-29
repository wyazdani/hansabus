@extends('layouts.pdf')

@section('content')

<div style="font-size: 8px;">
    <table id="table" align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="color: #333;font-size: 8px;">
        <tbody>
        <tr>
            <td class="left" style="width: 70% !important;">
                <div class="left">
                    <span style="text-decoration: underline;text-indent: 0;">Omnibusbetrieb Inhaber , Alizada Timor Hoisbütteler Dorfstr. 1, 22949 Ammersbek</span><br><br><br>
                    <strong>Ust-IdNr.</strong><br>
                    <strong>Hansa Bustouristik DE256517113</strong><br>
                    <strong>Inh. Timor Alizada</strong><br>
                    <strong>Hoisbütteler Dorfstraße 1</strong><br><br>
                    <strong>D 22949 Ammersbek</strong><br><br><br>
                </div>
            </td>
            <td class="right" style="width: 30% !important;">
                <div class="right" style="text-align: left !important;">
            <span style="display: block;background: #fff;width: 100%;">
                <img width="120px" src="https://crm.hansabus.com/images/hansa_logo_colored.png" alt="">
            </span><br><br>
                    <strong style="font-size: 8px;"><span>Tel:</span></strong><span> (+49)   040 / 521 580 81</span><br>
                    <strong style="font-size: 8px;">Fax:</strong><span>(+49)   040 / 521 580 82</span><br>
                    <strong style="font-size: 8px;">Notruf-Tel:</strong><span>+49 157 30108363</span><br>
                    <strong style="font-size: 8px;">E-Mail:</strong><span>info@ hansabus.com</span><br>
                    <strong style="font-size: 8px;">www:</strong><span>www. hansabus.com</span><br><br>
                    <strong style="font-size: 8px;"><span>{{ __('offer.offer_no') }}:</span></strong><span>O{!!  $inquiry->offer->id !!}/-{!! date('Y',strtotime( $inquiry->offer->created_at)) !!}</span><br>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<div class="body">
    <table id="table" align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;color: #333;font-size: 8px;">
        <tr>
            <td class="left" >
                <table id="table" style="padding: 5px 5px;font-size: 7.5px;">
                    <tbody>
                    <tr>
                        <th></th>
                        <td></td>
                    </tr>
                    <tr>
                        <th></th>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="2"><hr></td>
                    </tr>

                    <tr>
                        <th><strong style="display: block;text-transform: capitalize">{{__('offer.offer_no')}}</strong> </th>
                        <td>O{!!  $inquiry->offer->id !!}/-{!! date('Y',strtotime( $inquiry->offer->created_at)) !!}</td>
                    </tr>
                    <tr>
                        <th><strong style="display: block;text-transform: capitalize">{{__('offer.customer_name')}}</strong> </th>
                        <td>{!!  $inquiry->name !!}</td>
                    </tr>

                    <tr>
                        <th><strong style="display: block;text-transform: capitalize">{{__('offer.from')}}</strong> </th>
                        <td>{!! $inquiry->inquiryaddresses[0]->from_address !!}</td>
                    </tr>
                    <tr>
                        <th><strong style="display: block;text-transform: capitalize">{{__('offer.to')}}</strong> </th>
                        <td>{!! $inquiry->inquiryaddresses[0]->to_address !!}</td>
                    </tr>
                    <tr>
                        <th><strong style="display: block;text-transform: capitalize">{{__('offer.departure')}}</strong> </th>
                        <td>{!! !empty($inquiry->inquiryaddresses[0]->time)?date('M j, Y, g:i a',strtotime($inquiry->inquiryaddresses[0]->time)):'' !!}</td>
                    </tr>
                    <tr>
                        <th><strong style="display: block;text-transform: capitalize">{{__('offer.arrival')}}</strong> </th>
                        <td>{!! !empty($inquiry->inquiryaddresses[1])?date('M j, Y, g:i a',strtotime($inquiry->inquiryaddresses[1]->time)):'Not Available' !!}</td>
                    </tr>
                    <tr>
                        <th><strong style="display: block;text-transform: capitalize">{{__('offer.type')}}</strong> </th>
                        <td>{!! !empty($inquiry->inquiryaddresses[1])?__('offer.two_way'):__('offer.one_way') !!}</td>
                    </tr>
                    <tr>
                        <th><strong style="display: block;text-transform: capitalize">{{__('offer.price')}}</strong> </th>
                        <td>{!! $inquiry->offer->price !!}</td>
                    </tr>
                    <tr>
                        <th><strong style="display: block;text-transform: capitalize">{{__('offer.comment')}}</strong> </th>
                        <td>{!! $inquiry->offer->comment !!}</td>
                    </tr>

                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td class="left">
                <table style="font-size: 8.5px; padding: 10px 0 0;">
                    <tr>
                        <td class="left">
                            <br><br><br><br><br><br>
                            <strong>{{__('tour_invoice.yours_sincerely')}},</strong><br><br>
                            <span>Mit freundlichen Grüßen</span><br>
                            <span>iA Alizada</span><br>
                            <span><b>Mobile tel.</b> 0173/94 80 246</span><br>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="left">
                @include('layouts.print_footer')
            </td>
        </tr>
    </table>
</div>
@endsection
