@extends('layouts.admin')
@section('content')
        <div class="page-title col-sm-12">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h3 m-0">Edit Variant</h1>
                </div>
                <div class="col-md-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Variant</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="row">
                <div class="col-lg-12 col-md-4 mb-4">
                    <form class="box bg-white" method="POST" id="editVariantForm" enctype="multipart/form-data" action="{{ route('admin.update_variant') }}">
                    @csrf
                    <input type="hidden" name="update_id" value="{{ $variant_details->id }}">
                        <div class="box-row flex-wrap">
                            <div class="col-md-12 mb-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control chkAlphabets" name="name" autocomplete="off" value="{{ $variant_details->name }}" placeholder="Name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 text-center">
                                <a type="submit" href="{{ route('admin.list_variant') }}" class="btn light">Cancel</a>
                                <button type="submit" class="btn light">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
@endsection
@push('current-page-js')
<script type="text/javascript">
$("#editVariantForm").validate({
    rules: {
        name: {
            required: true,
        },
    },
    messages:{
        name:{
            required: 'Name is required.'
        },
    }
});
</script>
@endpush