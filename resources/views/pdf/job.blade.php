<!-- Stored in resources/views/layouts/master.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no"/>
    <title>Style Print</title>
<!--    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css' rel="stylesheet"> -->
    <style>
        /*@import url('http://fonts.googleapis.com/css?family=Open+Sans');*/
        body{
            padding-top: 0;
            background-color: #eee;
            font-family: sans-serif;
            font-size: 10pt;
        }

        #page{
            /*padding: 50px;*/
            border: thin black dashed;
            background-color: white;
            width: 20.59cm; 
            height: 25.94cm;
            padding: 0;
/*            margin: auto;*/
        }
        .head-div{
            width: 100%;
            height: 2.5cm;
            /*border: dashed thin sienna;*/
            /*background-color: beige;*/
        }
        .top-section {
            font-size: 12pt;
            font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
/*            background-color: #eee;*/
/*            position:absolute;*/
            top: 3.5cm;
            width: 20.59cm;
            margin: 0;
        }

        .bottom-table {
            font-size: 10pt;
            margin-bottom: .3cm;
        }
        .botom-exclusion
        {
            margin-bottom: 0;
        }
        .addr {
            display: inline-block;
            width: 11.5cm;
            height: 1.9cm;
            text-align: center;
            margin-top: .5cm;
            /*border: dotted thin black;*/
        }
        .srce {
            display: inline;
            position: relative;
            top: -1.5cm;
            width: 3.3cm;
            height: 2.4cm;
        }
        .logo{
            width: 4.5cm;
            height: 2.4cm;
            display: inline-block;
            position: relative;
            top: -1.7cm;
        }
        
        .field-name{
            font-size: 8pt;
            margin: .05cm 0 0 .05cm;
        }
        
        .field-value{
           font-size: 11pt;
            margin: .05cm 0 0 .05cm;

            height: .5cm;
        }
        .second {
            height: 3cm;
            padding: 0.2cm;
        }
        .drawing{
           
            height: 8.1cm;
            background-color: #fbfbfb;
            border: thin grey solid;
            margin: .2cm 0;
            position: relative;
            top: 0px;
            left: 0px;
        }
        .total-box{
            position: absolute;
            font-size: 11pt;
            bottom:0;
            right:0;
            border: thin black solid;
            height: 1.1cm;
            width: 8.5cm;
            padding: .15cm 0 0 .2cm;
            background-color: white;
        }
        .total-value{
            font-size: 15pt;
            margin-left: 4cm;
            text-align: center;
            font-weight: 700;
        }
        .job-obs{
            position: absolute;
            top: -.55cm;
            left: 0;
        }
        .page-margin {
            background-color: white;
            padding: 1cm;
            width: 20.59cm;
            height: 27.94cm;
            border: thin solid darkgrey;
            margin: auto;
        }
        
        .table-bordered {
            border-width: 0px;
            border-spacing: 0px;
            border-color: gray;
            border-collapse: collapse;
        }
        
       td{
            border-width: 1px;
            border-style: solid;
            border-color: gray;
            padding-left: .2cm
        }
        
        tr{
            height: 1.1cm;
        }
        .table {
            width:20.6cm;
        }
        
        .bottom-group{
            width: 20.59cm;
/*            position: relative;*/
            top: 1cm;
        }
        small {
            font-size: 7pt;
        }

        .align-row{
            height: 0;
        }
        .align-row > td{
            width: 8.3%;
            height: 0;
            border-style:none;
        }
        span.label{
            font-weight: bold;
        }
        span.value{
            font-size: 12pt;
        }
        img.img-holder{
/*            width: 100%;*/
            height: 100%;
        }
        @media print {
            #page {
                border: none;
                margin: 0;
            }
            .page-margin
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

    <div class="page-margin">
       <div id="page">
        <div class="head-div">
            <div class="logo">

            </div>
            <div class="addr">
                <div class="addr-title">Strong Rock Pavers</div>
                <div class="addr-body">
                Northern Utah: (801) 815-5704 Southern Utah: (435) 703-8937
                2176 W. Center St. Provo, UT 84601 <br>
                Fax: (801) 437-1765 Email: office@strongrockpavers.com
               </div>
            </div>
            <div class="srce">
                <span class="label">Source:</span>
                <span class="value">{{ $job->lead->source->name }}</span>
            </div>
        </div>
