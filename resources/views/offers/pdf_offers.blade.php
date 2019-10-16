@extends('layouts.pdf')

@section('content')

    <table id="table" align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="color: #333;font-size: 8px;">
        <tbody>
        <tr>
            <td>
                <table>
                    <tr>
                        <td class="left" width="70%">
                            <table>
                                <tr>
                                    <td>
                                        <p></p><br>
                                        <span style="display: block;color: #000;font-size: 8.5px;text-decoration: underline;">
                                        Omnibusbetrieb Inhaber , Alizada Timor Hoisbütteler Dorfstr. 1, 22949 Ammersbek
                                   </span>
                                        <p></p><br>
                                        <span style="display: block;color: #000;font-size: 8px;font-weight: bold"> Ust-IdNr.: DE256517113</span><br>
                                        <span style="display: block;color: #000;font-size: 8px;font-weight: bold"> Hansa Bustouristik</span><br>
                                        <span style="display: block;color: #000;font-size: 8px;font-weight: bold"> Inh. Timor Alizada</span><br>
                                        <span style="display: block;color: #000;font-size: 8px;font-weight: bold"> Hoisbütteler Dorfstraße 1</span><br><br>
                                        <span style="display: block;color: #000;font-size: 8px;font-weight: bold"> D 22949 Ammersbek</span><br>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td width="30%">
                            <table>
                                <tr>
                                    <td>
                                        <div class="right" style=";float: right;text-align: left;">
                                        <span style="display: block;background: #fff;width: 100%;">
                                            <img width="70px" src="images/hansa_logo_colored.png" alt="">
                                        </span><br>
                                            <strong style="font-size: 9px;"><span>Tel:</span></strong><span>  040/521 580 81</span><br>
                                            <strong style="font-size: 7.5px;">Fax:</strong><span> 040/ 521 580 82</span><br>
                                            <strong style="font-size: 7.5px;">E-Mail:</strong><span>info@ hansebus.com</span><br>
                                            <strong style="font-size: 7.5px;">www:</strong><span>www. hansebus.com</span><br><br>
                                            <span style="display: block;color: #000;font-size: 7px;">{{ __('offer.offer_no') }}:</span><span>O{!!  $inquiry->offer->id !!}/-{!! date('Y',strtotime( $inquiry->offer->created_at)) !!}</span><br>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
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
                    <table style="font-size: 12px; padding: 10px 0 0;">
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="left">
                                <strong>{{__('tour_invoice.yours_sincerely')}},</strong>
                                <p>Mit freundlichen Grüßen<br>iA Alizada <br> <strong>Mobile tel.</strong> 0173/94 80 246</p>

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
