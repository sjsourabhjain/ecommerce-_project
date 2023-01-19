@extends('layouts.admin')
@section('content')
        <div class="page-title col-sm-12">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h3 m-0">Add CMS</h1>
                </div>
                <div class="col-md-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add CMS</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="row">
                <div class="col-lg-12 col-md-4 mb-4">
                    <form class="box bg-white" method="POST" enctype="multipart/form-data" id="addAdsForm" action="{{ route('admin.store_cms') }}">
                    @csrf
                        <div class="box-row flex-wrap">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Title</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control chkAlphabets" name="title" autocomplete="off" value="{{ old('title') }}" placeholder="Title">
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-sm-6">
                                <div class="form-group">
                                <label>Image</label>
                                    <div class="">
                                        <input id="ad_image" type="file" name="ad_image">
                                    </div>
                                </div>
                            </div> -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Content</label>
                                    <div class="">
                                        <textarea class="form-control" id="content" placeholder="Enter the Description" name="content"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 text-center">
                                <a href="{{ route('admin.list_ads') }}" class="btn light">Cancel</a>
                                <button type="submit" class="btn light">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
@endsection
@push('current-page-js')
<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
<script type="text/javascript">
    .create( document.querySelector( '#content' ) )
.catch( error => {
console.error( error );
} );
$("#addAdsForm").validate({
    rules: {
        title: {
            required: true,
        },
    },
    messages:{
        title:{
            required: 'Title is required.'
        },
    }
});
</script>
@endpush