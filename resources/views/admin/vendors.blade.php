@extends('admin.includes.main')

@push('title')
<title>Vendors</title>
@endpush

@section('content')
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <div class="card p-4 mt-4">
                <h4>Vendors</h4>

                <div class="mt-3">
                    <table id="datatablesSimple" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Vendor Name</th>
                              
                                <th>Email</th>
                                <th>Status</th>
                                <th width="120">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vendors as $key => $vendor)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $vendor->name }}</td>
                                <td>{{ $vendor->email }}</td>

                                <td>
                                    @if($vendor->is_blocked)
                                        <span class="badge bg-danger">Inactive</span>
                                    @else
                                        <span class="badge bg-success">Active</span>
                                    @endif
                                </td>

                                <td>
                                    @if($vendor->is_blocked)
                                        <form method="POST"
                                              action="{{ route('admin.vendors.activate', $vendor->id) }}">
                                            @csrf
                                            <button class="btn btn-success btn-sm" title="Activate">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST"
                                              action="{{ route('admin.vendors.deactivate', $vendor->id) }}">
                                            @csrf
                                            <button class="btn btn-danger btn-sm" title="Deactivate">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach

                            @if($vendors->count() == 0)
                                <tr>
                                    <td colspan="6" class="text-center">No vendors found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </main>
</div>
@endsection
