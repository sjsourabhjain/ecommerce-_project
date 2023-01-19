@extends('layouts.admin')
@section('content')
        <div class="page-title col-sm-12">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h3 m-0">Edit User</h1>
                </div>
                <div class="col-md-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit User</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="row">
                <div class="col-lg-12 col-md-4 mb-4">
                    <form class="box bg-white" method="POST" id="editUserForm" action="{{ route('admin.update_user') }}">
                    @csrf
                    <input type="hidden" name="update_id" value="{{ $user_details->id }}">
                        <div class="box-row flex-wrap">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Name</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control chkAlphabets" name="full_name" autocomplete="off" value="{{ $user_details->full_name }}" placeholder="Name">
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
                                    <div class="input-group"></div>
                                        <input type="number" min="0" minlength="8" maxlength="12" class="form-control chkNumber" id="mob_no" name="mob_no" autocomplete="off" value="{{ $user_details->mob_no }}">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 text-center">
                                <a type="submit" href="{{ route('admin.list_user') }}" class="btn light">Cancel</a>
                                <button type="submit" class="btn">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
@endsection
@push('current-page-js')
<script type="text/javascript">
$("#editUserForm").validate({
    rules: {
        full_name: {
            required: true,
        },
        email: {
            email: true
        },
        mob_no: {
            required: true,
            digits: true,
            minlength: 8,
            maxlength: 12
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
        }
    }
});
</script>
@endpush