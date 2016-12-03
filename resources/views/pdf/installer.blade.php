<!-- Stored in resources/views/layouts/master.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no"/>
    <title>Installer Sheet</title>
<!--    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css' rel="stylesheet"> -->
    <style>
        /*@import url('http://fonts.googleapis.com/css?family=Open+Sans');*/
        body{
            padding-top: 0;
            /*background-color: #eee;*/
            max-width: 8.27in;
            font-family: sans-serif;
            font-size: 10pt;
        }

        #page{
            padding: 0;
        }
        .head-div{
            width: 100%;
            height: 1cm;
            padding: 0;
            /*background-color: beige;*/
        }
        .addr {
            /*width: 11.5cm;*/
            /*height: 1.9cm;*/
            text-align: center;
        }
        .top-section {
            font-size: 12pt;
            font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
            /*background-color: red;*/
/*            position:absolute;*/
            /*top: 3.5cm;*/
            margin: 0;
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

        .drawing{
           
            /*height: 8.1cm;*/
            /*background-color: !*#fbfbfb;*!*/
            /*border: thin grey solid;*/
            /*margin: .2cm 0;*/
            position: relative;
            top: 0px;
            left: 0px;
        }

        img.img-holder{
            max-width: 19.8cm;
            max-height: 20cm;
        }

        .align-row > td {
            width: 8.33%;
        }
        table {
            width: 100%;
        }
        .extra-pad{
            margin-left: 0.15cm;
            margin-top: 0.25cm;
        }

    </style>
</head>
<body id="print">
       <div id="page">
        <div class="head-div">
            <div class="logo">

            </div>
            <div class="addr">
                <h3>
                    <span class="header">Strong Rock Pavers - </span>
                    <span class="header">Installer Sheet</span>
                </h3>
            </div>
        </div>

        <div class="top-section"> 
            <table  class="table table-bordered top-table" >
                <tr>
                    <td colspan="10" >
                        <div class="field-name">Job Name</div>
                        <div class='field-value'>{{ $job->name }}</div>
                    </td>
                    <td colspan="2">
                        <div class="field-name">Start Date</div>
                        <div class='field-value'>{{  format_date($job->start_date)  }}</div>
                    </td>
                </tr>
                 <tr>
                    <td  colspan="6">
                        <div class="field-name">Job Address</div>
                        <div class='field-value'>{{ $job->lead->street.", ".$job->lead->city.", ".$job->lead->state." ".$job->lead->zip }}</div>
                    </td>
                    <td  colspan="6">
                         {{--<div class="field-name">Paver</div>--}}
                         {{--<div class='field-value'>{{ $job->style_summary }}</div>--}}
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

       <div class="extra-pad">
           <b>Paver: </b> {{ $job->style_summary }}
       </div>
       <div class="extra-pad">
           <?php
                $remove = [];
               foreach ($job->removals as $r)
               {
                   $remove[] = $r->name;
               }
           ?>
           @if(!empty($remove))
               <b>Removals: </b> {{ implode(", ", $remove) }}
           @endif
       </div>
       <div class="extra-pad">
           <?php
           $note = "";
           foreach ($job->notes as $n)
           {
               if (strpos($n->note, '#installer ') !== FALSE)
               {
                   $note.= str_replace('#installer ', '', $n->note);
               }
           }
           ?>
           @if(!empty($note))
               <b>Note: </b>{{ $note }}
           @endif
       </div>

        <div class="drawing">
            @foreach($imgs_data as $img_data)
            <img class="img-holder" src="{{  $img_data }}" >
            @endforeach
        </div>

       <div>
           <?php

           $text = $job->proposal['text'];
           $pattern = '/-?\$\s?\d+(,\d+)*(\.\d+)?/i'; //$500.50 -$ 400
           $replacement = '';
           $new_text = preg_replace($pattern, $replacement, $text);

           ?>
           {!!  $new_text  !!}
       </div>

    </div>
</body>
</html>