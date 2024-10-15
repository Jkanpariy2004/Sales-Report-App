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

    public function fetch($date) // Accept date as a parameter
    {
        $salesData = DB::table('sale')
            ->select(DB::raw('DATE(created_at) as date, COUNT(grand_total) as total_count, SUM(grand_total) as total_grand'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Check if the requested date exists in the sales data
        $salesForDate = $salesData->firstWhere('date', $date);

        if ($salesForDate) {
            return response()->json($salesForDate);
        } else {
            return response()->json(['message' => 'No sales available for the selected date.'], 404);
        }
    }
}
