@extends('admin.includes.main')

@push('title')
<title>Admin Settings</title>
@endpush

@section('content')
<div id="layoutSidenav_content">
<div class="container mt-4">
    <h2>Admin Settings</h2>
    <hr>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <!-- Profile -->
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">Admin Profile</div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.profile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $admin->name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $admin->email) }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Profile Picture</label>
                            <input type="file" name="profile_image" class="form-control" onchange="previewProfile(event)">
                            @if($admin->profile_image)
                                <img src="{{ asset('uploads/admin/'.$admin->profile_image) }}" id="profilePreview" class="mt-2 rounded-circle" width="100" height="100">
                            @else
                                <img id="profilePreview" style="display:none;" class="mt-2 rounded-circle" width="100" height="100">
                            @endif
                        </div>
                        <button class="btn btn-primary">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Change Password -->
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">Change Password</div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.password') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>Current Password</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>New Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <button class="btn btn-warning">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Store Settings -->
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-info text-white">Store Settings</div>
        <div class="card-body">
            <form action="{{ route('admin.settings.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Store Name</label>
                        <input type="text" name="store_name" class="form-control" value="{{ old('store_name', $store->store_name ?? '') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Contact Email</label>
                        <input type="email" name="contact_email" class="form-control" value="{{ old('contact_email', $store->contact_email ?? '') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Contact Phone</label>
                        <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone', $store->contact_phone ?? '') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Currency</label>
                        <input type="text" name="currency" class="form-control" value="{{ old('currency', $store->currency ?? 'USD') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Timezone</label>
                        <select name="timezone" class="form-control" required>
                            @foreach(timezone_identifiers_list() as $tz)
                                <option value="{{ $tz }}" {{ ($store->timezone ?? '') == $tz ? 'selected' : '' }}>{{ $tz }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Logo</label>
                        <input type="file" name="logo" class="form-control" onchange="previewLogo(event)">
                        @if(!empty($store->logo))
                            <img src="{{ asset('uploads/store/'.$store->logo) }}" id="logoPreview" class="mt-2" width="100">
                        @else
                            <img id="logoPreview" style="display:none;" class="mt-2" width="100">
                        @endif
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Favicon</label>
                        <input type="file" name="favicon" class="form-control" onchange="previewFavicon(event)">
                        @if(!empty($store->favicon))
                            <img src="{{ asset('uploads/store/'.$store->favicon) }}" id="faviconPreview" class="mt-2" width="50">
                        @else
                            <img id="faviconPreview" style="display:none;" class="mt-2" width="50">
                        @endif
                    </div>
                </div>
                <button class="btn btn-info">Update Store Settings</button>
            </form>
        </div>
    </div>

    <!-- Notifications -->
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-secondary text-white">Notification Settings</div>
        <div class="card-body">
            <form action="{{ route('admin.settings.notifications') }}" method="POST">
                @csrf
                <div class="form-check mb-2">
                    <input type="checkbox" class="form-check-input" id="notify_new_order" name="notify_new_order" {{ ($store->notify_new_order ?? 0) ? 'checked' : '' }}>
                    <label class="form-check-label" for="notify_new_order">Notify for New Orders</label>
                </div>
                <div class="form-check mb-2">
                    <input type="checkbox" class="form-check-input" id="notify_user_registration" name="notify_user_registration" {{ ($store->notify_user_registration ?? 0) ? 'checked' : '' }}>
                    <label class="form-check-label" for="notify_user_registration">Notify for User Registration</label>
                </div>
                <div class="form-check mb-2">
                    <input type="checkbox" class="form-check-input" id="notify_stock_alert" name="notify_stock_alert" {{ ($store->notify_stock_alert ?? 0) ? 'checked' : '' }}>
                    <label class="form-check-label" for="notify_stock_alert">Notify for Stock Alerts</label>
                </div>
                <button class="btn btn-secondary">Update Notifications</button>
            </form>
        </div>
    </div>

    <!-- SEO & Social -->
    <div class="card shadow-sm mt-4 mb-5">
        <div class="card-header bg-dark text-white">SEO & Social Links</div>
        <div class="card-body">
            <form action="{{ route('admin.settings.seo') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Meta Title</label>
                        <input type="text" class="form-control" name="meta_title" value="{{ $store->meta_title ?? '' }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Meta Description</label>
                        <input type="text" class="form-control" name="meta_description" value="{{ $store->meta_description ?? '' }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Facebook URL</label>
                        <input type="text" class="form-control" name="facebook_url" value="{{ $store->facebook_url ?? '' }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Twitter URL</label>
                        <input type="text" class="form-control" name="twitter_url" value="{{ $store->twitter_url ?? '' }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Instagram URL</label>
                        <input type="text" class="form-control" name="instagram_url" value="{{ $store->instagram_url ?? '' }}">
                    </div>
                    <div class="form-check mb-2">
                        <input type="checkbox" class="form-check-input" id="maintenance_mode" name="maintenance_mode" {{ ($store->maintenance_mode ?? 0) ? 'checked' : '' }}>
                        <label class="form-check-label" for="maintenance_mode">Enable Maintenance Mode</label>
                    </div>
                    <button class="btn btn-dark">Update SEO & Social</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
<script>
    function previewProfile(event){
        const img = document.getElementById('profilePreview');
        img.src = URL.createObjectURL(event.target.files[0]);
        img.style.display = 'block';
    }
    function previewLogo(event){
        const img = document.getElementById('logoPreview');
        img.src = URL.createObjectURL(event.target.files[0]);
        img.style.display = 'block';
    }
    function previewFavicon(event){
        const img = document.getElementById('faviconPreview');
        img.src = URL.createObjectURL(event.target.files[0]);
        img.style.display = 'block';
    }
</script>
@endpush
