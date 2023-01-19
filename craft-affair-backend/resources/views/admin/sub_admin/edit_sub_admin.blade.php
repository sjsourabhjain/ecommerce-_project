@extends('layouts.admin')
@section('content')
        <div class="page-title col-sm-12">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h3 m-0">Edit Sub Admin</h1>
                </div>
                <div class="col-md-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Sub Admin</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="row">
                <div class="col-lg-12 col-md-4 mb-4">
                    <form class="box bg-white" method="POST" id="editSubAdminForm" action="{{ route('admin.update_sub_admin') }}">
                    @csrf
                    <input type="hidden" name="update_id" value="{{ $user_details->id }}">
                        <div class="box-row flex-wrap">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Full Name</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control chkAlphabets" name="full_name" autocomplete="off" value="{{ $user_details->full_name }}" placeholder="Full Name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Permissions</label>
                                    <div class="input-group">
                                        <select class="selectpicker form-control" name="permissions[]" multiple>
                                            @if(!$permissions->isEmpty())
                                                @foreach($permissions as $permission)
                                                    <option value="{{ $permission->id }}"
                                                        @if(in_array($permission->name,$user_permissions))
                                                            selected
                                                        @endif
                                                        >{{ ucwords(str_replace("_"," ",$permission->name)) }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Email</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="email" value="{{ $user_details->email }}" placeholder="Email">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Mobile Number</label>
                                    <div class="input-group">
                                        <input type="number" min="0" minlength="4" maxlength="12" class="form-control chkNumber" id="mob_no" name="mob_no" autocomplete="off" value="{{ $user_details->mob_no }}" placeholder="Mobile Number">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" name="password" placeholder="Password">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 text-center">
                                <a type="submit" href="{{ route('admin.list_sub_admin') }}" class="btn light">Cancel</a>
                                <button type="submit" class="btn light">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
@endsection
@push('current-page-js')
<script type="text/javascript">
$("#editSubAdminForm").validate({
    rules: {
        full_name: {
            required: true,
            minlength: 6
        },
        email: {
            email: true
        },
        mob_no: {
            required: true,
            digits: true,
            minlength:8,
            maxlength:12
        }
    }
});
</script>
@endpush