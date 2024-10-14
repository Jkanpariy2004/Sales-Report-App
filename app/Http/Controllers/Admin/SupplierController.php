<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    public function index()
    {
        return view('AdminDashboard.Pages.Supplier.Supplier');
    }

    public function fetch()
    {
        $suppliers = Supplier::all();

        return response([
            'suppliers' => $suppliers,
        ]);
    }

    public function add()
    {
        return view('AdminDashboard.Pages.Supplier.Add-Supplier');
    }

    public function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required',
            'supplier_name' => 'required',
            'gst_no' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $supplier = new Supplier();

        $supplier->company = $request->company_name;
        $supplier->name = $request->supplier_name;
        $supplier->gst_no = $request->gst_no;
        $supplier->email = $request->email;
        $supplier->phone = $request->phone;
        $supplier->address = $request->address;
        $supplier->city = $request->city;

        $supplier->save();

        return response()->json(['message' => 'Supplier Created Successfully.'], 201);
    }

    public function edit($id)
    {
        $show = Supplier::all();
        $new = Supplier::find($id);
        $com = compact('show', 'new');
        return view('AdminDashboard.Pages.Supplier.Edit-Supplier', $com);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required',
            'supplier_name' => 'required',
            'gst_no' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $supplier = Supplier::find($id);

        $supplier->company = $request->company_name;
        $supplier->name = $request->supplier_name;
        $supplier->gst_no = $request->gst_no;
        $supplier->email = $request->email;
        $supplier->phone = $request->phone;
        $supplier->address = $request->address;
        $supplier->city = $request->city;

        $supplier->save();

        return response()->json(['message' => 'Supplier Updated Successfully.'], 201);
    }

    public function delete($id)
    {
        $supplier = Supplier::find($id);

        if ($supplier) {
            $supplier->delete();
            return response()->json(['status' => 'success', 'message' => 'Supplier deleted successfully.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Supplier not found.'], 404);
        }
    }

}
