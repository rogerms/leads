@foreach($leads as $lead)
    <tr data-id="{{ $lead->id }}">
        <td>{{ $lead->customer_name }}</td>
        <td>{{ $lead->phone }}</td>
        <td>{{ $lead->street }}</td>
        <td>{{ $lead->city }}</td>
        <td>{{ $lead->appointmentfmt }}</td>
        <td>{{ $lead->sales_rep_name }}</td>
        <td>{{ $lead->status_name }}</td>
    </tr>
@endforeach
