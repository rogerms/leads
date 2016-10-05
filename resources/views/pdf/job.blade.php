<!-- Stored in resources/views/layouts/master.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no"/>
    <link rel="icon" type="image/png" href="/images/Logo16x16.png">
    <title>Style Print</title>
<!--    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css' rel="stylesheet"> -->
    <style>
        /*@import url('http://fonts.googleapis.com/css?family=Open+Sans');*/
        body{
            padding-top: 0;
            /*background-color: #eee;*/
            font-family: sans-serif;
            font-size: 10pt;
        }

        #page{
            padding: 0;
        }
        .page{
            padding: 0;
        }
        .head-div{
            width: 100%;
            height: 2cm;
            /*background-color: beige;*/
        }
        .top-section {
            font-size: 12pt;
            font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
            /*background-color: red;*/
/*            position:absolute;*/
            /*top: 3.5cm;*/
            margin: 0;
        }

        .bottom-table {
            font-size: 9.75pt;
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
            /*background-color: #0000cc;*/
        }
        .srce {
            display: inline;
            position: absolute;
            top: 0cm;
            width: 3.3cm;
            height: 2.4cm;
        }
        .logo{
            width: 3.5cm;
            height: 1.87cm;
            display: inline-block;
            position: relative;
            background-color: #2e2e2e;
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
            height: 2.5cm;
            /*padding: 0.2cm;*/
        }
        .drawing{
           
            height: 8.1cm;
            /*background-color: !*#fbfbfb;*!*/
            border: thin grey solid;
            margin: .2cm 0;
            position: relative;
            top: 0px;
            left: 0px;
            padding: .2cm;
        }
        .total-box{
            position: absolute;
            font-size: 11pt;
            top: 7.2cm;
            left:14.35cm;
            border: thin black solid;
            height: 1.1cm;
            width: 4.5cm;
            padding: .15cm 0 0 .2cm;
            background-color: white;
        }
        .total-value{
            font-size: 15pt;
            margin-left: 1.5cm;
            text-align: center;
            font-weight: 700;
        }
        .job-obs{
            position: absolute;
            top: -.6cm;
            left: 0;
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
            width:100%;
        }
        
        .bottom-group{

/*            position: relative;*/
            top: 1cm;
        }
        small {
            font-size: 6.5pt;
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
        .removals, #feats{
            margin-left: 1cm;
        }

    </style>
</head>
<body id="print">
       <div id="page">
        <div class="head-div">
            <div class="logo">
                <img class="logo" width="1cm" src={{  url("/images/logo_srp.jpg") }}>
            </div>
            <div class="addr">
                <div class="addr-title">Strong Rock Pavers</div>
                <div class="addr-body">
                Northern Utah: (801) 815-5704 Southern Utah: (435) 703-8937 <br>
                2176 W. Center St. Provo, UT 84601 <br>
                Fax: (801) 437-1765 Email: office@strongrockpavers.com
               </div>
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
                        <div class='field-value'>{{ $job->lead->street.", ".$job->lead->city.", ".$job->lead->state." ".$job->lead->zip}}</div>
                    </td>
                    <td colspan="2">
                       <div class="field-name">Est. Start Date</div>
                       {{--<div class='field-value'>{{  format_date($job->start_date)  }}</div>--}}
                        <div class='field-value'> </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="7">
                        <div class="field-name">Billing Address</div>
                       <div class='field-value'>{{ ''  }}</div>
                    </td>
                    <td colspan="5">
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
           <span id='type'>
               <span class="label">Type:</span> <span class="value">{{ $job->job_type }}</span>
            </span>
            <span id="feats">
                <span class="label">Features:</span>
                <?php $feats = [];
                foreach($job->features as $feat)
                {
                    if($feat->pivot->active)
                        $feats[] = $feat->name;
                }
                ?>
                <span class="value">{{ implode(', ', $feats) }} </span>
            </span>

            <div id="size">
                <span class="label">Approx. Size: </span>
                <span class="value">{{ $job->size }}</span>
                <span class="label">Sq.Ft.</span>

                <span class="label removals">Removals:</span>
                <?php $rems = [];
                    foreach($job->removals as $rem):
                        $rems[] = $rem->name;
                    endforeach
                ?>
                <span class="value">{{ implode(', ', $rems)  }} </span>
            </div>

            {{--<div id="removals">--}}
                {{--<span class="label">Removals:</span>--}}
                {{--@foreach($job->removals as $rem)--}}
                        {{--<span class="value">{{ $rem->name }}, </span>--}}
                {{--@endforeach--}}
            {{--</div>--}}

            <div id='style'>
                <span class="label">Pavers: </span>
                <span class="value">{{ $job->style_summary }}</span>
            </div>
        </div>
        
        <div class="drawing">
            {{--<img class="img-holder" src="{{ url("drawings/$path") }}" alt="">--}}

            {{--@foreach($job->descs as $desc)--}}
                    {{--{{ str_ireplace('#description ', '', $desc->note)  }} <br>--}}
            {{--@endforeach--}}
            <span class="job-obs">
                   Job description: <small>All material and work listed to be performed in accordance with applicable drawing and specifications, completed 
                    in substantial and workman like manner.</small>
            </span>
            <div>
                {!! $job->proposal['text']  !!}
            </div>
            <div class="total-box">
                <div>Job Total</div>
                <div class="total-value">{{ currency_format($job->proposal_amount) }}</div>
            </div>
        </div>

        <div class="bottom-group">
        <div  class="bottom-table botom-exclusion">
            <u>Payments to be made as follows</u>:  50% down payment/deposit prior to projected project start date and final payment due upon project completion. Invoice past due 30 day or more are subject to a 5% per month service charge and 1.5% per month payment for services performed. Due to high demand of job materials and market conditions, projects started 20 day or ore after the date of this proposal may be subject to price increases INITIALS _________.
        </div>
        <div class="bottom-table">
            <u>Exclusion</u>: SPRINKLERS, Underground unknown, rough grading/excavation, state and city sales tax.
        </div>
            <?php $style = ($job->noadd_fee == 1)? "text-decoration:line-through": "";  ?>
        <div class="bottom-table" style="height:1.61cm; {{ $style }}">
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

    {{--warranty and disclaimer --}}
       <div class="page">
           <p class=MsoNormal align=center style='text-align:center'>
               <span style='font-size:12.0pt;line-height:107%'>Strong Rock Pavers<br>
