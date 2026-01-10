<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class AdminController extends Controller
{
    /**
     * Admin Login Page
     */
    public function login()
    {
        return view('admin.login'); // resources/views/admin/login.blade.php
    }

    /**
     * Admin Dashboard
     */
    public function index()
    {
        return view('admin.index'); // resources/views/admin/index.blade.php
    }

    /**
     * Category Pages
     */
    public function addcategory()
    {
        return view('admin.add-category');
    }

    // Store Category
    public function storeCategory(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required|unique:categories,name',
            'commission' => 'required|numeric|min:0',
        ]);

        // Save category
        Category::create([
            'name' => $request->name,
            'commission' => $request->commission,
        ]);

        // Redirect to view categories with success message
        return redirect()->route('admin.viewcategory')->with('success', 'Category added successfully!');
    }

    public function viewcategory()
    {
        $categories = Category::all();
        return view('admin.view-category', compact('categories'));
    }

    // Edit Category page
    public function editcategory($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.edit-category', compact('category'));
    }

    // Update category
    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,'.$id,
            'commission' => 'required|numeric|min:0',
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
            'commission' => $request->commission,
        ]);

        return redirect()->route('admin.viewcategory')->with('success', 'Category updated successfully!');
    }

    // Delete category
    public function deletecategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.viewcategory')->with('success', 'Category deleted successfully!');
    }

    /**
     * User & Vendor Management
     */
    public function users()
    {
        return view('admin.users');
    }

    public function vendors()
    {
        return view('admin.vendors');
    }

    /**
     * Orders
     */
    public function orders()
    {
        return view('admin.orders');
    }

    public function orderdetail()
    {
        return view('admin.order-detail');
    }

    // Optional: Products Page
    // public function products()
    // {
    //     return view('admin.products');
    // }
}
