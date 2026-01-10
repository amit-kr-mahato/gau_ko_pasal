@extends('admin.includes.main')
@push('title')
<title>Edit Category</title>
@endpush

@section('content')
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4 mt-4">
            <div class="card p-4">
                <h4>Edit Category</h4>

                @if ($errors->any())
                    <div class="alert alert-danger mt-2">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.category.update', $category->id) }}" method="POST" class="mt-3">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Category Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}">
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Commission (%)</label>
                            <input type="number" name="commission" class="form-control" value="{{ old('commission', $category->commission) }}">
                        </div>

                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-success">Update Category</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </main>
</div>
@endsection
