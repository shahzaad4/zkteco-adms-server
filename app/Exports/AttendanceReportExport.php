<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendanceReportExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $q = DB::table('attendances as a')
            ->leftJoin(DB::raw("(SELECT sn, user_id, MAX(name) as name FROM device_users GROUP BY sn, user_id) du"), function ($join) {
                $join->on('a.sn', '=', 'du.sn')
                     ->on('a.employee_id', '=', 'du.user_id');
            })
            ->selectRaw("
                DATE(a.timestamp) as date,
                a.sn,
                a.employee_id,
                COALESCE(du.name, '') as employee_name,
                MIN(a.timestamp) as check_in,
                MAX(a.timestamp) as check_out,
                TIMEDIFF(MAX(a.timestamp), MIN(a.timestamp)) as total_hours,
                CASE WHEN COUNT(*) = 1 THEN 'Missing Check Out' ELSE 'Complete' END as status,
                COUNT(*) as punch_count
            ");

        if ($this->request->sn) {
            $q->where('a.sn', $this->request->sn);
        }

        if ($this->request->employee_id) {
            $q->where('a.employee_id', $this->request->employee_id);
        }

        if ($this->request->employee_name) {
            $q->where('du.name', 'like', '%' . $this->request->employee_name . '%');
        }

        if ($this->request->from_date) {
            $q->whereDate('a.timestamp', '>=', $this->request->from_date);
        }

        if ($this->request->to_date) {
            $q->whereDate('a.timestamp', '<=', $this->request->to_date);
        }

        return $q->groupByRaw("DATE(a.timestamp), a.sn, a.employee_id, du.name")
            ->orderByRaw("DATE(a.timestamp) DESC")
            ->get();
    }

    public function headings(): array
    {
        return [
            'Date',
            'SN',
            'Employee ID',
            'Employee Name',
            'Check In',
            'Check Out',
            'Total Hours',
            'Status',
            'Punch Count',
        ];
    }
}
