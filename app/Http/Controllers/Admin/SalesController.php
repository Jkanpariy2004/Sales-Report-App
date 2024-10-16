<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use App\Models\Products;
use App\Models\Sales;
use App\Models\Sales_Items;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SalesController extends Controller
{
    public function index()
    {
        $salesItems = Sales_Items::all();
        return view('AdminDashboard.Pages.Sales.Sales', compact('salesItems'));
    }

    public function fetch()
    {
        $sales = Sales::with(['items' => function ($query) {
            $query->select('sale_item.*')
                ->leftJoin('product', 'sale_item.item_name', '=', 'product.id')
                ->addSelect('product.product_name');
        }])
            ->join('customers', 'sale.customer_id', '=', 'customers.id')
            ->select('sale.*', 'customers.customer_name as customer_name')
            ->get();

        return response([
            'sales' => $sales,
        ]);
    }



    public function getSalesItems($id)
    {
        $salesItems = Sales_Items::where('sale_id', $id)->get();

        return response()->json($salesItems);
    }

    public function add()
    {
        $customers = Customers::all();
        $products = Products::all();

        return view('AdminDashboard.Pages.Sales.Add-Sales', compact('customers', 'products'));
    }

    public function getCustomerDetails($id)
    {
        $customer = Customers::find($id);

        if ($customer) {
            return response()->json([
                'gst_no' => $customer->gst_no,
                'place' => $customer->place,
                'transport_no' => $customer->transport_no,
                'state_code' => $customer->state_code,
                'transport_gst_tin_no' => $customer->transport_gst_tin_no,
                'parcel' => $customer->parcel,
            ]);
        }

        return response()->json(['error' => 'Customer not found'], 404);
    }

    public function getItemPrice($id)
    {
        $product = Products::find($id);

        if ($product) {
            return response()->json(['price' => $product->product_price]);
        }

        return response()->json(['price' => 0], 404);
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
            'customer_id' => $request->customer,
            'bill_no' => $request->bill_no,
            'bill_date' => $request->bill_date,
            'gst_no' => $request->gst_no,
            'place' => $request->place,
            'state_code' => $request->state_code,
            'transport_no' => $request->transport_no,
            'transport_gst_tin_no' => $request->transport_gst_tin_no,
            'parcel' => $request->parcel,
            'grand_total' => $request->grandTotal,
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

            $product = Products::where('id', $request->item_name[$key])->first();

            if ($product) {
                $product->product_stock -= $request->quantity[$key];
                $product->save();
            }
        }

        return response()->json(['message' => 'Sales report created successfully'], 201);
    }

    public function update(Request $request, $id)
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
            'unit' => 'nullable',
            'quantity' => 'nullable',
            'item_name' => 'nullable',
            'item_details' => 'nullable',
            'price' => 'nullable',
            'hsn_code' => 'nullable',
            'tax_type' => 'nullable',
            'tax' => 'nullable',
            'total' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $sales = Sales::find($id);

        if (!$sales) {
            return response()->json(['message' => 'Sales report not found'], 404);
        }

        $sales->update([
            'customer_id' => $request->customer,
            'bill_no' => $request->bill_no,
            'bill_date' => $request->bill_date,
            'gst_no' => $request->gst_no,
            'place' => $request->place,
            'state_code' => $request->state_code,
            'transport_no' => $request->transport_no,
            'transport_gst_tin_no' => $request->transport_gst_tin_no,
            'parcel' => $request->parcel,
            'grand_total' => $request->grandTotal,
        ]);

        if (is_array($request->unit)) {
            foreach ($request->unit as $key => $unit) {
                Sales_Items::create([
                    'sale_id' => $sales->id ?? null,
                    'unit' => $unit ?? null,
                    'quantity' => $request->quantity[$key] ?? null,
                    'item_name' => $request->item_name[$key] ?? null,
                    'item_detail' => $request->item_details[$key] ?? null,
                    'price' => $request->price[$key] ?? null,
                    'hsn_code' => $request->hsn_code[$key] ?? null,
                    'tax_type' => $request->tax_type[$key] ?? null,
                    'tax' => $request->tax[$key] ?? null,
                    'total' => $request->total[$key] ?? null,
                ]);

                $product = Products::where('id', $request->item_name[$key])->first();

                if ($product) {
                    $product->product_stock -= $request->quantity[$key];
                    $product->save();
                }
            }
        }

        return response()->json(['message' => 'Sales report updated successfully'], 200);
    }

    public function edit($id)
    {
        $products = Products::all();
        $new = Sales::find($id);
        $show = Sales::all();
        $customer = Customers::find($id);
        $customers = Customers::all();
        $SalesItems = Sales_Items::leftJoin('product', 'sale_item.item_name', '=', 'product.id')
            ->where('sale_item.sale_id', $id)
            ->get(['sale_item.*', 'product.product_name']);
        $com = compact('show', 'new', 'customers', 'customer', 'SalesItems', 'products');
        return view('AdminDashboard.Pages.Sales.Edit-Sales', $com);
    }

    public function updateSalesItem(Request $request, $id)
    {
        $request->validate([
            'unit' => 'required',
            'quantity' => 'required',
            'item_name' => 'required',
            'item_detail' => 'required',
            'price' => 'required',
            'hsn_code' => 'required',
            'tax_type' => 'required',
            'tax' => 'required',
            'total' => 'required',
        ]);

        $salesItem = Sales_Items::find($id);

        if (!$salesItem) {
            return response()->json(['success' => false, 'message' => 'Item not found'], 404);
        }

        $currentQuantity = $salesItem->quantity;

        $salesItem->unit = $request->unit;
        $salesItem->quantity = $request->quantity;
        $salesItem->item_name = $request->item_name;
        $salesItem->item_detail = $request->item_detail;
        $salesItem->price = $request->price;
        $salesItem->hsn_code = $request->hsn_code;
        $salesItem->tax_type = $request->tax_type;
        $salesItem->tax = $request->tax;
        $salesItem->total = $request->total;

        $salesItem->save();

        $product = Products::where('id', $request->item_name)->first();
        if ($product) {
            $product->product_stock += $currentQuantity;
            $product->product_stock -= $request->quantity;
            $product->save();
        }

        return response()->json(['success' => true, 'message' => 'Item updated successfully']);
    }


    public function deleteSalesItem($id)
    {
        $salesItem = Sales_Items::findOrFail($id);

        $salesItem->delete();

        return response()->json(['success' => 'Sales item deleted successfully']);
    }

    public function delete($id)
    {
        $sales = Sales::find($id);

        if (!$sales) {
            return response()->json(['message' => 'Sales report not found'], 404);
        }

        Sales_Items::where('sale_id', $sales->id)->delete();

        $sales->delete();

        return response()->json(['message' => 'Sales report deleted successfully'], 200);
    }

    public function generateInvoice($id)
    {
        $sale = Sales::with(['items' => function ($query) {
            $query->leftJoin('product', 'sale_item.item_name', '=', 'product.id')
                ->select('sale_item.*', 'product.product_name');
        }])
            ->join('customers', 'sale.customer_id', '=', 'customers.id')
            ->where('sale.id', $id)
            ->select('sale.*', 'customers.customer_name as customer_name')
            ->firstOrFail();

        if (!$sale) {
            return redirect()->back()->with('error', 'Sale not found.');
        }

        return view('AdminDashboard.Pages.Sales.Invoices.invoice', compact('sale'));
    }


    public function sendInvoicePdf(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'sale_id' => 'required|integer|exists:sale,id',
        ]);

        $sale = Sales::with(['items' => function ($query) {
            $query->leftJoin('product', 'sale_item.item_name', '=', 'product.id')
                ->select('sale_item.*', 'product.product_name');
        }])
            ->join('customers', 'sale.customer_id', '=', 'customers.id')
            ->where('sale.id', $request->sale_id)
            ->select('sale.*', 'customers.customer_name as customer_name')
            ->firstOrFail();

        $pdf = Pdf::loadView('AdminDashboard.Pages.Sales.Emails.PDF', compact('sale'));

        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'Avenir',
        ]);

        $pdf->setPaper('A4', 'portrait');

        $fileName = 'invoice_' . $sale->id . '.pdf';
        $pdfPath = storage_path('app/public/invoices/' . $fileName);

        if (!file_exists(dirname($pdfPath))) {
            mkdir(dirname($pdfPath), 0755, true);
        }

        $pdf->save($pdfPath);

        Mail::send('AdminDashboard.Pages.Sales.Emails.Invoice', ['sale' => $sale], function ($message) use ($request, $pdfPath, $fileName) {
            $message->to($request->email)
                ->subject('Your Invoice')
                ->attach($pdfPath, [
                    'as' => $fileName,
                    'mime' => 'application/pdf',
                ]);
        });

        unlink($pdfPath);

        return response()->json(['success' => 'Invoice email has been sent with the PDF attachment.']);
    }
}
