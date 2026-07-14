<?php

namespace App\Exports;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AttendanceExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = DB::table('attendances as a')
            ->leftJoin(DB::raw("
                (SELECT sn, user_id, MAX(name) as name
                 FROM device_users
                 GROUP BY sn, user_id) as du
            "), function ($join) {
                $join->on('a.sn', '=', 'du.sn')
                     ->on('a.employee_id', '=', 'du.user_id');
            })
            ->selectRaw("
                a.id as ID,
                a.sn as SN,
                a.employee_id as employee_id,
                COALESCE(du.name, '') as employee_name,
                a.timestamp as timestamp,
                CASE
                    WHEN a.status1 = 1 THEN 'Check Out'
                    ELSE 'Check In'
                END as type
            ");

        if ($this->request->filled('sn')) {
            $query->where('a.sn', 'like', '%' . $this->request->sn . '%');
        }

        if ($this->request->filled('employee_id')) {
            $query->where('a.employee_id', $this->request->employee_id);
        }

        if ($this->request->filled('from')) {
            $query->whereDate('a.timestamp', '>=', $this->request->from);
        }

        if ($this->request->filled('to')) {
            $query->whereDate('a.timestamp', '<=', $this->request->to);
        }

        return $query
            ->orderBy('a.timestamp', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'SN',
            'Employee ID',
            'Employee Name',
            'Timestamp',
            'Type',
        ];
    }
}
