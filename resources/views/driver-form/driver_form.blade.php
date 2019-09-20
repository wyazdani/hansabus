@extends('layouts.pdf')

@section('content')

<table id="table" align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="color: #333;font-size: 8px;">
    <tbody>
    <tr>
        <td>
            <table style="padding: 5px 0 5px!important;">
                <tr>
                    <td class="left" width="70%">
                        <table>
                            <tr>
                                <td></td>
                            </tr>
                            <tr>
                                <td  class="bg-color">
                                    <table style="padding: 5px 0">
                                        <tr style="display: block;color: #000;font-size: 10px;font-weight: bold;">
                                            <td>{{__('tour.travel_order')}}</td>
                                            <td>{!! $number !!}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td >
                                    <table style="padding: 2px 0">
                                        <tr style="display: block;color: #000;font-size: 8px;font-weight: bold;">
                                            <td>{{__('tour.driver')}}:</td>
                                            <td>{!! !empty($driver)?$driver->driver_name:'None' !!}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td >
                                    <table style="padding: 2px 0">
                                        <tr style="display: block;color: #000;font-size: 8px;font-weight: bold;">
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td >
                                    <table style="padding: 2px 0">
                                        <tr style="display: block;color: #000;font-size: 8px;font-weight: bold;">
                                            <td>{{__('tour.passengers')}}:</td>
                                            <td>{!! $tour->passengers !!}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td >
                                    <table style="padding: 2px 0">
                                        <tr style="display: block;color: #000;font-size: 8px;font-weight: bold;">
                                            <td>{{__('tour.days')}} :</td>
                                            <td>{!! (strtotime($tour->to_date)-strtotime($tour->from_date))/86400 !!}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td >
                                    <table style="padding: 2px 0">
                                        <tr style="display: block;color: #000;font-size: 8px;font-weight: bold;">
                                            <td>{{__('tour.vehicle')}} :</td>
                                            <td>{!! $tour->vehicle->name !!}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td  class="bg-color">
                                    <table style="padding: 5px 0">
                                        <tr style="display: block;color: #000;font-size: 8px;font-weight: bold;">
                                            <td>{{__('tour.customer')}} :</td>
                                            <td>{!! $tour->customer->address !!}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td >
                                    <table style="padding: 2px 0">
                                        <tr style="display: block;color: #000;font-size: 8px;font-weight: bold;">
                                            <td>{{__('tour.travel_date')}} :</td>
                                            <td>{!! date("d.m.Y",strtotime($tour->from_date)) !!}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td >
                                    <table style="padding: 2px 0">
                                        <tr style="display: block;color: #000;font-size: 8px;font-weight: bold;">
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td >
                                    <table style="padding: 2px 0">
                                        <tr style="display: block;color: #000;font-size: 8px;font-weight: bold;">
                                            <td>{{__('tour.deployment')}} :</td>
                                            <td>{!! date("d.m.Y",strtotime($tour->from_date)) !!}</td>
                                            <td></td>
                                            <td>{{__('tour.clock')}} </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td >
                                    <table style="padding: 2px 0">
                                        <tr style="display: block;color: #000;font-size: 8px;font-weight: bold;">
                                            <td>{{__('tour.from_customer')}} :</td>
                                            <td>{!! date("d.m.Y",strtotime($tour->from_date)) !!}</td>
                                            <td></td>
                                            <td>{{__('tour.clock')}}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            {{--<tr>
                                <td >
                                    <table style="padding: 2px 0">
                                        <tr style="display: block;color: #000;font-size: 8px;font-weight: bold;">
                                            <td>Ankunft :</td>
                                            <td>01.08.2019</td>
                                            <td></td>
                                            <td>Uhr</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>--}}
                            {{--<tr>
                                <td >
                                    <table style="padding: 2px 0">
                                        <tr style="display: block;color: #000;font-size: 8px;font-weight: bold;">
                                            <td>Abfahrt :</td>
                                            <td>01.08.2019</td>
                                            <td></td>
                                            <td>Uhr</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>--}}
                            <tr>
                                <td >
                                    <table style="padding: 2px 0">
                                        <tr style="display: block;color: #000;font-size: 8px;font-weight: bold;">
                                            <td>{{__('tour.travel_end')}} :</td>
                                            <td>{!! date("d.m.Y",strtotime($tour->to_date)) !!}</td>
                                            <td></td>
                                            <td>{{__('tour.clock')}}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                        </table>
                    </td>
                    <td width="30%">
                        <div class="right" style=";width: 200px;float: right;text-align: left;">
                            <span style="display: block;background: #fff;width: 100%;">
                                <img width="120px" src="https://crm.hansabus.com/images/hansa_logo_colored.png" alt="">
                            </span><br>
                            <strong style="font-size: 9px;"><span>Tel:</span></strong><span>  040/521 580 81</span><br>
                            <strong style="font-size: 7.5px;">Fax:</strong><span> 040/ 521 580 82</span><br>
                            <strong style="font-size: 7.5px;">E-Mail:</strong><span>info@ hansebus.com</span><br>
                            <strong style="font-size: 7.5px;">www:</strong><span>www. hansebus.com</span><br><br>
                            {{--<strong style="display: block;color: #000;font-size: 8px;text-decoration: underline;">Bei Rückfragen bitte angeben</strong><br>
                            <strong style="display: block;color: #000;font-size: 7.5px;">Rechnung Nr.</strong><strong style="display: block;color: #000;font-size: 7.5px;">R20193760</strong><br>
                            <span style="display: block;color: #000;font-size: 7px;">Rechnungsdatum:</span><span style="display: block;color: #000;font-size: 7.5px;">01.08.2019</span><br>
                            <span style="display: block;color: #000;font-size: 7px;">Kunden Nr.</span><span style="display: block;color: #000;font-size: 7.5px;">17383</span><br>
                            <span style="display: block;color: #000;font-size: 4px;">Früher ausgestellte Rechnungen mit gleicher Nummer sind ungültig!.</span><br>--}}
                        </div>
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
                                    <td  class="bg-color">
                                        <table style="padding: 5px 0">
                                            <tr style="display: block;color: #000;font-size: 10px;font-weight: bold;text-align: left">
                                                <td>{{__('tour.details_of_ride')}} ! </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td >
                                        <table style="padding: 4px 0;text-align: left">
                                            <tr style="display: block;color: #000;font-size: 8px;font-weight: bold;">
                                                <td style="text-align: right;width: 20%">{{__('tour.km_level_end')}} :</td>
                                                <td style="border-bottom: 1px solid #ccc;width: 30%"></td>
                                                <td style="text-align: right;width: 20%">{{__('tour.km_level_begining')}}:</td>
                                                <td style="border-bottom: 1px solid #ccc;width: 30%"></td>
                                            </tr>
                                            <tr style="display: block;color: #000;font-size: 8px;font-weight: bold;">
                                                <td style="text-align: right;width: 20%">{{__('tour.km_total')}} :</td>
                                                <td style="border-bottom: 1px solid #ccc;width: 30%"></td>
                                                <td style="text-align: right;width: 20%">{{__('tour.use_beginning')}}:</td>
                                                <td style="border-bottom: 1px solid #ccc;width: 30%"></td>
                                            </tr>
                                            <tr style="display: block;color: #000;font-size: 8px;font-weight: bold;">
                                                <td style="text-align: right;width: 20%">{{__('tour.operation_clock')}} :</td>
                                                <td style="border-bottom: 1px solid #ccc;width: 30%"></td>
                                                <td style="text-align: right;width: 20%">{{__('tour.promoted_persons')}}:</td>
                                                <td style="border-bottom: 1px solid #ccc;width: 30%"></td>
                                            </tr>
                                            <tr style="display: block;color: #000;font-size: 8px;font-weight: bold;">
                                                <td style="text-align: right;width: 20%">{{__('tour.expenses')}} :</td>
                                                <td style="border-bottom: 1px solid #ccc;width: 30%"></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table style="padding: 5px 0">
                                            <tr style="display: block;color: #000;font-size: 10px;font-weight: bold;text-align: left">
                                                <td>{{__('tour.details_of_ride')}} ! </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td >
                                        <table style="padding: 4px 0;text-align: left">
                                            <tr style="display: block;color: #000;font-size: 8px;font-weight: bold;">
                                                <td style="border-bottom: 1px solid #ccc;"></td>
                                                <td>{{__('tour.kilometre')}} </td>
                                                <td style="border-bottom: 1px solid #ccc;"></td>
                                                <td>{{__('tour.hours')}}   </td>
                                            </tr>
                                            <tr style="display: block;color: #000;font-size: 8px;font-weight: bold;">
                                                <td style="border-bottom: 1px solid #ccc;"></td>
                                                <td>{{__('tour.pollution')}} </td>
                                                <td style="border-bottom: 1px solid #ccc;"></td>
                                                <td>{{__('tour.customer_signature')}}  </td>
                                            </tr>

                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td  class="bg-color">
                                        <table style="padding: 5px 0">
                                            <tr style="display: block;color: #000;font-size: 9px;font-weight: bold;text-align: left">
                                                <td>{{__('tour.miles_traveled_abroad')}}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td >
                                        <table style="padding: 4px 0;text-align: left">
                                            <tr style="display: block;color: #000;font-size: 8px;font-weight: bold;">
                                                <td style="text-align: right;width: 20%">{{__('tour.country')}} :</td>
                                                <td style="border-bottom: 1px solid #ccc;width: 30%"></td>
                                                <td style="text-align: right;width: 20%">{{__('tour.country')}}:</td>
                                                <td style="border-bottom: 1px solid #ccc;width: 30%"></td>
                                            </tr>
                                            <tr style="display: block;color: #000;font-size: 8px;font-weight: bold;">
                                                <td style="text-align: right;width: 20%">{{__('tour.km_driveway')}} :</td>
                                                <td style="border-bottom: 1px solid #ccc;width: 30%"></td>
                                                <td style="text-align: right;width: 20%">{{__('tour.km_driveway')}} :</td>
                                                <td style="border-bottom: 1px solid #ccc;width: 30%"></td>
                                            </tr>
                                            <tr style="display: block;color: #000;font-size: 8px;font-weight: bold;">
                                                <td style="text-align: right;width: 20%"> {{__('tour.km_exit')}} :</td>
                                                <td style="border-bottom: 1px solid #ccc;width: 30%"></td>
                                                <td style="text-align: right;width: 20%"> {{__('tour.km_exit')}}:</td>
                                                <td style="border-bottom: 1px solid #ccc;width: 30%"></td>
                                            </tr>
                                            <tr style="display: block;color: #000;font-size: 8px;font-weight: bold;">
                                                <td style="text-align: right;width: 20%">{{__('tour.total_km')}} :</td>
                                                <td style="border-bottom: 1px solid #ccc;width: 30%"></td>
                                                <td style="text-align: right;width: 20%">{{__('tour.total_km')}} :</td>
                                                <td style="border-bottom: 1px solid #ccc;width: 30%"></td>
                                            </tr>
                                        </table>
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
                <p>{{__('tour.faq_details')}}</p><br><br><br><br>
            </td>
        </tr>
        <tr>
            <td  class="bg-color">
                <table style="padding: 5px 0">
                    <tr style="display: block;color: #000;font-size: 10px;font-weight: bold;text-align: left">
                        <td>{{__('tour.driver_messages')}} </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td>
                <table>
                    <tr style="display: block;color: #000;font-size: 8px;text-align: left">
                        <td>{!! $details !!} </td>
                    </tr>

                </table>
            </td>
        </tr>
        <tr>
            <td class="left">
                <table style="padding: 30px 0 0;">
                    <tr>
                        <td>
                            <table style="padding: 10px 0 0;border-top: 1px solid #000;">
                                <tr>
                                    <td class="left">
                                        @include('layouts.print_footer')
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
