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
                    <form class="box bg-white" method="POST" id="editAdsForm" enctype="multipart/form-data" action="{{ route('admin.update_setting') }}">
                    @csrf
                        <div class="box-row flex-wrap">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>FB Link</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control chkAlphabets" name="fb_link" autocomplete="off" value="{{ $setting_details->fb_link }}" placeholder="FB Link">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Linkedin link</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control chkAlphabets" name="linkedin_link" autocomplete="off" value="{{ $setting_details->linkedin_link }}" placeholder="Linkedin Link">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Instagram link</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control chkAlphabets" name="instagram_link" autocomplete="off" value="{{ $setting_details->instagram_link }}" placeholder="Instagram Link">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Twitter link</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control chkAlphabets" name="twitter_link" autocomplete="off" value="{{ $setting_details->twitter_link }}" placeholder="Twitter Link">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Title</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control chkAlphabets" name="site_title" autocomplete="off" value="{{ $setting_details->site_title }}" placeholder="Title">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Description</label>
                                    <div class="input-group">
                                        <textarea class="form-control" name="site_description" placeholder="Description">{{ $setting_details->site_description }}</textarea>
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