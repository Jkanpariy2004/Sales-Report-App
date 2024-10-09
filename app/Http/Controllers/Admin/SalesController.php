<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use App\Models\Sales;
use App\Models\Sales_Items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function index()
    {
        return view('AdminDashboard.Pages.Sales.Sales');
    }

    public function fetch()
    {
        $sales = Sales::all();

        return response([
            'sales' => $sales,
        ]);
    }

    public function add()
    {
        $customers = Customers::all();

        return view('AdminDashboard.Pages.Sales.Add-Sales', compact('customers'));
    }

    public function getCustomerDetails($id)
    {
        $customer = Customers::find($id);

        if ($customer) {
            return response()->json([
                'gst_no' => $customer->gst_no,
                'place' => $customer->place,
                'transport_no' => $customer->transport_no,
            ]);
        }

        return response()->json(['error' => 'Customer not found'], 404);
    }

    public function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer' => 'required|exists:customers,id',
            'bill_no' => 'required|string|max:255',
            'bill_date' => 'required|date',
            'gst_no' => 'required|string|max:255',
            'place' => 'required|string',
            'state_code' => 'required|string|max:10',
            'transport_no' => 'required|string|max:255',
            'transport_gst_tin_no' => 'required|string|max:255',
            'parcel' => 'required|string|max:255',
            'unit' => 'required|array',
            'quantity' => 'required|array',
            'item_name' => 'required|array',
            'item_details' => 'required|array',
            'price' => 'required|array',
            'hsn_code' => 'required|array',
            'tax_type' => 'required|array',
            'tax' => 'required|array',
            'total' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $sales = Sales::create([
            'customer_name' => $request->customer,
            'bill_no' => $request->bill_no,
            'bill_date' => $request->bill_date,
            'gst_no' => $request->gst_no,
            'place' => $request->place,
            'state_code' => $request->state_code,
            'transport_no' => $request->transport_no,
            'transport_gst_tin_no' => $request->transport_gst_tin_no,
            'parcel' => $request->parcel,
        ]);

        foreach ($request->unit as $key => $unit) {
            Sales_Items::create([
                'sale_id' => $sales->id,
                'unit' => $unit,
                'quantity' => $request->quantity[$key],
                'item_name' => $request->item_name[$key],
                'item_detail' => $request->item_details[$key],
                'price' => $request->price[$key],
                'hsn_code' => $request->hsn_code[$key],
                'tax_type' => $request->tax_type[$key],
                'tax' => $request->tax[$key],
                'total' => $request->total[$key],
            ]);
        }

        return response()->json(['message' => 'Sales report created successfully'], 201);
    }
}