<!--        first block -->
        <div class="top-section"> 
            <table  class="table table-bordered top-table" >
                <tr>
                    <td colspan="5" >
                        <div class="field-name">Proposal Submitted to</div>
                        <div class='field-value'>{{$job->lead->customer_name}}</div>
                    </td>
                    <td colspan="5" >
                        <div class="field-name">Job Name</div>
                        <div class='field-value'>{{ $job->name }}</div>
                    </td>
                    <td colspan="2" >
                        <div class="field-name">Date</div>
                        <div class='field-value'>{{ format_date($job->date_sold) }}</div>
                    </td>
                </tr>
                 <tr>
                    <td  colspan="10">
                        <div class="field-name">Job Address</div>
                        <div class='field-value'>{{ $job->lead->street }}</div>
                    </td>
                    <td colspan="2">
                       <div class="field-name">Est. Start Date</div>
                       <div class='field-value'>{{ format_date($job->start_date)  }}</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <div class="field-name">Billing Address</div>
                       <div class='field-value'>{{ ''  }}</div>
                    </td>
                    <td colspan="3">
                        <div class="field-name">Office/Home</div>
                       <div class='field-value'></div>
                    </td>
                    <td colspan="4">
                       <div class="field-name">Email</div>
                       <div class='field-value'>{{ $job->lead->email }}</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                      <div class="field-name">Contact</div>
                      <div class='field-value'>{{ $job->lead->contact_name }}</div>
                    </td>
                    <td colspan="3">
                        <div class="field-name">Cell</div>
                        <div class='field-value'>{{ $job->lead->phone }}</div>
                    </td>
                    <td colspan="3">
                        <div class="field-name">Rep.</div>
                        <div class='field-value'> {{ $job->lead->salesrep->name }}</div>
                    </td>
                     <td colspan="3">
                        <div class="field-name">Rep. Cell</div>
                        <div class='field-value'>{{ $job->lead->salesrep->phone }}</div>
                    </td>
                </tr>
                <tr class="align-row"> 
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            
            
            

        </div>
        <div class="second">
           <div id='type'>
               <span class="label">Type:</span> <span class="value">{{ $job->job_type }}</span>
            </div>
            <div id="feats">
                <span class="label">Features:</span>

                @foreach($job->features as $feat)
                    @if($feat->pivot->active)
                        <span class="value">{{ $feat->name }}, </span>
                    @endif
                @endforeach
            </div>

            <div id="removals">
                <span class="label">Removals:</span>
                @foreach($job->removals as $rem)
                        <span class="value">{{ $rem->name }}, </span>
                @endforeach
            </div>

            <div id="size">
                <span class="label">Approx. Size: </span>
                <span class="value">{{ $job->size }}</span>
                <span class="label">Sq.Ft.</span>
            </div>
            <div id='style'>
                <span class="label">Pavers: </span>
                <span class="value">{{ $job->style_summary }}</span>
            </div>
        </div>
        
        <div class="drawing">
            <img class="img-holder" src="{{ url("drawings/$path") }}" alt="">
            <span class="job-obs">
                   Job description: <small>All material and work listed to be performed in accordance with applicable drawing and specifications, completed 
                    in substantial and workman like manner.</small>
            </span>
            <div class="total-box">
                <div>Job Total</div>
                <div class="total-value">{{ $job->proposal_amount }}</div>
            </div>
        </div>

        <div class="bottom-group">
        <div  class="bottom-table botom-exclusion">
            <u>Payments to be made as follows</u>:  50% down payment/deposit 5 days prior to projected project start date and final payment due upon project completion. Invoice past due 30 day or more are subject to a 5% per month service charge and 1.5% per month payment for services performed. Due to high demand of job materials and market conditions, projects started 20 day or ore after the date of this proposal may be subject to price increases INITIALS _________.
        </div>
        <div class="bottom-table">
            <u>Exclusion</u>u>: SPRINKLERS, Underground unknown, rough grading/excavation, state and city sales tax.
        </div>
        <div class="bottom-table">
            <u>Additional fees</u>: $600.00 dumpster fee if one is not provided on jobsite. Any alteration or deviation to the Scope of the Work or Material Specification listed above will require a bid revision or change order which could result in extra costs over and above the original contract value. Pavers, steps, retaining walls, different types of sands, sealers and concrete removal including landfill costs are priced differently and separately.
        </div>
        <div class="bottom-table">
            <u>Owner/General Contractor warrants</u> that ________________ is the titled owner of the real property and understands that Strong Pavers is relying on this representation to enter into this contract. You are authorized to do Permanent Physical Improvement as outlined above. Payment will be made by the undersigned as set forth in this document. (Material will be ordered once a signed contract is received). The above prices, scope of work, and condition are satisfactory and hereby accepted.
        </div>
        <div class="bottom-table">
            Authorized Signature _______________________________________   Date________________
        </div>
        </div>
    </div>
    </div>
</body>
</html>