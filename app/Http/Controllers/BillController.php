<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BillController extends Controller
{
    //to fetch all bill data to show total sales and details of a month and year
    public function getSalesData()
    {
        // Get the current month and year
        $currentMonth = now()->month;
        $currentYear = now()->year;
        // Query to fetch the bill data for the current month
        $bills = Bill::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->get();
        // Calculate the quantity sold and total amount of sales
        $quantitySold = $bills->sum('productQuantity');
        $totalAmount = 0;
        $totalProfit = 0;
        // Calculate total sales amount for each bill
        foreach ($bills as $bill) {
            $totalAmount += $bill->productQuantity * $bill->productMrp;
            $quantity = $bill->productQuantity;
            $cost = $bill->product?->cost ?? 0;
            $mrp = $bill->productMrp;
            $totalProfit += ($quantity * $mrp) - ($quantity * $cost);
        }
        // Prepare the response data
        $data = [
            'quantitySold' => $quantitySold,
            'totalSalesAmount' => $totalAmount,
            'totalProfit' => $totalProfit
        ];
        // Return the response as JSON
        return response()->json($data);
    }

    public function getAllSales(Request $request)
    {
        $query = Bill::with('product')->orderBy('created_at', 'desc');
        // Search query
        if ($request->has('query') && $request->query('query') !== '') {
            $search = $request->query('query');
            $query->where(function ($q) use ($search) {
                $q->whereHas('product', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                })
                    ->orWhere('billNo', 'LIKE', "%{$search}%")
                    ->orWhere('salesCategory', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }
        // Date filtering
        if ($request->has('fromDate') && $request->has('toDate')) {
            $fromDate = Carbon::parse($request->query('fromDate'))->startOfDay();
            $toDate = Carbon::parse($request->query('toDate'))->endOfDay();
            $query->whereBetween('created_at', [$fromDate, $toDate]);
        } elseif ($request->has('fromDate') || $request->has('toDate')) {
            // Handle incomplete date range
            return response()->json([
                'error' => 'Both fromDate and toDate are required for date filtering.'
            ], 400);
        }
        // Retrieve bills
        $bills = $query->get();
        // Calculate total quantity and amount
        $totalQuantity = $bills->sum('productQuantity');
        $totalAmount = $bills->sum(function ($bill) {
            return $bill->productQuantity * $bill->productMrp;
        });
        // Return JSON response
        return response()->json([
            'bills' => $bills,
            'totalQuantity' => $totalQuantity,
            'totalAmount' => $totalAmount
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function getProductName(Request $request)
    {
        $product_id = $request->input('product_id');
        $product = Product::find($product_id);
        if ($product) {
            return response()->json(['product_id' => $product->code]);
        } else {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getProductSalesCategories($productId)
    {
        $discountSales = Bill::where('product_id', $productId)
            ->where('salesCategory', 'discount')
            ->get();
        $retailSales = Bill::where('product_id', $productId)
            ->where('salesCategory', 'retail')
            ->get();
        $wholesaleSales = Bill::where('product_id', $productId)
            ->where('salesCategory', 'wholesales')
            ->get();
        return response()->json([
            'discountSales' => $discountSales,
            'retailSales' => $retailSales,
            'wholesaleSales' => $wholesaleSales
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'billNumber' => 'required|numeric|min:3',
            'productName' => 'required|string|max:255',
            'productMrp' => 'required|numeric',
            'productQuantity' => 'required|numeric',
            'productCat' => 'required|string|in:wholesales,retail,discount',
        ]);
        $bill = new Bill();
        $bill->billNo = $validatedData['billNumber'];
        $bill->phone = $request['customerPhone'];
        $bill->product_id = $validatedData['productName']; //in this peoductName it actually passing the id value of the product
        $bill->productMrp = $validatedData['productMrp'];
        $bill->productQuantity = $validatedData['productQuantity'];
        $bill->salesCategory = $validatedData['productCat'];
        // Save the product to the database
        $bill->save();
        return redirect()->back()->with('success', 'Bill added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function getBillDetails($id)
    {
        $bill = Bill::with('product')->find($id);
        if (!$bill) {
            return response()->json(['error' => 'Bill not found'], 404);
        }
        return response()->json(['bill' => $bill]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bill $bill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bill $bill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bill $bill)
    {
        //
    }
}
