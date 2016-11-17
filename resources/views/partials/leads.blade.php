@foreach($leads as $lead)
    <tr data-id="{{ $lead->id }}">
        <td>{{ $lead->job_labels }}</td>  <!-- status -->
        <td>{{ $lead->customer_name }}</td>
        <td>{{ $lead->city }}</td>
        <td>{{ $lead->street }}</td>
        <td>{{ $lead->phone }}</td>
        <td>{{ $lead->appointmentfmt }}</td>
        <td>{{ $lead->sales_rep_name }}</td>

        <td>{{ $lead->job_size  }}</td><!-- sf-->
        <td>{{ $lead->job_notes['paver']  }}</td><!-- pavers -->
        <td>{{ $lead->rb_qty  }}</td><!-- rb-->
        <td>{{ $lead->sand_qty  }}</td><!-- sand -->
        <td>{{ $lead->date_sold  }}</td><!-- date sold -->
        <td>{{ $lead->start_date  }}</td><!-- start date -->
        <td></td><!-- skid -->
        <td>{{ $lead->job_notes['note'] }}</td><!-- notes -->
    </tr>
@endforeach
