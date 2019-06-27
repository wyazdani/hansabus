@extends('layouts.pdf')

@section('content')
    <table id="table" align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="color: #333;font-size: 8px;">
        <tbody>
        <tr>
            <td>
                <table style="padding: 10px 0 10px!important; margin-top: -20px;" width="100%">
                    <tr>
                        <td class="left">
                            <img width="300px" src="images/hansa_logo.png" >

                        </td>
                        <td class="right">
                            <strong style="font-size: 10px;"><span>{{__('tour.customer_information')}}</span></strong>

                            <p>{{ $customer->name }}</p>
                            @if(!empty($customer->phone))<p>{{ $customer->phone }}</p>@endif
                            @if(!empty($customer->email))<p>{{ $customer->email }}</p>@endif
                            @if(!empty($customer->address))<p>{{ $customer->address }}</p>@endif

                            <p><strong>Invoice Date :  </strong>{{ date('d-m-Y') }}</p>
                            <p><strong>Invoice Number:  </strong>000002323</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        </tbody>
    </table>
    <div class="body">

        <table id="table" style="padding: 5px 5px;font-size: 7.5px;">
            <thead>
            <tr class="header">
                <th><strong style="display: block;text-transform: capitalize; width: 5%;">ID</strong> </th>
                <th><strong style="display: block;text-transform: capitalize; width: 20%;">{{__('tour.vehicle')}}</strong> </th>
                <th><strong style="display: block;text-transform: capitalize" width="10%">{{__('tour.from')}}</strong> </th>
                <th><strong style="display: block;text-transform: capitalize" width="10%">{{__('tour.to')}}</strong> </th>
                <th><strong style="display: block;text-transform: capitalize" width="15%">{{__('tour.driver')}}</strong> </th>
                <th><strong style="display: block;text-transform: capitalize" width="10%">{{__('tour.passengers')}}</strong> </th>
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
                <td colspan="6" style="text-align: right;font-size: 8px;border: 0.5px solid #ccc;">{{__('tour.total_amount')}}</td>
                <td colspan="1" style="text-align: left;font-size: 8px;border: 0.5px solid #ccc;font-weight: bold;"> @if(!empty($total)) {{$total}} €@endif</td>
            </tr>
            </tfoot>
        </table>
    </div>
    <div class="footer">
        <p style="background:#f1f1f1;display:block;text-align:center;padding:8px 0;margin:50px 0 0">© ecoach. {{__('messages.all_rights_reserved')}}</p>
    </div>
@endsection
