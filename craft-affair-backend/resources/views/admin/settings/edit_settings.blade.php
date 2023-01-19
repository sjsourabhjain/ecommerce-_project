@extends('layouts.admin')
@section('content')
        <div class="page-title col-sm-12">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h3 m-0">Edit Settings</h1>
                </div>
                <div class="col-md-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Settings</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="row">
                <div class="col-lg-12 col-md-4 mb-4">
                    <form class="box bg-white" method="POST" id="editAdsForm" enctype="multipart/form-data" action="{{ route('admin.update_settings') }}">
                    @csrf
                        <div class="box-row flex-wrap">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Promotion Line</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control chkAlphabets" name="promotion_line" autocomplete="off" value="{{ $setting_details->promotion_line }}" placeholder="Promotion Line">
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="col-md-12 mb-3 text-center">
                                <a type="submit" href="{{ route('admin.dashboard') }}" class="btn light">Cancel</a>
                                <button type="submit" class="btn light">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
@endsection
@push('current-page-js')
<script type="text/javascript">
$("#editAdsForm").validate({
    rules: {
        title: {
            required: true,
        },
        url: {
            required: true,
        },
    },
    messages:{
        title:{
            required: 'Title is required.'
        },
        url:{
            required: 'URL is required.'
        },
    }
});
</script>
@endpush