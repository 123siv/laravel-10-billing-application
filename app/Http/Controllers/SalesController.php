<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bill;

class SalesController extends Controller
{
    public function getTotalSales($category)
    {
        // Validate the category
        $validCategories = ['retail', 'wholesales', 'discount'];
        if (!in_array($category, $validCategories)) {
            return response()->json(['error' => 'Invalid category'], 400);
        }

        // Fetch data using Eloquent ORM
        $salesData = Bill::select('products.name', \DB::raw('SUM(bills.productQuantity) as totalQuantity'))
            ->join('products', 'bills.product_id', '=', 'products.id')
            ->where('bills.salesCategory', $category)
            ->groupBy('products.name')
            ->get();

        // Format the data for the chart
        $formattedData = $salesData->map(function($item) {
            return [
                'name' => $item->name,
                'totalQuantity' => $item->totalQuantity
            ];
        });

        return response()->json(['products' => $formattedData]);
    }
}
