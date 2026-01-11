<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vendor;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;         // For admin profile
use App\Models\StoreSetting;  // For store, notifications, SEO settings
use Auth;

class AdminController extends Controller
{
    // Admin Dashboard
    public function index()
    {
        return view('admin.index');
    }

    // Users List
    public function users()
    {
        $users = User::latest()->get();
        return view('admin.users', compact('users'));
    }

    // Vendors List
    public function vendors()
    {
        $vendors = Vendor::latest()->get();
        return view('admin.vendors', compact('vendors'));
    }

    // Orders List
    public function orders()
    {
        $orders = Order::with('user')->latest()->get();
        return view('admin.orders', compact('orders'));
    }

    // Order Detail
    public function orderdetail($id)
    {
        $order = Order::with(['items.product', 'user'])->findOrFail($id);
        return view('admin.order-detail', compact('order'));
    }

    // Create Order (example for saving order with commission)
    public function storeOrder(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {

            $subtotal = 0;
            $commissionPercent = 10; // example: 10%
            
            // Calculate subtotal
            foreach ($request->products as $item) {
                $product = Product::findOrFail($item['product_id']);
                $subtotal += $product->price * $item['quantity'];
            }

            $commission = ($subtotal * $commissionPercent) / 100;
            $total = $subtotal + $commission;

            // Save Order
            $order = Order::create([
                'user_id' => $request->user_id,
                'order_number' => 'ORD-'.Str::upper(Str::random(6)),
                'payment_method' => $request->payment_method ?? 'Cash on Delivery',
                'payment_status' => 'pending',
                'subtotal' => $subtotal,
                'total' => $total,
                'status' => 'pending',
                'shipping_address' => $request->shipping_address ?? 'N/A',
            ]);

            // Save Order Items
            foreach ($request->products as $item) {
                $product = Product::findOrFail($item['product_id']);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'price' => $product->price,
                    'quantity' => $item['quantity'],
                    'subtotal' => $product->price * $item['quantity'],
                    'status' => 'pending',
                ]);
            }

        });

        return redirect()->back()->with('success', 'Order saved successfully!');
    }

    // ------------------- CATEGORY MANAGEMENT -------------------
    public function addcategory()
    {
        return view('admin.add-category');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name',
            'commission' => 'required|numeric|min:0',
        ]);

        Category::create([
            'name' => $request->name,
            'commission' => $request->commission,
        ]);

        return redirect()->route('admin.viewcategory')->with('success', 'Category added successfully!');
    }

    public function viewcategory()
    {
        $categories = Category::all();
        return view('admin.view-category', compact('categories'));
    }

    public function editcategory($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.edit-category', compact('category'));
    }

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

    public function deletecategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.viewcategory')->with('success', 'Category deleted successfully!');
    }

    public function settings()
{
    $admin = auth()->user();
    $store = StoreSetting::first(); // Assuming you have a StoreSetting model
    return view('admin.settings', compact('admin', 'store'));
}

// Profile
public function updateProfile(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,'.auth()->id(),
        'profile_image' => 'nullable|image|max:2048',
    ]);

    $admin = auth()->user();
    $admin->name = $request->name;
    $admin->email = $request->email;

    if($request->hasFile('profile_image')){
        $file = $request->file('profile_image');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('uploads/admin'), $filename);
        $admin->profile_image = $filename;
    }

    $admin->save();

    return back()->with('success', 'Profile updated successfully!');
}

// Password
public function changePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'password' => 'required|confirmed|min:6',
    ]);

    $admin = auth()->user();

    if(!\Hash::check($request->current_password, $admin->password)){
        return back()->withErrors(['current_password'=>'Current password is incorrect']);
    }

    $admin->password = \Hash::make($request->password);
    $admin->save();

    return back()->with('success', 'Password changed successfully!');
}

// Store settings
public function updateStore(Request $request)
{
    $request->validate([
        'store_name'=>'required|string|max:255',
        'logo'=>'nullable|image|max:2048',
        'favicon'=>'nullable|image|max:1024',
        'contact_email'=>'required|email',
        'contact_phone'=>'required|string',
        'currency'=>'required|string',
        'timezone'=>'required|string',
    ]);

    $store = StoreSetting::firstOrNew();
    $store->store_name = $request->store_name;
    $store->contact_email = $request->contact_email;
    $store->contact_phone = $request->contact_phone;
    $store->currency = $request->currency;
    $store->timezone = $request->timezone;

    if($request->hasFile('logo')){
        $file = $request->file('logo');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('uploads/store'), $filename);
        $store->logo = $filename;
    }
    if($request->hasFile('favicon')){
        $file = $request->file('favicon');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('uploads/store'), $filename);
        $store->favicon = $filename;
    }

    $store->save();
    return back()->with('success','Store settings updated successfully!');
}

// Notifications
public function updateNotifications(Request $request)
{
    $store = StoreSetting::firstOrNew();
    $store->notify_new_order = $request->has('notify_new_order');
    $store->notify_user_registration = $request->has('notify_user_registration');
    $store->notify_stock_alert = $request->has('notify_stock_alert');
    $store->save();
    return back()->with('success','Notification settings updated!');
}

// SEO & Social
public function updateSeo(Request $request)
{
    $store = StoreSetting::firstOrNew();
    $store->meta_title = $request->meta_title;
    $store->meta_description = $request->meta_description;
    $store->facebook_url = $request->facebook_url;
    $store->twitter_url = $request->twitter_url;
    $store->instagram_url = $request->instagram_url;
    $store->maintenance_mode = $request->has('maintenance_mode');
    $store->save();

    return back()->with('success','SEO & social settings updated!');
}


}
