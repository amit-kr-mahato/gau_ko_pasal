@extends('admin.includes.main')
@push('title')
<title>Add Category</title>
@endpush

@section('content')
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4 mt-4">
            <div class="card p-4">
                <h4>Add Category</h4>

                @if(session('success'))
                    <div class="alert alert-success mt-2">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger mt-2">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.category.store') }}" method="POST" class="mt-3">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Category Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Electronics" value="{{ old('name') }}">
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Commission (%)</label>
                            <input type="number" name="commission" class="form-control" placeholder="20" value="{{ old('commission') }}">
                        </div>

                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary">Add Category</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </main>
</div>
@endsection
