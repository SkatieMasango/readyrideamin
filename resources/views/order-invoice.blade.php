<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        .bg-gray {
            background: gray;
            color: #fff;
        }

        .text-default {
            color: #00B894;
        }

        .bg-default {
            background: #00B894;
        }

        body {
            margin: 0;
            position: relative;
            font-family: sans-serif;
            font-size: 14px;
        }

        .container {
            padding: 25px !important;
        }

        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        @page {
            size: A4;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 0.5rem;
            text-align: left;
            font-size: 14px;
            border: 1px solid rgba(0, 0, 0, 0.07);
        }

        img {
            max-width: 100%;
            max-height: 100%;
        }

        footer {
            position: absolute;
            top: 20%;
            left: 10px;
            transform: rotate(90deg);
            transform-origin: 3% 0% 0;
            width: 100%;
            height: 40px;
        }

        h4 {
            margin: 5px 0
        }

        .header {
            width: 100%;
            height: 28px;
            position: relative;
            background-color: #00B894;
            margin-top: 25px;
        }

        .header .logo {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 25px;
            background: #fff;
            width: 120px;
            height: 40px;
            text-align: center;
        }

        .header .logo img {
            max-width: 98%;
        }

        h1,
        h2 {
            font-weight: bold;
            margin: 0;
        }

        .float-left {
            float: left;
        }

        .address_line {
            height: 80px;
            padding: 5px 0;
        }

        h4 {
            font-weight: normal !important;
            font-size: 14px;
        }

        .w-60 {
            width: 60%
        }

        .w-70 {
            width: 70%
        }

        .w-10 {
            width: 10%
        }

        .w-15 {
            width: 15%
        }

        .w-20 {
            width: 20%
        }

        .footer {
            width: 100%;
            position: absolute;
            bottom: 0;
        }

        .contact {
            position: absolute;
            right: 25%;
            top: 50px
        }

        .footer-bottom {
            border-top: 2px solid rgba(0, 0, 0, 0.07);
            position: relative;
            height: 40px;
        }

        .footer-bottom .message {
            position: absolute;
            left: 25px;
            padding: 10px 0;
        }

        .footer-bottom .author {
            position: absolute;
            top: -2px;
            right: 25px;
            border-top: 2px solid #000;
            padding: 10px 0;
        }

        .footer-bottom .signature {
            position: absolute;
            right: 32px;
            top: -50px;
        }

        .footer-bottom .signature img {
            height: 50px;
        }
    </style>
    <title>#{{ $order->prefix . $order->id }} - invioce</title>
</head>

<body>
    @php
        $setting = App\Models\Settings::first();
        $currency = $setting->currency ?? config('enums.currency');

        $data = is_string($setting->value) ? json_decode($setting->value, true) : $setting->value;
    @endphp

    <div class="header">
        @if (app()->environment('local'))
            <div class="logo">
                <img src="./web/logo.png" alt="">
            </div>
        @else
            <div class="logo">
                <img src="{{ asset($data['website_logo']) }}" alt="Logo">

            </div>
        @endif
    </div>

    <div class="container">

        <div style="overflow: hidden; height: 30px;">
            <div style="float: right; width: 30%;">
                <h1 class="text-default">Invoice</h1>
            </div>
        </div>

        <h4 style="font-weight: normal !important"> Rider: {{ $order->rider->user->name }}
            </h4>
        <div class="address_line">
            @php
                $addresses = is_string($order->addresses) ? json_decode($order->addresses, true) : $order->addresses;
            @endphp
            <div class="w-70 float-left">
                <h4><strong>Pick-Up Address: </strong> {{ $addresses['pickup_address'] }}</h4>
                <h4><strong>Drop Address: </strong> {{ $addresses['drop_address'] }}</h4>
                <h4><strong>Phone | Fax: </strong> {{ $order->rider->user->mobile }}</h4>
            </div>
            <div class="w-10 float-left">
                <h4 class="text-default">RECEIPT #</h4>
                <h4 class="text-default">DATE:</h4>
            </div>
            <div class="w-20 float-left" style="padding-left: 12px">
                <h4>{{ $order->prefix . $order->id }}</h4>
                <h4>{{ $order->created_at->format('F d, Y') }}</h4>
            </div>
        </div>

        <div style="padding: 10px 0">
            <h4><strong>Date :</strong>
                <span class="badge text-dark">
                    {{ Carbon\Carbon::parse($order->created_at)->format('M d, Y') }}
                </span>
            </h4>

        </div>

        <table class="table">
            <thead>
                <tr class="bg-default">
                    <th> Order ID</th>

                    <th style="text-align: right;min-width:600px">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>

                    <td style="text-align: right; background: rgba(0, 0, 0, 0.07);">
                        <strong>{{ $order->id }}</strong>
                    </td>
                    <td style="text-align: right; background: rgba(0, 0, 0, 0.07);">
                        <strong>{{ $order->cost_best }}</strong>
                    </td>
                </tr>

                <tr>
                    <td style="text-align: right;">
                        <strong>TOTAL</strong>
                    </td>
                    <td style="text-align: right; ">
                        <strong>{{ $order->cost_best }}</strong>
                    </td>


                </tr>
                <tr>
                    <td style="text-align: right;">
                        <strong>TOTAL PAYABLE</strong>
                    </td>
                    <td style="text-align: right; ">
                        <strong>{{ $order->cost_best }}</strong>
                    </td>

                </tr>
            </tbody>
        </table>


    </div>
    <div class="footer">
        <div style="padding: 10px 25px">
            <div class="address">
                <strong>{{ $setting?->name ?? config('app.name') }}</strong> <br>
                Address: <strong>{{ $setting?->address }}</strong> <br>
                City: <strong>{{ $setting?->city }}</strong> <br>
            </div>
            <div class="contact">
                Mobile: <strong>{{ $setting?->mobile }}</strong>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="message text-default">Thank you for your business</div>
            <div class="author">Authorised sign</div>
            @if (app()->environment('local'))
                <div class="signature">
                    <img src="./web/signature.png">
                </div>
            @else
                <div class="signature">
                    <img src="{{ $setting?->signature_path }}">
                </div>
            @endif
        </div>
    </div>
</body>

</html>