Warranty</span><span style='font-size:11.0pt;line-height:107%'><br>
<u>Installation Disclaimer</u></span></p><br>

           <p class=MsoNormal><b><span>Material Delivery</span></b><span>: 
Deliveries of pavers and sand may be made 1 to 3 days prior to the start date
of the job.  The customer is to have the specified area clear to allow for the
storage of these materials.  These materials, as well as any excavated material
and/or concrete will be stored in the specific area until the completion of the
project.  Additional clean-up and removal fees will be charged if the customer
requests removal of these materials prior to completion.</span></p>

           <p class=MsoNormal><b><span>Start and Completion Dates</span></b><span
                      >:  The customer understands that scheduled start dates are an
approximation and can be delayed by weather, manufacturer delivery schedules,
delays at existing projects, employee absenteeism, acts of God or any other
causes beyond its control.</span></p>

           <p class=MsoNormal><b><span>Excavation</span></b><span>:  The
customer understands that the area in which the pavers are to be installed may
be excavated 8&quot; to 12&quot; below finish grade, depending upon the
thickness of the pavers and the amount of Type II required. This can vary
between Driveway's and Patio's.</span></p>

           <p class=MsoNormal><b><span>Concrete Removal</span></b><span>: 
It is very difficult to remove concrete without some damage to surrounding
areas.  Although care will be taken to minimize this damage, adjacent stucco,
underground irrigation pipes, sprinklers, lawn and landscaping may incur some
damage.  The customer acknowledges that should there be unintentional damage to
surrounding areas; Strong Rock Pavers is not financially responsible for the
repair of this damage.  Furthermore, if the existing concrete is in excess of
six (6) inches in thickness or contains rebar or other steel reinforcement,
customer will incur an additional charge of a minimum of $0.75 per square foot.</span></p>

           <p class=MsoNormal><b><span>Drainage</span></b><span>:  Excess
water from rainfall, sprinklers, swimming pools, cleaning, etc. needs to drain
off the pavement to prevent &quot;ponding&quot; and water from flowing toward
structures and pools.  In most cases, Strong Rock Pavers can avoid the use of drainpipes
and &quot;deco-drains&quot; by creating the proper slopes and swales to direct
excess water in the proper direction. If however, site conditions dictate that
drains must be used; there will be an additional charge for the installation of
the required drains.</span></p>

           <p class=MsoNormal><b><span>Landscaping</span></b><span>:  The
installation of paving stone hardscapes requires excavation of the specified
area to allow for proper installation and grading.  The customer acknowledges
that some damage to the landscaping adjacent to this area may incur some
damage.  In addition, the transportation of materials and debris in and around
the job site with heavy equipment and/or repeated trips with wheelbarrows may
cause damage to the yard as well.  Should any additional labor be required for
excavation beyond what is normal, such as caliche, boulders, tree roots, etc.,
the customer understands that they will be charged for the extra labor.</span></p>

           <p class=MsoNormal><b><span>Swimming Pool Remodels</span></b><span
                      >:  It is common when demolishing concrete and/or coping around an
