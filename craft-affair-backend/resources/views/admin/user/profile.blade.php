@extends('layouts.admin')
@section('content')
        <div class="page-title col-sm-12">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h3 m-0">Profile</h1>
                </div>
                <div class="col-md-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Profile</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="row">
                <div class="col-lg-12 col-md-4 mb-4">
                    <div class="box bg-white">
                        <div class="box-title pb-0">
                            <h5>Profile Details</h5>
                        </div>
                        <div class="box-row flex-wrap user-contact">
                            <div class="d-flex">
                                <label>Name</label>
                                <span class="text-muted">{{ $user_details->full_name }}</span>
                            </div>
                            <div class="d-flex">
                                <label>Email</label>
                                <span class="text-muted">{{ $user_details->email }}</span>
                            </div>
                            <!-- <div class="d-flex">
                                <label>Mobile No.</label>
                                <span class="text-muted">{{ $user_details->mob_no }}</span>
                            </div>
                            <div class="d-flex">
                                <label>DOB</label>
                                <span class="text-muted">{{ $user_details->dob }}</span>
                            </div>
                            <div class="d-flex">
                                <label>Gender</label>
                                <span class="text-muted">{{ ucwords($user_details->gender) }}</span>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection