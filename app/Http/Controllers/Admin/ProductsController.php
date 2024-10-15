<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    public function index(){
        return view('AdminDashboard.Pages.Products.Product');
    }

    public function fetch(){
        $products = Products::all();

        return response([
            'products' => $products
        ]);
    }

    public function add(){
        return view('AdminDashboard.Pages.Products.Add-Product');
    }

    public function insert(Request $request){
        $validator = Validator::make($request->all(), [
            'product_name' => 'required',
            'product_sku' => 'required',
            'product_price' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $admin = new Products();
        $admin->product_name = $request->product_name;
        $admin->product_sku = $request->product_sku;
        $admin->product_price = $request->product_price;
        $admin->product_stock = '0';

        $admin->save();

        return response()->json(['message' => 'Product created successfully!'], 200);
    }

    public function edit($id)
    {
        $show = Products::all();
        $new = Products::find($id);
        $com = compact('show', 'new');
        return view('AdminDashboard.Pages.Products.Edit-Product', $com);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'product_name' => 'required',
            'product_sku' => 'required',
            'product_price' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $admin = Products::find($id);
        $admin->product_name = $request->product_name;
        $admin->product_sku = $request->product_sku;
        $admin->product_price = $request->product_price;

        $admin->save();

        return response()->json(['message' => 'Product Updated successfully!'], 200);
    }

    public function delete($id)
    {
        $company = Products::find($id);
        if ($company) {
            $company->delete();
            return response()->json(['status' => 'success', 'message' => 'Product deleted successfully.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Product not found.'], 404);
        }
    }
}
