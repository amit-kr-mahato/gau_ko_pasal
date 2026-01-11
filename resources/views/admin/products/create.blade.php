@extends('admin.includes.main')

@push('title')
<title>Add Product</title>
@endpush

@section('content')
<div id="layoutSidenav_content">
    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Add Product</h2>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Products
            </a>
        </div>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">

                        <!-- Product Name -->
                        <div class="col-md-6">
                            <label for="name" class="form-label">Product Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>

                        <!-- Product Price -->
                        <div class="col-md-6">
                            <label for="price" class="form-label">Price ($)</label>
                            <input type="number" name="price" class="form-control" step="0.01"
                                value="{{ old('price') }}" required>
                        </div>

                        <!-- Product Description -->
                        <div class="col-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control"
                                rows="4">{{ old('description') }}</textarea>
                        </div>
                        <!-- Category -->
                        <div class="col-md-6">
                            <label for="category_id" class="form-label">Category</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id')==$category->id ? 'selected' :
                                    '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Product Image -->
                        <div class="col-md-6">
                            <label for="image" class="form-label">Product Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*"
                                onchange="previewImage(event)">
                            <img id="imagePreview" src="#" alt="Image Preview" class="img-thumbnail mt-2"
                                style="display:none; max-width:150px;">
                        </div>

                    </div>

                    <!-- Buttons -->
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-plus"></i> Add Product
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImage(event){
    const preview = document.getElementById('imagePreview');
    const file = event.target.files[0];
    if(file){
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    } else {
        preview.src = '#';
        preview.style.display = 'none';
    }
}
</script>
@endpush