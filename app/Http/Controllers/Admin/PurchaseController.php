<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\Purchase;
use App\Models\Purchase_Item;
use App\Models\Purchase_Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {
        return view('AdminDashboard.Pages.Purchase.Purchase');
    }

    public function fetch()
    {
        $purchases = DB::table('purchase')
            ->leftJoin('supplier', 'purchase.supplier', '=', 'supplier.id')
            ->select('purchase.*', 'supplier.name', 'supplier.email', 'supplier.gst_no', 'supplier.address')
            ->get();

        return response([
            'purchases' => $purchases,
        ]);
    }

    public function getItemPrice($id)
    {
        $product = Products::find($id);

        if ($product) {
            return response()->json(['cost' => $product->product_price]);
        }

        return response()->json(['cost' => 0], 404);
    }

    public function getPurchaseItems($id)
    {
        $purchaseItems = Purchase_Item::where('purchase_id', $id)->get();

        return response()->json($purchaseItems);
    }

    public function add()
    {
        $suppliers = Supplier::all();
        $products = Products::all();

        return view('AdminDashboard.Pages.Purchase.Add-Purchase', compact('suppliers', 'products'));
    }

    public function insert(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'supplier' => 'required|exists:supplier,id',
                'unit.*' => 'required',
                'quantity.*' => 'required|numeric|min:1',
                'item_name.*' => 'required|string',
                'item_details.*' => 'required|string',
                'cost.*' => 'required|numeric|min:0',
                'hsn_code.*' => 'required|string',
                'tax_type.*' => 'required',
                'tax.*' => 'required|numeric|min:0',
            ]);

            $Purchase = Purchase::create([
                'supplier' => $request->supplier,
                'grand_total' => $request->grandTotal,
            ]);

            foreach ($request->unit as $key => $unit) {
                Purchase_Item::create([
                    'purchase_id' => $Purchase->id,
                    'unit' => $unit,
                    'quantity' => $request->quantity[$key],
                    'item_name' => $request->item_name[$key],
                    'item_details' => $request->item_details[$key],
                    'cost' => $request->cost[$key],
                    'hsn_code' => $request->hsn_code[$key],
                    'tax_type' => $request->tax_type[$key],
                    'tax' => $request->tax[$key],
                    'total' => $request->total[$key],
                ]);

                $purchase = Products::where('id', $request->item_name[$key])->first();

                if ($purchase) {
                    $purchase->product_stock += $request->quantity[$key];
                    $purchase->save();
                }
            }

            DB::commit();

            return response()->json(['message' => 'Purchase added successfully!'], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['message' => 'Failed to add purchase', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'supplier' => 'required|exists:supplier,id',
                'unit.*' => 'required',
                'quantity.*' => 'required|numeric|min:1',
                'item_name.*' => 'required|string',
                'item_details.*' => 'required|string',
                'cost.*' => 'required|numeric|min:0',
                'hsn_code.*' => 'required|string',
                'tax_type.*' => 'required',
                'tax.*' => 'required|numeric|min:0',
            ]);

            $purchase = Purchase::find($id);

            $purchase->update([
                'supplier' => $request->supplier,
                'grand_total' => $request->grandTotal,
            ]);

            if (is_array($request->unit)) {
                foreach ($request->unit as $key => $unit) {
                    Purchase_Item::create([
                        'purchase_id' => $purchase->id ?? null,
                        'unit' => $unit ?? null,
                        'quantity' => $request->quantity[$key] ?? null,
                        'item_name' => $request->item_name[$key] ?? null,
                        'item_details' => $request->item_details[$key] ?? null,
                        'cost' => $request->cost[$key] ?? null,
                        'hsn_code' => $request->hsn_code[$key] ?? null,
                        'tax_type' => $request->tax_type[$key] ?? null,
                        'tax' => $request->tax[$key] ?? null,
                        'total' => $request->total[$key] ?? null,
                    ]);

                    $product = Products::where('id', $request->item_name[$key])->first();

                    if ($product) {
                        $product->product_stock += $request->quantity[$key];
                        $product->save();
                    }
                }
            }

            DB::commit();

            return response()->json(['message' => 'Purchase Updated successfully!'], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['message' => 'Failed to Update purchase', 'error' => $e->getMessage()], 500);
        }
    }
    public function edit($id)
    {
        $products = Products::all();
        $new = Purchase::find($id);
        $show = Purchase::all();
        $supplier = Supplier::find($id);
        $suppliers = Supplier::all();
        $SalesItems = Purchase_Item::leftJoin('product', 'purchase_item.item_name', '=', 'product.id')
            ->where('purchase_item.purchase_id', $id)
            ->get(['purchase_item.*', 'product.product_name']);
        $com = compact('show', 'new', 'suppliers', 'supplier', 'SalesItems', 'products');
        return view('AdminDashboard.Pages.Purchase.Edit-Purchase', $com);
    }

    public function deletePurchaseItem($id)
    {
        $salesItem = Purchase_Item::findOrFail($id);

        $salesItem->delete();

        return response()->json(['success' => 'Purchase Item deleted successfully']);
    }

    public function delete($id)
    {
        $spurchase = Purchase::find($id);

        if (!$spurchase) {
            return response()->json(['message' => 'Purchase Item not found'], 404);
        }

        Purchase_Item::where('purchase_id', $spurchase->id)->delete();

        $spurchase->delete();

        return response()->json(['message' => 'Purchase deleted successfully'], 200);
    }

    public function updatePurchaseItem(Request $request, $id)
    {
        $request->validate([
            'unit' => 'required',
            'quantity' => 'required',
            'item_name' => 'required',
            'item_detail' => 'required',
            'cost' => 'required',
            'hsn_code' => 'required',
            'tax_type' => 'required',
            'tax' => 'required',
            'total' => 'required',
        ]);

        $salesItem = Purchase_Item::find($id);

        if (!$salesItem) {
            return response()->json(['success' => false, 'message' => 'Item not found'], 404);
        }

        $currentQuantity = $salesItem->quantity;

        $salesItem->unit = $request->unit;
        $salesItem->quantity = $request->quantity;
        $salesItem->item_name = $request->item_name;
        $salesItem->item_details = $request->item_detail;
        $salesItem->cost = $request->cost;
        $salesItem->hsn_code = $request->hsn_code;
        $salesItem->tax_type = $request->tax_type;
        $salesItem->tax = $request->tax;
        $salesItem->total = $request->total;

        $salesItem->save();

        $product = Products::where('id', $request->item_name)->first();
        if ($product) {
            $product->product_stock -= $currentQuantity;
            $product->product_stock += $request->quantity;
            $product->save();
        }

        return response()->json(['success' => true, 'message' => 'Item updated successfully']);
    }
}
