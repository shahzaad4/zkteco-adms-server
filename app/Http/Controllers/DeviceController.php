<?php

namespace App\Http\Controllers;
use App\Exports\AttendanceExport;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Attendance;
use App\Models\DeviceCommand;
use App\Models\DeviceUser;
use Illuminate\Support\Facades\DB;
class DeviceController extends Controller
{



    // Menampilkan daftar device
    public function index(Request $request)
    {
        $data['lable'] = "Devices";
        $data['log'] = DB::table('devices')->select('id','no_sn','online')->orderBy('online', 'DESC')->get();
        return view('devices.index',$data);
    }

    public function DeviceLog(Request $request)
    {
        $data['lable'] = "Devices Log";
        $data['log'] = DB::table('device_log')->select('id','data','url')->orderBy('id','DESC')->get();
        
        return view('devices.log',$data);
    }
    
    public function FingerLog(Request $request)
    {
        $data['lable'] = "Finger Log";
        $data['log'] = DB::table('finger_log')->select('id','data','url')->orderBy('id','DESC')->get();
        return view('devices.log',$data);
    }


public function attendance(Request $request)
{
    $data['table'] = 'Attendance';

    $data['attendances'] = DB::table('attendances as a')
        ->leftJoin(DB::raw("
            (SELECT sn, user_id, MAX(name) as name
             FROM device_users
             GROUP BY sn, user_id) as du
        "), function ($join) {
            $join->on('a.sn', '=', 'du.sn')
                 ->on('a.employee_id', '=', 'du.user_id');
        })
        ->selectRaw("
            a.id,
            a.sn,
            a.employee_id,
            COALESCE(du.name, '') as employee_name,
            a.timestamp,
            CASE
                WHEN a.status1 = 1 THEN 'Check Out'
                ELSE 'Check In'
            END as punch_type
        ")
        ->when($request->sn, fn($q) => $q->where('a.sn', 'like', '%' . $request->sn . '%'))
        ->when($request->employee_id, fn($q) => $q->where('a.employee_id', $request->employee_id))
        ->when($request->from, fn($q) => $q->whereDate('a.timestamp', '>=', $request->from))
        ->when($request->to, fn($q) => $q->whereDate('a.timestamp', '<=', $request->to))
        ->orderBy('a.timestamp', 'desc')
        ->paginate(50)
        ->withQueryString();

    return view('devices.attendance', $data);
}


//public function exportAttendance(Request $request)
//{
//    return Excel::download(new AttendanceExport($request), 'attendance.xlsx');

//}
public function exportAttendance(Request $request)
{
    return Excel::download(new AttendanceExport($request), 'attendance.xlsx');
}



public function getRequest(Request $request)
{
    $sn = trim($request->query('SN') ?? $request->query('sn') ?? '');

    $command = DeviceCommand::where('sn', $sn)
        ->where('executed', 0)
        ->orderBy('id', 'asc')
        ->first();

    if ($command) {
        $command->executed = 1;
        $command->save();

        return response($command->command . "\n", 200)
            ->header('Content-Type', 'text/plain');
    }

    return response("OK\n", 200)->header('Content-Type', 'text/plain');
}

public function deviceUsers(Request $request)
{
    $deviceUsers = DeviceUser::query()
        ->when($request->sn, fn($q) => $q->where('sn', 'like', '%' . $request->sn . '%'))
        ->when($request->user_id, fn($q) => $q->where('user_id', 'like', '%' . $request->user_id . '%'))
        ->when($request->name, fn($q) => $q->where('name', 'like', '%' . $request->name . '%'))
        ->orderBy('sn')
        ->orderBy('user_id')
        ->paginate(100)
        ->withQueryString();

    return view('devices.users', compact('deviceUsers'));
}


    // // Menampilkan form tambah device
    // public function create()
    // {
    //     return view('devices.create');
    // }

    // // Menyimpan device baru ke database
    // public function store(Request $request)
    // {
    //     $device = new Device();
    //     $device->nama = $request->input('nama');
    //     $device->no_sn = $request->input('no_sn');
    //     $device->lokasi = $request->input('lokasi');
    //     $device->save();

    //     return redirect()->route('devices.index')->with('success', 'Device berhasil ditambahkan!');
    // }

    // // Menampilkan detail device
    // public function show($id)
    // {
    //     $device = Device::find($id);
    //     return view('devices.show', compact('device'));
    // }

    // // Menampilkan form edit device
    // public function edit($id)
    // {
    //     $device = Device::find($id);
    //     return view('devices.edit', compact('device'));
    // }

    // // Mengupdate device ke database
    // public function update(Request $request, $id)
    // {
    //     $device = Device::find($id);
    //     $device->nama = $request->input('nama');
    //     $device->no_sn = $request->input('no_sn');
    //     $device->lokasi = $request->input('lokasi');
    //     $device->save();

    //     return redirect()->route('devices.index')->with('success', 'Device berhasil diupdate!');
    // }

    // // Menghapus device dari database
    // public function destroy($id)
    // {
    //     $device = Device::find($id);
    //     $device->delete();

    //     return redirect()->route('devices.index')->with('success', 'Device berhasil dihapus!');
    // }
}