existing swimming pool for there to be incidental damage to pool tile, skimmer,
plumbing or electrical conduit when these objects are just below the surface of
the concrete.  Strong Rock Pavers will make every attempt to minimize this
damage; however, we cannot be responsible for the repair or replacement of
these items.  If there is water in the pool during demolition and installation
the customer understands the concrete debris, mortar, grout and paved dust from
cutting will end up in the pool and clean up will be the responsibility of the
customer.  Additionally, if the pool will not contain water during
installation, there may be some staining of the plaster from mortar and grout.</span></p>

           <p class=MsoNormal><b><span>Snow Removal</span></b><span>: 
Pavers is an upgraded hardscape.  In low temperatures (32F or below) Radiant
heat underneath your driveway, or walkway, or pool deck area is a comfort and
good option to remove snow off pavers (Not obligatory).  In the case that you
do not have radiant heat the use of a blower is suggested to remove snow or you
must require* that your snow removal company have their blade covered with
industrial hard plastic/rubber. *<b>This is a must</b>. Strong Rock Pavers is
not responsible for damage on the pavers' surface done by snow removal companies
that used a regular steel blade on your driveway.  DO NOT APPLY SALT. 
Application of salt voids paver warranty.</span></p>

           <p class=MsoNormal><b><span>Color Blends</span></b><span>:  Two
and three color-blended pavers can vary in appearance from pallet to pallet
depending on those delivered by the manufacturer.  Installation crews will draw
pavers from several pallets in order to distribute these pavers in as uniform
manner as possible.  However, if additional square footage beyond that
specified in the original purchase agreement is ordered, the customer
understands that the additional area may differ in appearance from the original
scope of work.  Color matching cannot be guaranteed.</span></p>
{{--line break page 2--}}
<br>
           {{--line break page 2--}}
           <p class=MsoNormal><b><span>Sample Pavers</span></b><span>: 
Should Strong Rock Pavers provide paver samples, the customer understands that
it is difficult to represent accurately, color blends with a small amount of
pavers (see Color Blends).  In addition, slight color variations in production
runs by the manufacturer can affect the color of the product delivered to the
job site.  The customer is responsible for their color selection and will be
charged for re-stocking and delivery if they reject the product once it has
been delivered.</span></p>

           <p class=MsoNormal><b><span>Property Damage</span></b><span >: 
Deliveries of paver and wall products, as well as sand and aggregate base
materials by heavy equipment such as semi-trucks, dump trucks and forklifts. 
Although care is taken to minimize any damage, tire tracks, scratches or discoloration
may occur.  The customer hereby releases Strong Rock Pavers and its employees
from responsibility for any and all damages to curbs, sidewalks, driveways, buildings,
grounds or otherwise as a result of their making deliveries.  The guarantee
does not apply to splitting, chipping or there breakage that could be caused by
impact, abrasion or overload.  Strong Rock Pavers will not warranty any damage
caused by loads or trucks of over 26,000 pounds. </span></p>

           <p class=MsoNormal><b><span >Efflorescence</span></b><span >: 
Efflorescence is a whitish powder-like deposit common on concrete and masonry
products that normally will disappear over time due to different temperatures,
moisture levels and weather.  Efflorescence is a natural occurrence for which
Strong Rock Pavers accepts no responsibility or liability.</span></p>

           <p class=MsoNormal><b><span>SRP Pavers</span></b><span>:  Our
pavers are not for public sale, and are not engineered tested, and are made
only when the customer wants to use them.  I understand that the pavers are not
engineered tested.</span></p>

           <p class=MsoNormal><span>Customer Signature:  _________________________________________________  
Date:  ________________________</span></p>

           <p class=MsoNormal align=center style='text-align:center'><span>WARRANTY</span></p>

           <p class=MsoNormal><span>The manufacturer provides their own warranty
for all paver and wall products.  Pavestone and Belgard provide a Lifetime
Limited Warranty.  Strong Rock Pavers provides a 2-year Warranty for all paver
products we manufacture.  Strong Rock Pavers also guarantees all labor and workmanship
for two years. This warranty is for residential construction only and does not
imply warranty for commercial applications.  </span></p>

           <p class=MsoNormal><span>Customer Signature: __________________________________________________
Date:  ________________________</span></p>

           <p class=MsoNormal><span>&nbsp;</span></p>
       </div>
</body>
</html>