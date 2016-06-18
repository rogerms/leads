@foreach($jobs as $job)
    <tr data-id="{{ $job->lead_id }}">
        <td>{{ $job->id }}</td>
        <td>{{ $job->code }}</td>
        <td>{{ $job->customer_name }}</td>
        <td>{{ format_date($job->date_sold) }}</td>
        <td>{{ $job->city }}</td>
        {{--<td>{{ formatAppoint($job->lead['appointment']) }}</td>--}}
        <td>{{ $job->sales_rep }}</td>
        {{--<td>{{ $job->lead->status["name"] }}</td>--}}
    </tr>
@endforeach
