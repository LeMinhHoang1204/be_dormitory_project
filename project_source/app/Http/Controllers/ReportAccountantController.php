<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\ReportAccountant;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class ReportAccountantController extends Controller
{
    public function index(Request $request)
    {
        //For filer
        $total = Invoice::count('total');

        $buildings = Building::pluck('build_name','id')->unique();

        $receiptStatus = Invoice::pluck('status')->unique();

        $receiptsType = Invoice::pluck('type')->unique();

        $schools = Student::pluck('uni_name', 'uni_id')->unique();

        $totalByReceiptType = $this->getTotalByReceiptType($request);

        $totalByMonth = $this->getTotalByMonth($request);

        $totalByBuilding = $this->getTotalByBuilding($request);



        $reportData = [
            'total' => $total,
            'receiptStatus' => $receiptStatus,
            'buildings' => $buildings,
            'receiptsType' => $receiptsType,
            'schools' => $schools,
            'totalByReceiptType' => $totalByReceiptType,
            'totalByMonth' => $totalByMonth,
            'totalByBuilding' => $totalByBuilding,
        ];

//        $reportData = $query;
        return view('Report.report_accountant', compact('reportData'));
    }

    public function getTotalByReceiptType(Request $request)
    {
        $query = Invoice::select('type', DB::raw('SUM(total) as total_amount'))
            ->groupBy('type');

        if ($request->has('buildings') && !empty($request->buildings)) {
            $query->whereIn('building_id', $request->buildings);
        }
        if ($request->has('floors') && !empty($request->floors)) {
            $query->whereIn('floor_id', $request->floors);
        }
        if ($request->has('schools') && !empty($request->schools) && $request->schools != 'All') {
            $query->whereIn('school_id', $request->schools);
        }
        if ($request->has('statuses') && !empty($request->statuses)) {
            $query->whereIn('status', $request->statuses);
        }
        if ($request->has('types') && !empty($request->types)) {
            $query->whereIn('type', $request->types);
        }

        return $query->pluck('total_amount', 'type');
    }


    public function getTotalByMonth(Request $request)
    {
        $query = Invoice::select(DB::raw('MONTH(send_date) as month'), DB::raw('SUM(total) as total_amount'))
            ->groupBy(DB::raw('MONTH(send_date)'));

        if ($request->has('buildings') && !empty($request->buildings)) {
            $query->whereIn('building_id', $request->buildings);
        }
        if ($request->has('floors') && !empty($request->floors)) {
            $query->whereIn('floor_id', $request->floors);
        }
        if ($request->has('schools') && !empty($request->schools) && $request->schools != 'All') {
            $query->whereIn('school_id', $request->schools);
        }
        if ($request->has('statuses') && !empty($request->statuses)) {
            $query->whereIn('status', $request->statuses);
        }
        if ($request->has('types') && !empty($request->types)) {
            $query->whereIn('type', $request->types);
        }

        return $query->pluck('total_amount', 'month');
    }

    public function getTotalByBuilding(Request $request)
    {
        function mergeAndSumArrays($array1, $array2)
        {
            $result = $array1;

            foreach ($array2 as $key => $value) {
                if (isset($result[$key])) {
                    $result[$key] += $value; // Cộng total nếu key đã tồn tại
                } else {
                    $result[$key] = $value; // Thêm key mới nếu chưa tồn tại
                }
            }
            return $result;
        }

        // Truy vấn cho `App\Models\User`
        $userTotals = Invoice::leftJoin('users', function ($join) {
            $join->on('invoices.object_id', '=', 'users.id')
                ->where('invoices.object_type', '=', 'App\Models\User');
        })
            ->join('students', 'users.id', '=', 'students.user_id')
            ->join('residences', 'students.id', '=', 'residences.stu_user_id')
            ->join('rooms', 'residences.room_id', '=', 'rooms.id')
            ->join('buildings', 'rooms.building_id', '=', 'buildings.id')
            ->select('buildings.build_name', DB::raw('SUM(invoices.total) as total_amount'))
            ->groupBy('buildings.build_name');

        if ($request->has('buildings') && !empty($request->buildings)) {
            $userTotals->whereIn('building_id', $request->buildings);
        }
        if ($request->has('floors') && !empty($request->floors)) {
            $userTotals->whereIn('floor_id', $request->floors);
        }
        if ($request->has('schools') && !empty($request->schools) && $request->schools != 'All') {
            $userTotals->whereIn('school_id', $request->schools);
        }
        if ($request->has('statuses') && !empty($request->statuses)) {
            $userTotals->whereIn('status', $request->statuses);
        }
        if ($request->has('types') && !empty($request->types)) {
            $userTotals->whereIn('type', $request->types);
        }

        $userTotals = $userTotals->pluck('total_amount', 'buildings.build_name')->toArray();

        // Thêm kết quả vào tổng
        $totalByBuilding = $userTotals;

        // Truy vấn cho `App\Models\Room`
        $roomTotals = Invoice::leftJoin('rooms', function ($join) {
            $join->on('invoices.object_id', '=', 'rooms.id')
                ->where('invoices.object_type', '=', 'App\Models\Room');
        })
            ->join('buildings', 'rooms.building_id', '=', 'buildings.id')
            ->select('buildings.build_name', DB::raw('SUM(invoices.total) as total_amount'))
            ->groupBy('buildings.build_name');

        if ($request->has('buildings') && !empty($request->buildings)) {
            $roomTotals->whereIn('building_id', $request->buildings);
        }
        if ($request->has('floors') && !empty($request->floors)) {
            $roomTotals->whereIn('floor_id', $request->floors);
        }
        if ($request->has('schools') && !empty($request->schools) && $request->schools != 'All') {
            $roomTotals->whereIn('school_id', $request->schools);
        }
        if ($request->has('statuses') && !empty($request->statuses)) {
            $roomTotals->whereIn('status', $request->statuses);
        }
        if ($request->has('types') && !empty($request->types)) {
            $roomTotals->whereIn('type', $request->types);
        }

        $roomTotals = $roomTotals->pluck('total_amount', 'buildings.build_name')->toArray();

        // Thêm kết quả vào tổng
        $totalByBuilding = mergeAndSumArrays($totalByBuilding, $roomTotals);

        // Truy vấn cho `App\Models\Building`
        $buildingTotals = Invoice::leftJoin('buildings', function ($join) {
            $join->on('invoices.object_id', '=', 'buildings.id')
                ->where('invoices.object_type', '=', 'App\Models\Building');
        })
            ->select('buildings.build_name', DB::raw('SUM(invoices.total) as total_amount'))
            ->groupBy('buildings.build_name');

        if ($request->has('buildings') && !empty($request->buildings)) {
            $totalByBuilding->whereIn('building_id', $request->buildings);
        }
        if ($request->has('floors') && !empty($request->floors)) {
            $totalByBuilding->whereIn('floor_id', $request->floors);
        }
        if ($request->has('schools') && !empty($request->schools) && $request->schools != 'All') {
            $totalByBuilding->whereIn('school_id', $request->schools);
        }
        if ($request->has('statuses') && !empty($request->statuses)) {
            $totalByBuilding->whereIn('status', $request->statuses);
        }
        if ($request->has('types') && !empty($request->types)) {
            $totalByBuilding->whereIn('type', $request->types);
        }

        $buildingTotals = $buildingTotals->pluck('total_amount', 'buildings.build_name')->toArray();

        // Thêm kết quả vào tổng
        $totalByBuilding = mergeAndSumArrays($totalByBuilding, $buildingTotals);

        // Loại bỏ các key rỗng
        $totalByBuilding = array_filter($totalByBuilding, function($key) {
            return $key !== '';
        }, ARRAY_FILTER_USE_KEY);

        return $totalByBuilding;
    }

    public function studentIndex(Request $request)
    {
        $user = auth()->user();
        $id = $user->id;

        $receiptStatus = Invoice::pluck('status')->unique();

        $receiptsType = Invoice::pluck('type')->unique();

        $queryUser = Invoice::where('object_id', $id)->where('object_type', 'App\Models\User');
        $queryRoom = Invoice::join('rooms', function ($join) {
            $join->on('invoices.object_id', '=', 'rooms.id')
                ->where('invoices.object_type', '=', 'App\Models\Room');
        })
            ->join('residences', 'rooms.id', '=', 'residences.room_id')
            ->join('students', 'residences.stu_user_id', '=', 'students.id')
            ->where('students.user_id', $id);

        $total = $queryUser->count('invoices.id') + $queryRoom->count('invoices.id');

        $room = $queryRoom->select('rooms.name');
        if (!$room->exists()) {
            $room = '';
        } else {
            $room = $room->first()->name;
        }

        function mergeAndSumArrays($array1, $array2)
        {
            if (empty($array1) && empty($array2)) {
                return [];
            }

            $result = $array1;

            foreach ($array2 as $key => $value) {
                if (isset($result[$key])) {
                    $result[$key] += $value; // Cộng total nếu key đã tồn tại
                } else {
                    $result[$key] = $value; // Thêm key mới nếu chưa tồn tại
                }
            }
            return $result;
        }

        $receiptsTypeUser = $queryUser->select('type', DB::raw('SUM(total) as total_amount'))
            ->groupBy('type')
            ->pluck('total_amount', 'type')->toArray();
        $receiptsTypeRoom = $queryRoom->select('invoices.type', DB::raw('SUM(total) as total_amount'))
            ->groupBy('invoices.type')
            ->pluck('total_amount', 'type')->toArray();

        $totalByReceiptType = mergeAndSumArrays($receiptsTypeUser, $receiptsTypeRoom);

//        $totalTypePerMonth = $queryUser->select(DB::raw('MONTH(send_date) as month'), 'type', DB::raw('SUM(total) as total_amount'))
//            ->groupBy(DB::raw('MONTH(send_date)'), 'type')
//            ->pluck('total_amount', 'month', 'type')->toArray();

        $queryResult = $queryUser->select( DB::raw('MONTH(send_date) as month'), 'type',
            DB::raw('SUM(total) as total_amount')
        )
            ->groupBy(DB::raw('MONTH(send_date)'), 'type')
            ->get();

        $totalTypePerMonth = [];
        foreach ($queryResult as $row) {
            $type = $row->type;
            $month = $row->month;
            $total = $row->total_amount;

            if (!isset($totalTypePerMonth[$type])) {
                $totalTypePerMonth[$type] = array_fill(1, 12, 0);
            }
            $totalTypePerMonth[$type][$month] = $total;
        }



        $reportData = [
            'total' => $total,
            'id' => $id,
            'room' => $room,
            'receiptStatus' => $receiptStatus,
            'receiptsType' => $receiptsType,
            'totalByReceiptType' => $totalByReceiptType,
            'totalTypePerMonth' => $totalTypePerMonth,
            ];
        return view('Report.report_student', compact('reportData'));
    }
}
