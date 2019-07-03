@extends('layouts.pdf')

@section('content')

<table id="table" align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="color: #333;font-size: 12px;">
    <tbody>
    <tr>
        <td>
            <table style="font-size: 12px; padding: 10px 0 10px!important; margin-top: -20px;" width="100%">
                <tr>
                    <td class="left" width="300px">
                        <img width="300px" src="images/hansa_logo.png" >
                        <div class="right" style="padding-right: 10px;">
                            <p><strong>{{__('tour.invoice_date')}}:  </strong>{{ date('d-m-Y') }}</p>
                            <p><strong>{{__('tour.invoice_number')}}:  </strong>{{  str_pad($invoice->id, 9, "0", STR_PAD_LEFT) }}</p>
                        </div>
                    </td>
                    <td class="right">
                        <strong style="font-size: 10px;"><span>{{__('tour.customer_information')}}</span></strong>
                        <p>{{ $customer->name }}</p>
                        @if(!empty($customer->phone))<p>{{ $customer->phone }}</p>@endif
                        @if(!empty($customer->email))<p>{{ $customer->email }}</p>@endif
                        @if(!empty($customer->address))<p>{{ $customer->address }}</p>@endif
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </tbody>
</table>
<div class="body">

    <table id="table" align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
           style="margin: auto; color: #333; font-size: 12px;">
        <tr>
            <td>
                <table style="font-size: 12px;padding: 15px 0px;">
                    <tr>
                        <td>
                            <table style="padding: 2px;">
                                <tr>
                                    <td class="left"><strong>{{ __('tour_invoice.invoice_header_line1') }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="left">{{ __('tour_invoice.invoice_header_line2') }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="left" >
    <table id="table" style="font-size: 10px; padding: 5px 5px; ">
        <thead>
        <tr class="header">
            <th><strong style="display: block;text-transform: capitalize; width: 10%;">{{__('tour_invoice.tour_id')}}</strong> </th>
            <th><strong style="display: block;text-transform: capitalize; width: 20%;">{{__('tour.vehicle')}}</strong> </th>
            <th><strong style="display: block;text-transform: capitalize" width="10%">{{__('tour.from')}}</strong> </th>
            <th><strong style="display: block;text-transform: capitalize" width="10%">{{__('tour.to')}}</strong> </th>
            <th><strong style="display: block;text-transform: capitalize" width="13%">{{__('tour.driver')}}</strong> </th>
            <th><strong style="display: block;text-transform: capitalize" width="5%">{{__('tour.passengers')}}</strong> </th>
            <th><strong style="display: block;text-transform: capitalize" width="10%">{{__('tour.price')}}</strong> </th>
        </tr>
        </thead>
        <tbody>
        @foreach($tours as $tour)
            <tr>
                <td style="border: 0.5px solid #ccc">{{ $tour->id }}</td>
                <td style="border: 0.5px solid #ccc">{{ $tour->vehicle->name }}</td>
                <td style="border: 0.5px solid #ccc">{{ $tour->from_date }}</td>
                <td style="border: 0.5px solid #ccc">{{ $tour->to_date }}</td>
                <td style="border: 0.5px solid #ccc">{{ $tour->driver->driver_name }}</td>
                <td style="border: 0.5px solid #ccc">{{ $tour->passengers }}</td>
                <td style="border: 0.5px solid #ccc">{{ number_format($tour->price) }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="6" style="text-align: right;font-size: 12px; border: 0.5px solid #ccc;">{{__('tour_invoice.vat')}}</td>
            <td colspan="1" style="text-align: left;font-size: 12px; border: 0.5px solid #ccc;font-weight: bold;"> @if(!empty($vat)) {{$vat}} €@endif</td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: right;font-size: 12px; border: 0.5px solid #ccc;">{{__('tour.total_amount')}}</td>
            <td colspan="1" style="text-align: left;font-size: 12px; border: 0.5px solid #ccc;font-weight: bold;"> @if(!empty($total)) {{$total}} €@endif</td>
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
                            <strong>{{__('tour_invoice.yours_sincerely')}}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="left">iA Alizada <br> Mobile tel. 0173/94 80 246</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="left">
                <table style="padding: 50px 0 0;" width="100%">
                    <tr>
                        <td>
                            <table style="padding: 10px 0 0;border-top: 1px solid #ccc;" width="100%">
                                <tr>
                                    <td class="left">
                                        <strong>Hansa Bustouristik</strong> <br>
                                        Omnibusbetrieb <br>
                                        Inhaber , Alizada Timor <br>
                                        Hoisbütteler Dorfstr. 1, 22949 Ammersbek <br>
                                        <strong>Ust-IdNr.:</strong> DE256517113/
                                    </td>
                                    <td class="left">
                                        www. hansebus.com<br>
                                        info@ hansebus.com<br>
                                        <strong>Tel :</strong>  040/521 580 81<br>
                                        <strong>Fax :</strong>  040/ 521 580 82<br>
                                        <strong>Steuer.- Nr. :</strong>  30/001/06020
                                    </td>
                                    <td class="left">
                                        <strong>Bank :</strong>  DAB Bank<br>
                                        <strong>BLZ :</strong>  701 204 00<br>
                                        <strong>Konto Nr. :</strong>  8540743005<br>
                                        <strong>IBAN :</strong>  DE72 7012 0400 8540 7430 05<br>
                                        <strong>BIC :</strong>  DABBDEMMXXX
                                    </td>

                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
@endsection
