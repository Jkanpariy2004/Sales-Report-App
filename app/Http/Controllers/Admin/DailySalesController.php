<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DailySalesController extends Controller
{
    public function index()
    {
        return view('AdminDashboard.Pages.Daily-Sales.Daily-Sales');
    }

    public function fetch(Request $request)
    {
        $startDate = $request->input('start');
        $endDate = $request->input('end');

        $salesData = DB::table('sale')
            ->select(DB::raw('DATE(created_at) as date'), 'bill_no', DB::raw('SUM(grand_total) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date', 'bill_no')
            ->orderBy('date', 'asc')
            ->get()
            ->groupBy('date');

        $formattedSalesData = [];
        foreach ($salesData as $date => $bills) {
            $dateTotal = $bills->sum('total');
            $formattedSalesData[] = [
                'date' => $date,
                'total' => $dateTotal,
                'bills' => $bills->toArray(),
            ];
        }

        $totalSum = collect($formattedSalesData)->sum('total');

        return response()->json([
            'salesData' => $formattedSalesData,
            'totalSum' => $totalSum,
            'dateRange' => ['start' => $startDate, 'end' => $endDate],
        ]);
    }

}
