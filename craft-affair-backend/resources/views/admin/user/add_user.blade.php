@extends('layouts.admin')
@section('content')
        <div class="page-title col-sm-12">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h3 m-0">Add User</h1>
                </div>
                <div class="col-md-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add User</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="row">
                <div class="col-lg-12 col-md-4 mb-4">
                    <form class="box bg-white" method="POST" id="addUserForm" action="{{ route('admin.store_user') }}">
                    @csrf
                        <div class="box-row flex-wrap">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Name</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control chkAlphabets" name="full_name" autocomplete="off" value="{{ old('full_name') }}" placeholder="Name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Email</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Mobile Number</label>
                                    <div class="input-group">
                                        <input type="number" min="0" minlength="8" maxlength="12" class="form-control chkNumber" id="mob_no" name="mob_no" autocomplete="off" value="{{ old('mob_no') }}" placeholder="Mobile Number">
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
                                <a href="{{ route('admin.list_user') }}" class="btn light">Cancel</a>
                                <button type="submit" class="btn">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
@endsection
@push('current-page-js')
<script type="text/javascript">
$("#addUserForm").validate({
    rules: {
        full_name: {
            required: true,
        },
        email: {
            email: true
        },
        mob_no: {
            required: true,
            digits: true
        },
        password: {
            required: true,
            minlength:3,
            maxlength:8
        }
    },
    messages:{
        full_name:{
            required: 'Name is required.'
        },
        email:{
            email: 'Please enter a valid email.'
        },
        mob_no:{
            required: 'Mobile No. is required.'
        },
        password:{
            required: 'Password is required',
        }
    }
});
</script>
@endpush