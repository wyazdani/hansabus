<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <style type="text/css">
        /*@font-face {
            font-family: customfont;
            src: url('{!! URL::to('fonts/NotoSans-Regular.ttf') !!}');
            font-weight: 400;
        }
        @font-face {
            font-family: customfont;
            src: url('{!! URL::to('fonts/NotoSans-Regular.ttf') !!}');
            font-weight: 600;
        }*/
        body{
            color: #000;
            font: 12px "customfont", Helvetica, Arial, Verdana, sans-serif;
            font-weight: 400;
            padding: 0 !important;
            margin: 0 !important;
        }
        p{
            margin:0px;
            padding:0px;
            text-indent: 0 !important;
        }

        .center{
            text-align: center !important;
        }
        .right{
            text-align: right !important;
            text-indent: 0 !important;
        }
        .left{
            text-align: left !important;
            text-indent: 0 !important;
        }
        .status {
            font-weight: 400;
            text-transform: uppercase;
            color: #FFF;
            font-size: 16px;
            margin-top: -5px;
            text-align: right;

        }
        .even{
            background-color: #EFEFEF;
        }
        .Open {color: #FC704C; }
        .Sent {color: #EAAA10; }
        .Paid {color: #43AC6E; }
        .Overdue {color: #FC704C; }
        .Canceled {color: #43AC6E; }

        .company-logo {
            margin-bottom: 10px;
        }
        .company-address {
            line-height:11px;
        }
        .recipient-address {
            line-height:13px;
        }
        .invoicereference{
            font-size: 12px;
            font-weight: 400;
            margin:10px 0;
        }
        #table{
            width:100%;
            margin:0 !important;
            border-collapse: collapse;
            border: none !important;
            text-indent: 0 !important;
        }
        .header{
            background-color: #00838F;
            color: #fff;
            text-transform: capitalize;
        }
        #table tr.header{
            font-weight: 800;
            color:#FFFFFF;
            font-size: 11px;
            text-transform: uppercase;
            border-bottom:1px solid #DDDDDD;
            border-collapse: collapse;
            text-transform: capitalize;
        }
        #table tr td{
            font-weight: lighter;
            color:#444444;
            border-bottom:1px solid #DDDDDD;
            vertical-align: middle;
            border-collapse: collapse;
            text-indent: 0 !important;
            padding: 10px;

        }
        #table .gray{
            background: #ccc;
        }
        #table tr td .item-name{
            font-weight: 600;
            color:#444444;
        }
        #table tr td .description{
            font-weight: 400;
            color:#888888;
            font-size: 10px;
        }

        .padding{
            padding: 5px 0px;
        }
        .total-amount {
            padding: 8px 20px 8px 0;
            color: #FFFFFF;
            font-size: 17px;
            font-weight: 400;
            margin: 0;
            text-align: right;
        }

        .custom-terms {
            padding:20px 2px;
            border-bottom:1px solid #DDDDDD;
            font-size: 12px;
        }
        .over{
            text-transform: uppercase;
            font-size: 10px;
            font-weight: 600;

        }
        .under{
            font-size: 16px;
        }
        .total-heading {
            background: #30363F;
            color: #FFFFFF;
            text-align: right;
            padding:10px;

        }
        .side{
            padding:0;
            background: #E5E9EC;
        }
        .footer{
            padding:5px 1px;
            font-size: 9px;
            text-align:center;
        }
        html{
            background: #fff;
        }
        .print-header{
            width: 100%;
        }
        .logo{
            width: 200px;
            float: left;
        }
        img{
            display: block;
        }
        .other-info{
            width: 600px;
        }
        .gray{
            background: #f1f1f1 !right;
        }
        @page  {
            size: letter;
            size: 210mm 297mm;
            margin: 0 !important;
        }
        .pagetitle {
            page-break-before: always;
        }
        p,
        tr,
        tbody{
            margin: 0 !important;
            padding: 0 !important;
        }

    </style>
</head>
<body>
@yield('content')
</body>
