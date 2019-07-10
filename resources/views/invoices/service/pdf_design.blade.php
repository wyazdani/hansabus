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
                                <p><strong>{{__('tour.invoice_number')}}:  </strong>{{  str_pad($service->id, 9, "0", STR_PAD_LEFT) }}</p>
                            </div>
                        </td>
                        <td class="right">
                            <strong style="font-size: 10px;"><span>{{__('tour.customer_information')}}</span></strong>
                            <p>{{ $service->customer }}</p>
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
                                        <td class="left"><strong>{{ __('driver_invoice.invoice_header_line1') }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="left">{{ __('driver_invoice.invoice_header_line2') }}</td>
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
                            <th width="5%"><strong style="font-size: 10px; display: block;text-transform: capitalize" >&nbsp;</strong> </th>
                            <th width="80%"><strong style="font-size: 10px; display: block;text-transform: capitalize" >&nbsp;{{__('service.title')}}</strong> </th>
                            <th width="15%"><strong style="font-size: 10px; display: block;text-transform: capitalize" >&nbsp;{{__('tour.price')}}</strong> </th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $i=1; @endphp
                        @foreach($details as $detail)
                            <tr>
                                <td style="font-size: 12px; border: 0.5px solid #ccc">{{ $i }}</td>
                                <td style="font-size: 12px; border: 0.5px solid #ccc">{{ $service->service->name.' - '.$detail['title'] }}</td>
                                <td style="font-size: 12px; border: 0.5px solid #ccc">{{ $detail['price'] }}</td>
                            </tr>
                        @php $i++; @endphp
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="2" style="font-size: 12px; border: 0.5px solid #ccc; text-align: right !important;">{{__('driver_invoice.vat')}}</td>
                            <td colspan="1" style="font-size: 12px; border: 0.5px solid #ccc;font-weight: bold;"> @if(!empty($vat)) {{$vat}} €@endif</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: right;font-size: 12px; border: 0.5px solid #ccc; text-align: right !important;">{{__('tour.total_amount')}}</td>
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
                                <table style=" width:100%">
                                    <tr>
                                        <td class="left">{{ __('driver_invoice.invoice_footer_line1') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="left">{{ __('driver_invoice.invoice_footer_line2') }}</td>
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
                    <table style="padding: 50px 0 0;" width="100%">
                        <tr>
                            <td>
                                <table style="padding: 10px 0 0;border-top: 1px solid #ccc;" width="100%">
                                    <tr>
                                        <td class="left" width="35%">
                                            <strong>Hansa Bustouristik</strong> <br>
                                            Omnibusbetrieb <br>
                                            Inhaber , Alizada Timor <br>
                                            Hoisbütteler Dorfstr. 1, 22949 Ammersbek <br>
                                            <strong>Ust-IdNr.:</strong> DE256517113/
                                        </td>
                                        <td class="left" width="33%">
                                            www. hansebus.com<br>
                                            info@ hansebus.com<br>
                                            <strong>Tel :</strong>  040/521 580 81<br>
                                            <strong>Fax :</strong>  040/ 521 580 82<br>
                                            <strong>Steuer.- Nr. :</strong>  30/001/06020
                                        </td>
                                        <td class="left" width="32%">
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
