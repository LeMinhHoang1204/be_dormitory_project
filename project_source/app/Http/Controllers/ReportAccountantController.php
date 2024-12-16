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
    public function index()
    {
        $total = Invoice::count('total'); // Assuming 'total' is the field for the receipt amount

        $buildings = Building::pluck('build_name','id')->unique();

        $receiptStatus = Invoice::pluck('status')->unique();

        $receiptsType = Invoice::pluck('type')->unique();

        $schools = Student::pluck('uni_name', 'uni_id')->unique();

        $totalByReceiptType = Invoice::select('type', DB::raw('SUM(total) as total_amount'))
            ->groupBy('type')
            ->pluck('total_amount', 'type');

        $totalByMonth = Invoice::select(DB::raw('MONTH(send_date) as month'), DB::raw('SUM(total) as total'))
            ->groupBy(DB::raw('MONTH(send_date)'))
            ->pluck('total', 'month');

        // Lấy dữ liệu group by building
        // Hàm mergeAndSumArrays sẽ merge 2 mảng và cộng các giá trị nếu key đã tồn tại
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
//            ->where('invoices.status', 'Paid')
            ->groupBy('buildings.build_name')
            ->pluck('total_amount', 'buildings.build_name')
            ->toArray();

        // Thêm kết quả vào tổng
        $totalByBuilding = $userTotals;

        // Truy vấn cho `App\Models\Room`
        $roomTotals = Invoice::leftJoin('rooms', function ($join) {
            $join->on('invoices.object_id', '=', 'rooms.id')
                ->where('invoices.object_type', '=', 'App\Models\Room');
        })
            ->join('buildings', 'rooms.building_id', '=', 'buildings.id')
            ->select('buildings.build_name', DB::raw('SUM(invoices.total) as total_amount'))
//            ->where('invoices.status', 'Paid')
            ->groupBy('buildings.build_name')
            ->pluck('total_amount', 'buildings.build_name')
            ->toArray();

        // Thêm kết quả vào tổng
        $totalByBuilding = mergeAndSumArrays($totalByBuilding, $roomTotals);

        // Truy vấn cho `App\Models\Building`
        $buildingTotals = Invoice::leftJoin('buildings', function ($join) {
            $join->on('invoices.object_id', '=', 'buildings.id')
                ->where('invoices.object_type', '=', 'App\Models\Building');
        })
            ->select('buildings.build_name', DB::raw('SUM(invoices.total) as total_amount'))
//            ->where('invoices.status', 'Paid')
            ->groupBy('buildings.build_name')
            ->pluck('total_amount', 'buildings.build_name')
            ->toArray();

// Thêm kết quả vào tổng
        $totalByBuilding = mergeAndSumArrays($totalByBuilding, $buildingTotals);

// Loại bỏ các key rỗng
        $totalByBuilding = array_filter($totalByBuilding, function($key) {
            return $key !== '';
        }, ARRAY_FILTER_USE_KEY);


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
}
