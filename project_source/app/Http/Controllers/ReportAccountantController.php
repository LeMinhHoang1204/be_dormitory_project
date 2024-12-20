<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\ReportAccountant;
use App\Models\Invoice;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isEmpty;

class ReportAccountantController extends Controller
{
    public function index(Request $request)
    {
//        echo($request);
//        echo($request->building);
//        echo($request->receiptType);
//        $type = '';
//       if ($request->has('receiptType')) {
//            $type = implode('', (array) $request->receiptType);
//        }
//        echo($type);
//
//        exit;

//        $Auth = Auth()->user();
//        if ($Auth->role == 'student') {
//            return redirect()->route('report_student.studentIndex');
//        }

        //For filer
        $total = 0;
        $query = $this->queryJoined();
        foreach ($query as $q) {
            $this->queryCondition($request, $q);

            $total += $q->select(DB::raw('count(invoices.id) as total'))->first()->total;
        }


        $buildings = Building::pluck('build_name')->unique();

        $receiptStatus = Invoice::pluck('invoices.status')->unique();

        $receiptsType = Invoice::pluck('invoices.type')->unique();

        $schools = Student::pluck('uni_name')->unique();

        $totalByReceiptType = $this->getTotalByReceiptType($request);

        $totalByMonth = $this->getTotalByMonth($request);

        $totalByBuilding = $this->getTotalByBuilding($request);

//        echo($request->floor); exit;

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


    public function queryJoined()
    {
        $queryUser = Invoice::leftJoin('users', function ($join) {
            $join->on('invoices.object_id', '=', 'users.id')
                ->where('invoices.object_type', '=', 'App\Models\User');
        })
            ->join('students', 'users.id', '=', 'students.user_id')
            ->join('residences', 'students.id', '=', 'residences.stu_user_id')
            ->join('rooms', 'residences.room_id', '=', 'rooms.id')
            ->join('buildings', 'rooms.building_id', '=', 'buildings.id');

        $queryRoom = Invoice::join('rooms', function ($join) {
            $join->on('invoices.object_id', '=', 'rooms.id')
                ->join('buildings', 'rooms.building_id', '=', 'buildings.id')
                ->where('invoices.object_type', '=', 'App\Models\Room');
        })
            ->join('residences', 'rooms.id', '=', 'residences.room_id')
            ->join('students', 'residences.stu_user_id', '=', 'students.id')
            ->join('users', 'students.user_id', '=', 'users.id');

        $queryBuilding = Invoice::join('buildings', function ($join) {
            $join->on('invoices.object_id', '=', 'buildings.id')
                ->where('invoices.object_type', '=', 'App\Models\Building');
        })
            ->join('rooms', 'buildings.id', '=', 'rooms.building_id')
            ->join('residences', 'rooms.id', '=', 'residences.room_id')
            ->join('students', 'residences.stu_user_id', '=', 'students.id')
            ->join('users', 'students.user_id', '=', 'users.id');

        return [$queryUser, $queryRoom, $queryBuilding];
    }

    public function queryCondition (Request $request, $query)
    {
        if ($request->has('building') && !empty($request->building)) {
            if (is_string($request->building)) {
                // Nếu là chuỗi, chuyển thành mảng
                $buildings = explode(',', $request->building);
                $buildings = array_map('trim', $buildings);
            } elseif (is_array($request->building)) {
                // Nếu đã là mảng, sử dụng trực tiếp
                $buildings = $request->building;
            } else {
                // Trường hợp không hợp lệ
                $buildings = [];
            }
            $query->whereIn('buildings.build_name', $buildings);
        }
        if ($request->has('floor') && !empty($request->floor)) {
          if (is_string($request->floor)) {
                // Nếu là chuỗi, chuyển thành mảng
                $floors = explode(',', $request->floor);
                $floors = array_map('trim', $floors);
            } elseif (is_array($request->floor)) {
                // Nếu đã là mảng, sử dụng trực tiếp
                $floors = $request->floor;
            } else {
                // Trường hợp không hợp lệ
                $floors = [];
            }
            $query->whereIn('rooms.floor_number', $floors);
        }
        if ($request->has('school') && $request->input('school') != 'all') {
            $query->whereIn('students.uni_name', (array) $request->input('school'));
        }
        if($request->has('gender') && $request->input('gender') != 'all') {
            $query->where('buildings.type', (array) $request->input('gender'));
        }
        if ($request->has('receiptStatus') && !empty($request->receiptStatus)) {
            $query->whereIn('invoices.status', (array) $request->receiptStatus);
        }
        if ($request->has('receiptType') && !empty($request->receiptType)) {
            $query->whereIn('invoices.type', (array) $request->receiptType);
        }
    }

    public function getTotalByReceiptType(Request $request)
    {
        $queries = $this->queryJoined();

        foreach ($queries as $query) {
            $query->select('invoices.type', DB::raw('SUM(total) as total_amount'))
                ->groupBy('invoices.type');
            $this->queryCondition($request, $query);
        }
        $result = [];
        foreach ($queries as $query) {
            $result = $this->mergeAndSumArrays($query->pluck('total_amount', 'invoices.type')->toArray(), $result);
        }

        return $result;
    }

    public function getTotalByMonth(Request $request)
    {
        $queries = $this->queryJoined();

        foreach ($queries as $query) {
            $query->select(DB::raw('MONTH(send_date) as month'), DB::raw('SUM(total) as total_amount'))
                ->groupBy(DB::raw('MONTH(send_date)'));
            $this->queryCondition($request, $query);
        }
        $result = [];
        foreach ($queries as $query) {
            $result = $this->mergeAndSumArrays($query->pluck('total_amount', 'month')->toArray(), $result);
        }

        return $result;
    }
    public function mergeAndSumArrays($array1, $array2)
    {
        $result = $array1;

        foreach ($array2 as $key => $value) {
            if (isset($result[$key])) {
                $result[$key] += $value; // Cộng total nếu key đã tồn tại
            } else {
                $result[$key] = $value; // Thêm key mới nếu chưa tồn tại
            }
        }
        return collect($result);
    }
    public function getTotalByBuilding(Request $request)
    {
        $queries = $this->queryJoined();

        foreach ($queries as $query) {
            $query->select('buildings.build_name', DB::raw('SUM(total) as total_amount'))
                ->groupBy('buildings.build_name');
            $this->queryCondition($request, $query);
        }

        $result = [];
        foreach ($queries as $query) {
            $result = $this->mergeAndSumArrays($query->pluck('total_amount', 'build_name')->toArray(), $result);
        }
        // Loại bỏ các key rỗng
        $result = array_filter($result->toArray(), function($key) {
            return $key !== '';
        }, ARRAY_FILTER_USE_KEY);

        return $result;
    }

    public function studentIndex(Request $request)
    {
        $user = auth()->user();
        $id = $user->id;

        //for filter
        $receiptStatus = Invoice::pluck('invoices.status')->unique();

        $receiptsType = Invoice::pluck('invoices.type')->unique();

        $queryUser = Invoice::where('object_id', $id)->where('object_type', 'App\Models\User');
        $queryRoom = Invoice::join('rooms', function ($join) {
            $join->on('invoices.object_id', '=', 'rooms.id')
                ->where('invoices.object_type', '=', 'App\Models\Room');
        })
            ->join('residences', 'rooms.id', '=', 'residences.room_id')
            ->join('students', 'residences.stu_user_id', '=', 'students.id')
            ->where('students.user_id', $id);

        $total = $queryUser->count() + $queryRoom->count();

        $room = $queryRoom->select('rooms.name');
        if (!$room->exists()) {
            $room = '';
        } else {
            $room = $room->first()->name;
        }

        $totalByReceiptType =  [];

        foreach ([$queryUser, $queryRoom] as $q) {
            if($request->has('receiptType') && !empty($request->receiptType)) {
                $q->whereIn('invoices.type', (array) $request->receiptType);
            }
            if($request->has('receiptStatus') && !empty($request->receiptStatus)) {
                $q->whereIn('invoices.status', (array) $request->receiptStatus);
            }
            $result = $q->select('invoices.type', DB::raw('SUM(total) as total_amount'))
                ->groupBy('invoices.type')
                ->pluck('total_amount', 'invoices.type')->toArray();
            $totalByReceiptType = $this->mergeAndSumArrays($receiptsType, $result);
        }



//        $totalTypePerMonth = $queryUser->select(DB::raw('MONTH(send_date) as month'), 'invoices.type', DB::raw('SUM(total) as total_amount'))
//            ->groupBy(DB::raw('MONTH(send_date)'), 'invoices.type')
//            ->pluck('total_amount', 'month', 'invoices.type')->toArray();
        $i=0;
        foreach ([$queryUser, $queryRoom] as $q) {
            if($request->has('receiptType') && !empty($request->receiptType)) {
                $q->whereIn('invoices.type', (array) $request->receiptType);
            }
            if($request->has('receiptStatus') && !empty($request->receiptStatus)) {
                $q->whereIn('invoices.status', (array) $request->receiptStatus);
            }
            $result = $q->select( DB::raw('MONTH(send_date) as month'), 'invoices.type',
                DB::raw('SUM(total) as total_amount')
            )
                ->groupBy(DB::raw('MONTH(send_date)'), 'invoices.type');
            $queryResult[++$i] = $result;
        }

        //Merge 2 query
        $queryResult = $queryResult[1]->union($queryResult[2]);

//        echo($queryResult[1]->toArray());
//        echo($queryResult[2]->toArray());
//        echo($queryResult->toArray());
//        exit;

//        $queryResult = $queryUser->select( DB::raw('MONTH(send_date) as month'), 'invoices.type',
//            DB::raw('SUM(total) as total_amount')
//        )
//            ->groupBy(DB::raw('MONTH(send_date)'), 'invoices.type');
//        if ($request->has('receiptType') && !empty($request->receiptType)) {
//            $queryResult->whereIn('invoices.type', (array) $request->receiptType);
//        }
//        if ($request->has('receiptStatus') && !empty($request->receiptStatus)) {
//            $queryResult->whereIn('invoices.status', (array) $request->receiptStatus);
//        }

//        echo($queryResult); exit;

        $totalTypePerMonth = [];

        foreach ($queryResult as $row) {
            $type = $row->type;
            $month = $row->month;
            $total_amount = $row->total_amount;

            if (!isset($totalTypePerMonth[$type])) {
                $totalTypePerMonth[$type] = array_fill(0, 12, 0);
            }
            if(isset($totalTypePerMonth[$type][$month])) {
                $totalTypePerMonth[$type][$month] = $totalTypePerMonth[$type][$month] + $total_amount;
            }
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
