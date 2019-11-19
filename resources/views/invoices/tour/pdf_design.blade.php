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
                    <strong style="font-size: 9px"><i>Invoice</i></strong>
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
                    <strong style="font-size: 8px;"><span>{{ __('tour_invoice.invoice_date') }}:</span></strong><span>{!! date("d.m.Y",strtotime($invoice->created_at)) !!}</span><br>
                    <strong style="font-size: 8px;">{{__('tour.invoice_number')}}:</strong><span>T{!! $invoice->id !!}/-{!! date('y',strtotime($invoice->created_at))!!}</span><br>
                    <strong style="font-size: 8px;">{{ __('service.customer') }}:</strong><span>{!! $customer->name !!}</span><br>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<div class="body">
    <table id="table"  align="left" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;color: #333;font-size: 8px;">
        <tr>
            <td>
                <table id="table" cellspacing="0" cellpadding="5" >
                    <thead>
                    <tr class="header">
                        <th>{{__('tour_invoice.date_of_service')}}</th>
                        <th style="line-height: 20px">Tour-Id </th>
                        <th style="line-height: 20px">{{ __('tour.customer') }}</th>
                        <th>{{ __('tour_invoice.departure_time') }}</th>
                        <th style="line-height: 20px">{{ __('tour.from') }}</th>
                        <th style="line-height: 20px">{{ __('tour.to') }}</th>
                        <th style="line-height: 20px">{{ __('tour.price') }}</th>
                        <th style="line-height: 20px">{{__('tour_invoice.gross')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tour as $t)
                        <tr class="left">
                            <td style="border-bottom: 0.5px solid #ccc">Hansa Bustouristik {{date("d.m.Y",strtotime($t->from_date)) }}</td>
                            <td style="border-bottom: 0.5px solid #ccc"> {{ !empty($t->custom_tour_id)?$t->custom_tour_id:'T '.$t->id  }}</td>
                            <td style="border-bottom: 0.5px solid #ccc">Nr. {{ $customer->id  }}</td>
                            <td style="border-bottom: 0.5px solid #ccc">{{ date("H:i:s",strtotime($t->from_date)) }} Uhr</td>
                            <td style="border-bottom: 0.5px solid #ccc">{{ $t->from_address }}</td>
                            <td style="border-bottom: 0.5px solid #ccc">{{ $t->to_address }}</td>
                            <td style="border-bottom: 0.5px solid #ccc">{{ $t->price }}</td>
                            <td style="border-bottom: 0.5px solid #ccc">{{ $t->price }} € </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="4" align="right" style="border-top: 0.5px solid #ccc;">{{__('tour_invoice.included_in_value')}}:</th>
                        <th colspan="3" align="right" style="border-top: 0.5px solid #ccc;">{{__('tour.total_amount')}} </th>
                        <th colspan="1" align="left" bgcolor="#f5f5f5" style="border-top: 0.5px solid #ccc"><b>{{ $total }} €</b></th>
                    </tr>
                    <tr>
                        <th colspan="4" align="right" style="border-top: 0.5px solid #ccc;">{{__('tour_invoice.vat')}} {!! $invoice->vat !!}% <b>@if(!empty($vat)) {{$vat}} € @endif </b> </th>
                        <th colspan="3" align="right" style="border-top: 0.5px solid #ccc;">+ {{__('tour_invoice.value_added')}} </th>
                        <th colspan="1" align="left" bgcolor="#f5f5f5" style="border-top: 0.5px solid #ccc"><b>@if(!empty($vat)) {{$vat}} @endif €</b></th>
                    </tr>
                    <tr bgcolor="#f5f5f5">
                        <th colspan="7" align="right" style="font-size: 8.5px;border-top: 1px solid #ccc"><b>{{__('tour_invoice.invoice_amount')}}</b></th>
                        <th colspan="1" align="left" style="font-size: 8.5px;border-top: 0.5px solid #ccc;border-left: 0.5px solid #ccc"><b>@if(!empty($total)) {{$total + $vat}} @endif €</b></th>
                    </tr>
                    </tfoot>
                </table>
            </td>
        </tr>
        <tr>
            <td><br><br><br><br><br>
                <span><b>Note:</b> {{ __('tour_invoice.invoice_footer_line1') }}.</span><br><br>
                <span>{{ __('tour_invoice.invoice_footer_line2') }}</span>
                <br><br><br><br><br><br>
                <strong>{{__('tour_invoice.yours_sincerely')}},</strong><br><br>
                <span>Mit freundlichen Grüßen</span><br>
                <span>iA Alizada</span><br>
                <span><b>Mobile tel.</b> 0173/94 80 246</span><br>
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
