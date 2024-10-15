<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProductReportController extends Controller
{
    public function index()
    {
        return view('AdminDashboard.Pages.Products-Report.Product-Report');
    }

    public function fetch() {
        $productsReport = DB::table('product')
            ->join(DB::raw('(SELECT item_name, SUM(quantity) as total_purchase_quantity, SUM(total) as total_purchase_total, MAX(cost) as purchase_cost FROM purchase_item GROUP BY item_name) as purchase_item'), 'product.id', '=', 'purchase_item.item_name')
            ->join(DB::raw('(SELECT item_name, SUM(quantity) as total_sale_quantity, SUM(total) as total_sale_total, MAX(price) as sale_price FROM sale_item GROUP BY item_name) as sale_item'), 'product.id', '=', 'sale_item.item_name')
            ->select(
                'product.id as product_id',
                'product.product_name',
                'product.product_sku',
                'sale_item.sale_price',
                'purchase_item.purchase_cost',
                'purchase_item.total_purchase_quantity',
                'purchase_item.total_purchase_total',
                'sale_item.total_sale_quantity',
                'sale_item.total_sale_total'
            )
            ->get();

        return response([
            'productsReport' => $productsReport,
        ]);
    }


}
