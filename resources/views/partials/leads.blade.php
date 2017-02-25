@foreach($leads as $lead)
    <tr data-id="{{ $lead->id }}">
        <td>{!! $lead->job_labels !!}</td>  <!-- status -->
        <td>{{ $lead->customer_name }}</td>
        <td>{{ $lead->city }}</td>
        <td>{{ $lead->street }}</td>
        <td>{{ $lead->phone }}</td>
        <td>{{ $lead->appointmentfmt }}</td>
        <td>{{ $lead->sales_rep_name }}</td>

        {{--<td>{!! $lead->job_size !!}</td><!-- sf-->--}}
        {{--<td>{!! $lead->pavers_delivery !!}</td><!-- pavers -->--}}
        {{--<td>{!! str_replace(['x0', 'x1'],['', ' &#x2714;'],$lead->rb_qty)  !!}</td><!-- rb-->--}}
        {{--<td>{!! str_replace(['x0', 'x1'],['', ' &#x2714;'],$lead->sand_qty)  !!}</td><!-- sand -->--}}
        {{--<td>{!! $lead->date_sold !!}</td><!-- date sold -->--}}
        {{--<td>{!! $lead->start_date !!}</td><!-- start date -->--}}
        {{--<td style="text-align:center">{{ $lead->skid  }}</td><!-- skid -->--}}
        {{--<td>{{ $lead->crew  }}</td><!-- crew -->--}}
        {{--<td>{{ $lead->job_notes['note'] }}</td><!-- notes -->--}}
    </tr>
@endforeach
