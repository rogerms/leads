<!-- Stored in resources/views/layouts/master.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Style Print</title>
    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css' rel="stylesheet">
    <style>
        /*@import url('http://fonts.googleapis.com/css?family=Open+Sans');*/
        body{
            padding-top: 0;
            background-color: #fdfdfc;
            font-size: 12pt;
        }
        .ship-to{
            width: 300px;
            border: thin solid darkgrey;
            font-size: 14pt;
        }
        .order-info {
            position: absolute;
            top: 0px;
            left: 500px;
            font-size: 14pt;
        }
        .table-div{
            height: 800px;
        }
        #page{
            /*padding: 50px;*/
            background-color: white;
            width: 1000px;
            margin-bottom: -5px;
            padding: 0;
            margin: auto;
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
        }
        .top-section {
            font-size: 11pt;
            font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
            /*background-color: #eee;*/
            width: 100%;
            height: 200px;
            position: relative;
            top: 0;
            left: 0;
            /*display: flex;*/
            margin: 30px 0;
        }
        .table-no-line {
            border-top: none;
        }

        .footer-text {
            width: 100%;
            text-align: center;
            border-top: solid thin darkgray;
            padding-top: 10px;
        }

        .ship-to-title {
            border-bottom: darkgrey thin solid;
            font-weight: bold;
        }

        .ship-to-title h5{
            text-align: center;
            font-weight: bold;
        }

        .ship-to-body{
            padding: 10px 10px;
        }

        .bottom-table {
            font-size: 14pt;
            margin-bottom: 25px;
        }


        /*@media print {*/
            /*#page {*/
                /*background-color: transparent;*/
                /*width: 100%;*/
                /*margin: 0;*/
            /*}*/
        /*}*/
    </style>
</head>
<body id="print">
    <?php
        $sg = $stylegroup;
        $info = $stylegroup->job->lead;

        $footage_total = 0;
        foreach($stylegroup->styles as $style)
        {
            $footage_total += $style->sqft;
        }
    ?>
    <div id="page">
        <div class="to-div">
            <h4>TO: <b>{{ $sg->manufacturer }}</b> </h4>
        </div>
        <div class="head-div">
            <h3>Strong Rock Pavers</h3>
        </div>
        <div class="top-section">
            <div class="ship-to">
                <div class="ship-to-title"><h5>DELIVERY ADDRESS</h5></div>
                <div class="ship-to-body">
                    {{ $info->customer_name }} <br>
                    {{ $info->street }} <br>
                    {{ $info->city }}, UT {{$info->zip}}<br>
                </div>
            </div>

            <div class="order-info">
                <b>Date:</b> {{ format_date(time()) }} <br>
                <b>Job Name:</b> {{ $jobname }} <br>
                <b>Delivery Date:</b> {{ format_date($stylegroup->delivery_at) }} <br>
                <b>Square Footage:</b> {{ $footage_total }} <!-- the sum of all sqft in this order -->
            </div>
        </div>

        <div class="table-div">
            <table  class="table table-bordered" id="leadstb">
            <thead>
            <tr>
                <th>Palets</th>
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
            @foreach($stylegroup->styles as $style)
                <tr>
                    <td>{{ $style->palets }}</td>
                    <td>{{ $style->sqft }}</td>
                    <td>{{ $style->style }}</td>
                    <td>{{ $style->color }}</td>
                    <td>{{ $style->size }}</td>
                    <td>{{ ($style->tumbled == true)? 'YES': 'NO' }}</td>
                    <td>{{ $style->weight }}</td>
                    <td>{{ $style->price }}</td>
                </tr>
            @endforeach
            </tbody>
            </table>
        </div>

        <div  class="bottom-table">
            <b>Order placed by:</b> {{ $sg->orderedby }}<br>
            <b>Delivery handled by:</b> {{ $sg->handledby }}<br>
            <b>Notes for placement pavers:</b> {{ $sg->note }}<br>
            <b>Portlands:</b> {{ $sg->portlands }} <br>
        </div>
        <div class="footer-text">
            Contact office for questions or confirmation at <b>(801) 815-5704</b><br>
            <b>office&#64;strongrockpavers.com</b>
        </div>
</body>
</html>