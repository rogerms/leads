@foreach($jobs as $job)
    <tr data-id="{{ $job->lead_id }}">
        <td>{!! $job->job_labels !!}</td>
        <td>{{ $job->id }}</td>
        <td>{{ $job->code }}</td>
        <td>{{ $job->customer_name }}</td>
        <td>{{ $job->date_sold }}</td>
        <td>{{ $job->city }}</td>
        <td>{{ $job->sales_rep }}</td>
        <td>{!! $job->job_size !!}</td><!-- sf-->
        <td>{!! $job->pavers_delivery !!}</td><!-- pavers -->
        <td>{!! str_replace(['x0', 'x1'],['', ' &#x2714;'],$job->rb_qty)  !!}</td><!-- rb-->
        <td>{!! str_replace(['x0', 'x1'],['', ' &#x2714;'],$job->sand_qty)  !!}</td><!-- sand -->
        <td>{{  $job->start_date }}</td><!-- start date -->
        <td style="text-align:center">{{ $job->skid  }}</td><!-- skid -->
        <td>{{ $job->crew  }}</td><!-- crew -->
        <td>{{ $job->job_notes }}</td><!-- notes -->
    </tr>
@endforeach
