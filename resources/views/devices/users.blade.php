@extends('layouts.app')

@section('content')
<div class="container">

    <h3>Device Users</h3>

    <form method="GET" action="{{ route('device-users') }}" style="margin-bottom:15px;">
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <input type="text" name="sn" placeholder="Device SN" value="{{ request('sn') }}" class="form-control" style="width:220px;">
            <input type="text" name="user_id" placeholder="User ID" value="{{ request('user_id') }}" class="form-control" style="width:150px;">
            <input type="text" name="name" placeholder="Name" value="{{ request('name') }}" class="form-control" style="width:180px;">

            <button type="submit" class="btn btn-primary">Search</button>
            <a href="{{ route('device-users') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Device SN</th>
                <th>User ID</th>
                <th>Name</th>
                <th>Privilege</th>
                <th>Card</th>
                <th>Group</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($deviceUsers as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->sn }}</td>
                    <td>{{ $user->user_id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->privilege }}</td>
                    <td>{{ $user->card }}</td>
                    <td>{{ $user->group_id }}</td>
                    <td>{{ $user->updated_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $deviceUsers->links() }}

</div>
@endsection
