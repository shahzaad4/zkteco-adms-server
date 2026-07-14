<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\AttendanceReportExport;
use Maatwebsite\Excel\Facades\Excel;


class AttendanceReportController extends Controller
{


public function export(Request $request)
{
    return Excel::download(new AttendanceReportExport($request), 'attendance-report.xlsx');
}


    public function index(Request $request)
    {
        $deviceUsersSub = DB::table('device_users')
            ->select('sn', 'user_id', DB::raw('MAX(name) as name'))
            ->groupBy('sn', 'user_id');

        $query = DB::table('attendances as a')
            ->leftJoinSub($deviceUsersSub, 'du', function ($join) {
                $join->on('a.sn', '=', 'du.sn')
                     ->on('a.employee_id', '=', 'du.user_id');
            })
            ->selectRaw("
                DATE(a.timestamp) as attendance_date,
                a.sn,
                a.employee_id,
                COALESCE(du.name, '') as employee_name,
                MIN(a.timestamp) as check_in,
                MAX(a.timestamp) as check_out,
                COUNT(*) as punch_count
            ")
            ->groupByRaw("DATE(a.timestamp), a.sn, a.employee_id, du.name");

        if ($request->filled('sn')) {
            $query->where('a.sn', $request->sn);
        }

        if ($request->filled('employee_id')) {
            $query->where('a.employee_id', $request->employee_id);
        }

        if ($request->filled('employee_name')) {
            $query->where('du.name', 'like', '%' . $request->employee_name . '%');
        }

        if ($request->filled('from_date')) {
            $query->whereDate('a.timestamp', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('a.timestamp', '<=', $request->to_date);
        }

        $records = $query
            ->orderByDesc('attendance_date')
            ->orderBy('a.sn')
            ->orderBy('a.employee_id')
            ->paginate(50)
            ->appends($request->all());

        $records->getCollection()->transform(function ($row) {
            if ($row->punch_count <= 1) {
                $row->status = 'Missing Check Out';
                $row->total_hours = '';
            } else {
                $row->status = 'Complete';
                $seconds = strtotime($row->check_out) - strtotime($row->check_in);
                $hours = floor($seconds / 3600);
                $minutes = floor(($seconds % 3600) / 60);
                $row->total_hours = sprintf('%02d:%02d', $hours, $minutes);
            }

            return $row;
        });

        $deviceList = DB::table('attendances')
            ->select('sn')
            ->distinct()
            ->orderBy('sn')
            ->pluck('sn');

        return view('attendance-report.index', compact('records', 'deviceList'));
    }
}
