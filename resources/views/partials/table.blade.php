<table  class="table table-striped table-hover table-bordered" id="leadstb">
    <thead>
    <tr>
        <th>Customer Name</th>
        <th>Phone</th>
        <th>Street</th>
        <th>City</th>
        <th>Appointment</th>
        <th>Sales Rep</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    @foreach($leads as $lead)
        <tr data-id="{{$lead->id}}">
            {{--<td>{{getIds($lead->jobs) }}</td>--}}
            <td>{{$lead->customer_name}}</td>
            <td>{{$lead->phone}}</td>
            <td>{{$lead->street}}</td>
            <td>{{$lead->city}}</td>
            <td>{{ formatAppoint($lead->appointment) }}</td>
            <td>{{$lead->salesrep["name"] }}</td>
            <td>{{$lead->status["name"] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>