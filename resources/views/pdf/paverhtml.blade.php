<!-- Stored in resources/views/layouts/master.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Paver Print Html</title>
    {{--<link href='https://fonts.googleapis.com/css?family=Nunito:700,300,400' rel='stylesheet' type='text/css'>--}}
    {{--<link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css' rel="stylesheet">--}}
    <style>
        /*@import url('http://fonts.googleapis.com/css?family=Open+Sans'); fdfdfc */
        body{
            padding-top: 0;
            background-color: #eee;
            font-family: 'Arial', sans-serif;
            font-size: 10pt;
        }
        #page{
            /*padding: 50px;*/
            border: thin #eee dashed;
            background-color: white;
            width: 20.59cm;
            height: 26.94cm;
            padding: 0;
        }

        .ship-to{
            width: 5.8cm;
            border: thin solid darkgrey;
            font-size: 12pt;
        }
        .order-info {
            position: absolute;
            top: 0;
            left: 10cm;
            font-size: 14pt;
        }
        .table-div{
            height: 15cm;
        }

        .margin{
            background-color: white;
            padding: 1cm;
            width: 20.59cm;
            height: 26.94cm;
            border: thin solid darkgrey;
            margin: auto;
        }

        td, th {
            border-width: 1px;
            border-style: solid;
            border-color: gray;
            padding: .2cm;
        }

        tr{
            height: .8cm;
        }
        .table {
            width:20.6cm;
        }

        .table-bordered {
            border-width: 0px;
            border-spacing: 0px;
            border-color: gray;
            border-collapse: collapse;
        }

        .to-div{
            width: 100%;
            /*background-color: #eee;*/
            /*display: inline-flex;*/
        }

        .head-div{
            width: 100%;
            text-align: center;
            /*background-color: beige;*/
            margin: auto;
            padding: 0;
        }
        .top-section {
            font-size: 11pt;
            font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
            /*background-color: #eee;*/
            width: 100%;
            height: 4cm;
            position: relative;
            top: 0;
            left: 0;
            /*display: flex;*/
            margin: 1cm 0;
        }
        .table-no-line {
            border-top: none;
        }

        .footer-text {
            width: 100%;
            text-align: center;
            border-top: solid thin darkgray;
            padding-top: .5cm;
        }

        .ship-to-title {
            border-bottom: darkgrey thin solid;
            font-weight: bold;
            padding: .2cm;
        }

        .ship-to-title h5{
            text-align: center;
            font-weight: bold;
            margin: auto;
        }


        .ship-to-body{
            padding: .5cm .5cm;
        }

        .bottom-table {
            font-size: 14pt;
            margin-bottom: .5cm;
        }

        .sum-row{
            background-color: #eee;
            color: #5e5e5e;
        }
        .fill-row{
           height: 3cm;
        }

        @media print {
            #page {
                border: none;
                margin: 0;
            }
            .margin
            {
                padding: 0;
                border: none;
                margin: 0;
                height: 0;
                width: 0;
            }
        }
    </style>
</head>
<body id="print">
    <?php
    $pg = $pavergroup;
    $info = $pavergroup->job->lead;
    $footage_sum = 0;
    $weight_sum = 0;
    $price_sum = 0;
    $palets_sum = 0;

    ?>
    <div class="margin">
    <div id="page">
        <div class="to-div">
            <h4>TO: <b>{{ $pg->manufacturer }}</b> </h4>
        </div>
        <div class="head-div">
            <h3>Strong Rock Pavers</h3>
        </div>
        <div class="top-section">
            <div class="ship-to">
                <div class="ship-to-title"><h5>DELIVERY ADDRESS</h5></div>
                <div class="ship-to-body">
                    {{ $pavergroup->addr }}
                </div>
            </div>

            <div class="order-info">
                <b>Date:</b> {{ format_date( $pavergroup->order_date ) }} <br>
                <b>Job Name:</b> {{ $jobname }} <br>
                <b>Delivery Date:</b> {{ format_date($pavergroup->delivery_at) }} <br>
                <b>Portlands:</b> {{ $pg->portlands }} <br>
            </div>
        </div>

        <div class="table-div">
            <table  class="table table-bordered" id="leadstb">
            <thead>
            <tr>
                <th>Qty</th>
                <th>Unit</th>
                <th>SQ/FT</th>
                <th>Name</th>
                <th>Size</th>
                <th>Color</th>
                <th>Tumbled</th>
                <th>Weight</th>
                <th>Price</th>
            </tr>
            </thead>
            <tbody>
            @foreach($pavergroup->pavers as $paver)
                <tr>
                    <td>{{ $paver->qty }}</td>
                    <td>{{ $paver->qty_unit }}</td>
                    <td>{{ $paver->sqft }}</td>
                    <td>{{ $paver->paver }}</td>
                    <td>{{ $paver->size }}</td>
                    <td>{{ $paver->color }}</td>
                    <td>{{ ($paver->tumbled == true)? 'YES': 'NO' }}</td>
                    <td>{{ number_or_blank($paver->weight) }}</td>
                    <td>{{ $paver->price }}</td>
                </tr>
                <?php
                    $footage_sum += $paver->sqft;
                    $weight_sum += $paver->weight;
                    $price_sum += $paver->price;
                    $palets_sum += $paver->palets;
                ?>
            @endforeach

            @for($i =0; $i < 1; $i++)
                <tr class="fill-row">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endfor
            <tr class="sum-row">
                <td>{{ $palets_sum }}</td>
                <td>{{ $footage_sum }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{ number_or_blank($weight_sum) }}</td>
                <td>{{ $price_sum }}</td>
            </tr>

            </tbody>
            </table>
        </div>

        <div  class="bottom-table">
            <b>Order placed by:</b> {{ $pg->orderedby }}<br>
            <b>Delivery handled by:</b> {{ $pg->handledby }}<br>
            <b>Notes for placement pavers:</b> {{ $pg->note }}<br>
        </div>
        <div class="footer-text">
            Contact office for questions or confirmation at <b>(801) 815-5704</b><br>
            <b>office&#64;strongrockpavers.com</b>
        </div>
    </div>
    </div>
</body>
</html>