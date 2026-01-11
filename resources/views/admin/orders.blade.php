@extends('admin.includes.main')
@push('title')
<title>Orders</title>
@endpush

@section('content')
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <div class="card p-4 mt-4">
                <div class="row">
                    <div class="col-xl-12 col-md-12">
                        <h4>Orders</h4>
                        <div class="mt-3">
                            <table id="datatablesSimple" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Order Id</th>
                                        <th>Customer Name</th>
                                        <th>Total</th>
                                        <th>Payment Status</th>
                                        <th>Order Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <th scope="row">{{ $order->order_number }}</th>
                                            <td>{{ $order->user->name ?? 'Guest' }}</td>
                                            <td>₹ {{ number_format($order->total, 2) }}</td>
                                            <td>
                                                @if($order->payment_status == 'Pending')
                                                    <span class="badge rounded-pill text-bg-warning">{{ $order->payment_status }}</span>
                                                @elseif($order->payment_status == 'Paid')
                                                    <span class="badge rounded-pill text-bg-success">{{ $order->payment_status }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($order->status == 'Pending')
                                                    <span class="badge rounded-pill text-bg-warning">{{ $order->status }}</span>
                                                @elseif($order->status == 'Delivered')
                                                    <span class="badge rounded-pill text-bg-success">{{ $order->status }}</span>
                                                @elseif($order->status == 'On the way')
                                                    <span class="badge rounded-pill text-bg-info">{{ $order->status }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="fa-regular fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if($orders->isEmpty())
                                        <tr>
                                            <td colspan="6" class="text-center">No orders found.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>      
        </div>
    </main>
</div>
@endsection
