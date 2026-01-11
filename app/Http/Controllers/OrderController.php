<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    // Show all orders
    public function index()
    {
        $orders = Order::with('user')->orderBy('id', 'desc')->get();
        return view('admin.orders', compact('orders'));
    }

    // Show order details
    public function show($id)
    {
        $order = Order::with('user', 'items.product')->findOrFail($id);
        return view('admin.order-detail', compact('order'));
    }
}
