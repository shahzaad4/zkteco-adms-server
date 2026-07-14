@extends('layouts.app')

@section('content')
<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <title>Attendance Report</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f7f7f7; }
        .card { background: #fff; padding: 15px; border-radius: 10px; margin-bottom: 20px; box-shadow: 0 1px 4px rgba(0,0,0,0.08); }
        .filters { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 10px; }
        input, select, button { padding: 10px; border: 1px solid #ccc; border-radius: 6px; width: 100%; }
        button { background: #0d6efd; color: #fff; border: none; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; background: white; }
        table th, table td { padding: 10px; border: 1px solid #ddd; text-align: left; font-size: 14px; }
        table th { background: #f0f0f0; }
        .complete { color: green; font-weight: bold; }
        .missing { color: red; font-weight: bold; }
    </style>
</head>
<body>

    <h1>Attendance Report</h1>

    <div class="card">
        <form method="GET" action="{{ route('attendance.report') }}">
            <div class="filters">
                <select name="sn">
                    <option value="">All Devices</option>
                    @foreach($deviceList as $device)
                        <option value="{{ $device }}" {{ request('sn') == $device ? 'selected' : '' }}>
                            {{ $device }}
                        </option>
                    @endforeach
                </select>

                <input type="date" name="from_date" value="{{ request('from_date') }}">
                <input type="date" name="to_date" value="{{ request('to_date') }}">
                <input type="text" name="employee_id" placeholder="Employee ID" value="{{ request('employee_id') }}">
                <input type="text" name="employee_name" placeholder="Employee Name" value="{{ request('employee_name') }}">
                <button type="submit">Filter</button>
		<a href="{{ url('/attendance-report/export?' . http_build_query(request()->query())) }}" class="btn btn-success">
    Export Excel
</a>
            </div>
        </form>
    </div>

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Device SN</th>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Total Hours</th>
                    <th>Status</th>
                    <th>Punch Count</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $row)
                    <tr>
                        <td>{{ $row->attendance_date }}</td>
                        <td>{{ $row->sn }}</td>
                        <td>{{ $row->employee_id }}</td>
                        <td>{{ $row->employee_name }}</td>
                        <td>{{ $row->check_in }}</td>
                        <td>{{ $row->check_out }}</td>
                        <td>{{ $row->total_hours }}</td>
                        <td>
                            @if($row->status === 'Complete')
                                <span class="complete">{{ $row->status }}</span>
                            @else
                                <span class="missing">{{ $row->status }}</span>
                            @endif
                        </td>
                        <td>{{ $row->punch_count }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">No records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            {{ $records->links() }}
        </div>
    </div>

</body>
</html>


@endsection
