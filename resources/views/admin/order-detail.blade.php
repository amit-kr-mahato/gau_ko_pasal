@extends('admin.includes.main')
@push('title')
<title>Order Details</title>
@endpush

@section('content')
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h4>Order Details: {{ $order->order_number }}</h4>
            <div class="card p-4 mt-3">
                <h5>Customer Info</h5>
                <p>Name: {{ $order->user->name ?? 'Guest' }}</p>
                <p>Email: {{ $order->user->email ?? 'N/A' }}</p>
                <p>Shipping Address: {{ $order->shipping_address }}</p>

                <h5 class="mt-3">Order Items</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product->name ?? 'Deleted Product' }}</td>
                            <td>₹ {{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>₹ {{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <h5 class="mt-3">Summary</h5>
                <p>Subtotal: ₹ {{ number_format($order->subtotal, 2) }}</p>
                <p>Total: ₹ {{ number_format($order->total, 2) }}</p>
                <p>Status: <span class="badge rounded-pill 
                    @if($order->status=='Pending') bg-warning 
                    @elseif($order->status=='Delivered') bg-success 
                    @elseif($order->status=='On the way') bg-info 
                    @endif">
                    {{ $order->status }}
                </span></p>
                <p>Payment Status: <span class="badge rounded-pill 
                    @if($order->payment_status=='Pending') bg-warning 
                    @elseif($order->payment_status=='Paid') bg-success 
                    @endif">
                    {{ $order->payment_status }}
                </span></p>
            </div>
        </div>
    </main>
</div>
@endsection
