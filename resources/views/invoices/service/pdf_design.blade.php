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
                                            <span style="display: block;color: #000;font-size: 7px;">{{ __('tour_invoice.invoice_date') }}:</span><span>{!! date("d.m.Y",strtotime($invoice_date)) !!}</span><br>
                                            <span style="display: block;color: #000;font-size: 7px;">{{__('tour.invoice_number')}}:</span><span>B{!! $service->id !!}/-{!! date('y') !!}</span><br>
                                            <span style="display: block;color: #000;font-size: 7px;">{{ __('service.customer') }}:</span><span style="display: block;color: #000;font-size: 7.5px;">{!! $service->customer !!}</span><br>
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
            <td>
                <table style="font-size: 8px;padding: 15px 0px;">
                    <tr>
                        <td>
                            <table style="padding: 2px;">
                                <tr>
                                    <td class="left"><strong style="font-size: 12px;font-style: italic;">{{ __('tour_invoice.invoice') }}</strong></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="left" >
                <table id="table" style="padding: 5px 5px;font-size: 7.5px;">
                    <thead>
                    <tr class="header">
                        <th><strong style="display: block;text-transform: capitalize">&nbsp;</strong> </th>
                        <th><strong style="display: block;text-transform: capitalize">{{__('service.type')}}</strong> </th>
                        <th><strong style="display: block;text-transform: capitalize">{{__('service.title')}}</strong> </th>
                        <th><strong style="display: block;text-transform: capitalize">{{__('tour.price')}}</strong> </th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $i=1; @endphp
                    @foreach($details as $detail)
                        <tr>
                            <td> @if ($service->type_id==1) {!! 'BS'.$i !!} @else {!! 'OS'.$i !!} @endif</td>
                            <td>{{ $service->service->name }}</td>
                            <td>{{ $detail['title'] }}</td>
                            <td>{{ $detail['price'] }}</td>
                        </tr>
                        @php $i++; @endphp
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="2" style="text-align: left;font-size: 8px;">{{__('tour_invoice.included_in_value')}}:</td>
                        <td colspan="1" style="text-align: left;font-size: 8px;border-top: 0.5px solid #000;">{{__('tour.total_amount')}}</td>
                        <td colspan="1" style="text-align: left;font-size: 8px;border-top: 0.5px solid #000;font-weight: bold;">{{ $total }} €</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: left;font-size: 8px;">{{__('tour_invoice.vat')}} <strong style="float: right">@if(!empty($vat)) {{$vat}} @endif €</strong></td>
                        <td colspan="1" style="text-align: left;font-size: 8px;">+ {{__('tour_invoice.value_added')}}</td>
                        <td colspan="1" style="text-align: left;font-size: 8px;font-weight: bold;">@if(!empty($vat)) {{$vat}} @endif €</td>
                    </tr>
                    <tr>
                        <td colspan="1"></td>
                        <td colspan="1"></td>
                        <td colspan="1" style="text-align: right;font-size: 8px;border-top: 0.5px solid #000;">{{__('tour_invoice.invoice_amount')}}</td>
                        <td colspan="1" style="text-align: left;font-size: 8px;border-top: 0.5px solid #000;font-weight: bold;">@if(!empty($total)) {{$total + $vat}} @endif €</td>
                    </tr>
                    <tr>
                        <td colspan="1"></td>
                        <td colspan="1"></td>
                        <td colspan="1" style="text-align: right;font-size: 8.5px;border-top: 0.5px solid #000;font-weight: bold;">{{__('tour_invoice.payable_amount')}}</td>
                        <td colspan="1" style="text-align: left;font-size: 8.5px;border-top: 0.5px solid #000;font-weight: bold;">@if(!empty($total)) {{$total + $vat}} @endif €</td>
                    </tr>
                    </tfoot>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table style="font-size: 12px; padding: 15px 0px;  width:100%">
                    <tr>
                        <td>
                            <table style="padding: 2px;  width:100%">
                                <tr>
                                    <td class="left">{{ __('tour_invoice.invoice_footer_line1') }}</td>
                                </tr>
                                <tr>
                                    <td class="left">{{ __('tour_invoice.invoice_footer_line2') }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="left">
                <table style="font-size: 12px; padding: 10px 0 0;">
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
