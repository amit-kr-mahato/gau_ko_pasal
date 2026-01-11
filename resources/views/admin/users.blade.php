@extends('admin.includes.main')

@push('title')
<title>Users</title>
@endpush

@section('content')
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <div class="card p-4 mt-4">
                <h4>Users</h4>

                <div class="mt-3">
                    <table id="datatablesSimple" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Customer Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th width="120">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $key => $user)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>

                                <td>
                                    @if($user->is_blocked)
                                        <span class="badge bg-danger">Blocked</span>
                                    @else
                                        <span class="badge bg-success">Active</span>
                                    @endif
                                </td>

                                <td>
                                    @if($user->is_blocked)
                                        <form method="POST" action="{{ route('admin.users.unblock', $user->id) }}">
                                            @csrf
                                            <button class="btn btn-success btn-sm" title="Unblock">
                                                <i class="fa-solid fa-shield"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.users.block', $user->id) }}">
                                            @csrf
                                            <button class="btn btn-danger btn-sm" title="Block">
                                                <i class="fa-solid fa-ban"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach

                            @if($users->count() == 0)
                                <tr>
                                    <td colspan="5" class="text-center">No users found</td>
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
