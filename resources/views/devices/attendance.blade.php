@extends('layouts.app')  {{-- Asumsikan Anda memiliki layout utama --}}

@section('content')
<div class="container">
    <h2 class="mb-4">Attendance</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

<form method="GET" action="{{ url('/attendance') }}" style="margin-bottom:15px;">
    <div style="display:flex; gap:10px; flex-wrap:wrap;">

        <input type="text" name="sn"
               placeholder="Device SN"
               value="{{ request('sn') }}"
               class="form-control"
               style="width:180px;">

        <input type="text" name="employee_id"
               placeholder="Employee ID"
               value="{{ request('employee_id') }}"
               class="form-control"
               style="width:150px;">

        <input type="date" name="from"
               value="{{ request('from') }}"
               class="form-control"
               style="width:160px;">

        <input type="date" name="to"
               value="{{ request('to') }}"
               class="form-control"
               style="width:160px;">

        <button type="submit" class="btn btn-primary">
            Search
        </button>

        <a href="{{ url('/attendance') }}" class="btn btn-secondary">
            Reset
        </a>

        <a href="{{ route('attendance.export', request()->query()) }}"
           class="btn btn-success">
            Export Excel
        </a>

    </div>
</form>

            
    <div class="table-responsive">
        <table class="table table-bordered data-table">
            <thead class="thead-dark">
                <tr>
<th>ID</th>
<th>SN</th>
<th>Employee ID</th>
<th>Employee Name</th>
<th>Timestamp</th>
<th>Type</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendances as $attendance)
                    <tr>
<td>{{ $attendance->id }}</td>
<td>{{ $attendance->sn }}</td>
<td>{{ $attendance->employee_id }}</td>
<td>{{ $attendance->employee_name }}</td>
<td>{{ $attendance->timestamp }}</td>
<td>{{ $attendance->punch_type }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- source: https://stackoverflow.com/a/70119390 -->
    <div class="d-felx justify-content-center">
        {{ $attendances->links() }}  {{-- Tampilkan pagination jika ada --}}
    </div>


</div>
@endsection
