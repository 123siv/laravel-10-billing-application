<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Bill;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'productName' => 'required|string|max:255',
            'productId' => 'required|numeric',
            'productCost' => 'required|numeric',
            'productCategory' => 'required|string|max:255',
        ], [
            'productName.required' => 'Product name is required.',
            'productId.required' => 'Product ID is required.',
            'productId.numeric' => 'Product ID must be a number.',
            'productCost.required' => 'Product cost is required.',
            'productCost.numeric' => 'Product cost must be a number.',
            'productCategory.required' => 'Product category is required.',
        ]);
        // Create a new product instance
        $product = new Product();
        $product->name = $validatedData['productName'];
        $product->code = $validatedData['productId'];
        $product->cost = $validatedData['productCost'];
        $product->category_id = $validatedData['productCategory'];
        // Save the product to the database
        $product->save();
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Product created successfully!');
    }

    public function show($id)
    {
        $product = Product::with('category')->find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return response()->json(['product' => $product]);
    }

    public function showSingleproduct($id)
    {
        $product = Product::with('category')->findOrFail($id);
        $categories = Category::all(); // Fetch all categories
        return response()->json(['product' => $product, 'categories' => $categories]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->category_id = $request->category;
        $product->code = $request->code;
        $product->cost = $request->cost;
        $product->save();
        return response()->json(['success' => 'Product updated successfully']);
    }


    public function destroy($id)
    {
        // Find the product by its ID
        $product = Product::find($id);
        // Check if the product exists
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        try {
            // Delete the product
            $product->delete();
            return response()->json(['message' => 'Product deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while deleting the product'], 500);
        }
    }

    // Function to fetch sales categories
    public function getSalesCategories(Request $request, $productId)
    {
        $fromDate = $request->query('fromDate');
        $toDate = $request->query('toDate');
        // Initialize the base queries
        $discountSalesQuery = Bill::where('product_id', $productId)->where('salesCategory', 'discount');
        $retailSalesQuery = Bill::where('product_id', $productId)->where('salesCategory', 'retail');
        $wholesaleSalesQuery = Bill::where('product_id', $productId)->where('salesCategory', 'wholesales');
        // Apply date range filters if both fromDate and toDate are present
        if ($fromDate && $toDate) {
            $fromDate = Carbon::parse($fromDate)->startOfDay();
            $toDate = Carbon::parse($toDate)->endOfDay();
            $discountSalesQuery->whereBetween('created_at', [$fromDate, $toDate]);
            $retailSalesQuery->whereBetween('created_at', [$fromDate, $toDate]);
            $wholesaleSalesQuery->whereBetween('created_at', [$fromDate, $toDate]);
        } elseif ($fromDate || $toDate) {
            // Handle incomplete date range
            return response()->json([
                'error' => 'Both fromDate and toDate are required for date filtering.'
            ], 400);
        }
        // Execute the queries
        $discountSales = $discountSalesQuery->get();
        $retailSales = $retailSalesQuery->get();
        $wholesaleSales = $wholesaleSalesQuery->get();
        return response()->json([
            'discountSales' => $discountSales,
            'retailSales' => $retailSales,
            'wholesaleSales' => $wholesaleSales
        ], 200);
    }
}
