@extends('admin.includes.main')

@push('title')
<title>Products</title>
@endpush


@section('content')
<div id="layoutSidenav_content">
    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Products</h2>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Product
            </a>
        </div>

        @if($products->isEmpty())
        <div class="alert alert-info text-center">No products found.</div>
        @else
        <div class="card shadow-sm">
            <div class="card-body p-3">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th class="py-2 px-4 border-b text-left">Description</th>
                                <th>Price (Rs)</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if($product->image)
                                    <img src="{{ asset('uploads/products/'.$product->image) }}" class="img-thumbnail"
                                        style="width:60px;height:60px;" alt="">
                                    @else
                                    N/A
                                    @endif
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name ?? 'N/A' }}</td>


                                <td class="py-2 px-4 border-b">{{ Str::limit($product->description, 50) }}</td>
                                <td>${{ $product->price }}</td>
                                <td>
                                    <a href="{{ route('admin.products.edit', $product->id) }}"
                                        class="btn btn-sm btn-info">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <!-- Delete Button -->
                                    <button type="button" class="btn btn-sm btn-danger"
                                        onclick="confirmDelete({{ $product->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    <!-- Hidden Delete Form -->
                                    <form id="delete-form-{{ $product->id }}"
                                        action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                        style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>


                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(productId) {
    // Use Bootstrap's modal if needed, or simple confirm
    if (confirm('Are you sure you want to delete this product?')) {
        const form = document.getElementById('delete-form-' + productId);
        if(form) {
            form.submit(); // Submit the hidden form
        } else {
            console.error('Delete form not found for product ID:', productId);
        }
    }
}
</script>
@endpush
