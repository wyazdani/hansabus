<!DOCTYPE html>
<html lang="de" class="loading">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="keywords" content="">
    <style>
        .page-break { page-break-after: always; }
    </style>

</head>
<body>

<h2>{{__('messages.customer')}}</h2>
<p>{{$customer->name}}</p>
<small>
    <p>{{__('messages.address')}}: {{$customer->address}}</p>
    <p>Phone: {{$customer->phone }}</p>
    <p>Email: {{$customer->email}}</p>
</small>
<table width="100%">
    <thead>
    <tr>
        <th class="border-top-0" width="5%">ID</th>
        <th class="border-top-0" width="20%">{{__('messages.vehicles')}}</th>
        <th class="border-top-0" width="11%">{{__('messages.from')}}</th>
        <th class="border-top-0" width="11%">{{__('messages.to')}}</th>
        <th class="border-top-0" width="20%">{{__('messages.drivers')}}</th>
        <th class="border-top-0" width="8%">{{__('messages.passengers')}}</th>
        <th class="border-top-0" width="8%">{{__('messages.price')}}</th>
    </tr>
    </thead>
    <tbody>

    @foreach($tours as $tour)
        <tr>
            <td>{{ $tour->id }}</td>
            <td>{{ $tour->vehicle->name }}</td>
            <td>{{ $tour->from_date }}</td>
            <td>{{ $tour->to_date }}</td>
            <td>{{ $tour->driver->driver_name }}</td>
            <td>{{ $tour->passengers }}</td>
            <td>{{ number_format($tour->price) }}</td>
        </tr>

    @endforeach
    <tr>
        <td colspan="6" style="text-align: right">Invoice Total:</td>
        <td>{{ number_format($total) }}</td>
    </tr>
    </tbody>
</table>

</body>
</html>