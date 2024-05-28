<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function store(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'catName' => 'required|string|max:255',
        ]);
        // Create a new category instance
        $category = new Category();
        $category->name = $validatedData['catName'];
        // Save the category to the database
        $category->save();
        // Optionally, you can return a response indicating success
        return response()->json(['message' => 'Category created successfully'], 200);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->save();
        return response()->json(['success' => 'Category updated successfully']);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json(['message' => 'Category deleted successfully']);
    }
}
