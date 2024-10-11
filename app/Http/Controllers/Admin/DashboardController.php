<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use App\Models\Sales;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $Bill = Sales::all()->count();
        $Customer = Customers::all()->count();

        return view('AdminDashboard.Pages.Dashboard.Index',compact('Bill','Customer'));
    }
}
