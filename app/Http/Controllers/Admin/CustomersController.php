<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomersController extends Controller
{
    public function index(){
        return view('AdminDashboard.Pages.Customers.Customers');
    }

    public function fetch(){
        $customers = Customers::all();

        return response([
            'customers' => $customers
        ]);
    }

    public function add(){
        return view('AdminDashboard.Pages.Customers.Add-Customers');
    }

    public function insert(Request $request){
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required',
            'customer_email' => 'required',
            'gst_no' => 'required',
            'place' => 'required',
            'state_code' => 'required',
            'transport_no' => 'required',
            'transport_gst_tin_no' => 'required',
            'parcel' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $admin = new Customers();
        $admin->customer_name = $request->customer_name;
        $admin->customer_email = $request->customer_email;
        $admin->gst_no = $request->gst_no;
        $admin->place = $request->place;
        $admin->state_code = $request->state_code;
        $admin->transport_no = $request->transport_no;
        $admin->transport_gst_tin_no = $request->transport_gst_tin_no;
        $admin->parcel = $request->parcel;

        $admin->save();

        return response()->json(['message' => 'Customers created successfully!'], 200);
    }

    public function edit($id)
    {
        $show = Customers::all();
        $new = Customers::find($id);
        $com = compact('show', 'new');
        return view('AdminDashboard.Pages.Customers.Edit-Customers', $com);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required',
            'customer_email' => 'required',
            'gst_no' => 'required',
            'place' => 'required',
            'state_code' => 'required',
            'transport_no' => 'required',
            'transport_gst_tin_no' => 'required',
            'parcel' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $admin = Customers::find($id);
        $admin->customer_name = $request->customer_name;
        $admin->customer_email = $request->customer_email;  
        $admin->gst_no = $request->gst_no;
        $admin->place = $request->place;
        $admin->state_code = $request->state_code;
        $admin->transport_no = $request->transport_no;
        $admin->transport_gst_tin_no = $request->transport_gst_tin_no;
        $admin->parcel = $request->parcel;

        $admin->save();

        return response()->json(['message' => 'Customers Updated successfully!'], 200);
    }

    public function delete($id)
    {
        $company = Customers::find($id);
        if ($company) {
            $company->delete();
            return response()->json(['status' => 'success', 'message' => 'Customers deleted successfully.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Customers not found.'], 404);
        }
    }
}
