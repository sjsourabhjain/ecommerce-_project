@extends('layouts.admin')
@section('content')
        <div class="page-title col-sm-12">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h3 m-0">Edit CMS</h1>
                </div>
                <div class="col-md-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit CMS</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="row">
                <div class="col-lg-12 col-md-4 mb-4">
                    <form class="box bg-white" method="POST" id="editAdsForm" enctype="multipart/form-data" action="{{ route('admin.update_cms') }}">
                    @csrf
                    <input type="hidden" name="update_id" value="{{ $ads_details->id }}">
                        <div class="box-row flex-wrap">
                            <div class="col-md-12 mb-6">
                                <div class="form-group">
                                    <label>Title</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control chkAlphabets" name="title" autocomplete="off" value="{{ $ads_details->title }}" placeholder="Title">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Content</label>
                                    <div class="">
                                        <textarea class="form-control" id="content" placeholder="Enter the Description" name="content">{{$ads_details->description}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 text-center">
                                <a type="submit" href="{{ route('admin.list_ads') }}" class="btn light">Cancel</a>
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
$("#editAdsForm").validate({
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