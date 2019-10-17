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
                                       <strong style="font-size: 9px;"><span>Tel:</span></strong><span>  (+49)   040 / 521 580 81</span><br>
                                       <strong style="font-size: 7.5px;">Fax:</strong><span> (+49)   040 / 521 580 82</span><br>
                                       <strong style="font-size: 7.5px;">E-Mail:</strong><span>info@ hansebus.com</span><br>
                                       <strong style="font-size: 7.5px;">www:</strong><span>www. hansebus.com</span><br><br>
                                       <span style="display: block;color: #000;font-size: 7px;">{{ __('tour_invoice.invoice_date') }}:</span><span>{!! date("d.m.Y",strtotime($invoice_date)) !!}</span><br>
                                       <span style="display: block;color: #000;font-size: 7px;">{{__('tour.invoice_number')}}:</span><span>T{!! $invoice->id !!}/-{!! date('y') !!}</span><br>
                                       <span style="display: block;color: #000;font-size: 7px;">{{ __('service.customer') }}:</span><span style="display: block;color: #000;font-size: 7.5px;">{!! $customer->name !!}</span><br>
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
                                <tr>
                                    <td class="left">
                                        {{--<span>{{ __('tour_invoice.calculate_as_follows') }}:</span><br><br>--}}
                                        {{--<span>{{ __('tour_invoice.holiday_destination') }} :</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>Miete Waschhalle, Werkstatt, Stellplatz</span><br>--}}
                                        {{--<span>{{ __('tour_invoice.when_to_go') }} :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span>{!! date("d.m.Y",strtotime($tour->from_date)) !!} - {!! date("d.m.Y",strtotime($tour->to_date)) !!}</span><br>--}}
                                        {{--<span>{{ __('tour_invoice.passengers') }} :</span>&nbsp;&nbsp;&nbsp;<span>{!! $tour->passengers !!}</span>--}}<br>
                                    </td>
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
                        <th><strong style="display: block;text-transform: capitalize">{{__('tour_invoice.date_of_service')}}</strong> </th>
                        <th><strong style="display: block;text-transform: capitalize">Tour-ID</strong> </th>
                        <th><strong style="display: block;text-transform: capitalize">{{ __('tour.customer') }}</strong> </th>
                        <th><strong style="display: block;text-transform: capitalize">{{ __('tour_invoice.departure_time') }}</strong> </th>
                        <th><strong style="display: block;text-transform: capitalize">{{ __('tour.from') }}</strong> </th>
                        <th><strong style="display: block;text-transform: capitalize">{{ __('tour.to') }}</strong> </th>
                        <th><strong style="display: block;text-transform: capitalize">{{ __('tour.price') }}</strong> </th>
                        <th><strong style="display: block;text-transform: capitalize">{{__('tour_invoice.gross')}}</strong> </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tour as $t)
                    <tr>
                        <td>Hansa Bustouristik {{date("d.m.Y",strtotime($t->from_date)) }}</td>
                        <td> {{ !empty($t->custom_tour_id)?$t->custom_tour_id:'T '.$t->id  }}</td>
                        <td>Nr. {{ $customer->id  }}</td>
                        <td>{{ date("H:i:s",strtotime($t->from_date)) }} Uhr</td>
                        <td>{{ $t->from_address }}</td>
                        <td>{{ $t->to_address }}</td>
                        <td>{{ $t->price }}</td>
                        <td>{{ $t->price }} €</td>
                    </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="3" style="text-align: left;font-size: 8px;">{{__('tour_invoice.included_in_value')}}:</td>
                        <td colspan="4" style="text-align: left;font-size: 8px;border-top: 0.5px solid #000;">{{__('tour.total_amount')}}</td>
                        <td colspan="4" style="text-align: left;font-size: 8px;border-top: 0.5px solid #000;font-weight: bold;">{{ $total }} €</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: left;font-size: 8px;">{{__('tour_invoice.vat')}} <strong style="float: right">@if(!empty($vat)) {{$vat}} @endif €</strong></td>
                        <td colspan="4" style="text-align: left;font-size: 8px;">+ {{__('tour_invoice.value_added')}}</td>
                        <td colspan="4" style="text-align: left;font-size: 8px;font-weight: bold;">@if(!empty($vat)) {{$vat}} @endif €</td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="2"></td>
                        <td colspan="3" style="text-align: right;font-size: 8px;border-top: 0.5px solid #000;">{{__('tour_invoice.invoice_amount')}}</td>
                        <td colspan="3" style="text-align: left;font-size: 8px;border-top: 0.5px solid #000;font-weight: bold;">@if(!empty($total)) {{$total + $vat}} @endif €</td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="2"></td>
                        <td colspan="3" style="text-align: right;font-size: 8.5px;border-top: 0.5px solid #000;font-weight: bold;">{{__('tour_invoice.payable_amount')}}</td>
                        <td colspan="3" style="text-align: left;font-size: 8.5px;border-top: 0.5px solid #000;font-weight: bold;">@if(!empty($total)) {{$total + $vat}} @endif €</td>
                    </tr>
                    </tfoot>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table style="font-size: 8.5px; padding: 15px 0px;  width:100%">
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
                <table style="font-size: 8.5px; padding: 10px 0 0;">
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
        {{--<tr>
            <td class="left">
                @include('layouts.print_footer')
            </td>
        </tr>--}}
    </table>
</div>
@endsection
