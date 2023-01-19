@extends('layouts.admin')
@section('content')
        <div class="page-title col-sm-12">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h3 m-0">Add Category</h1>
                </div>
                <div class="col-md-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Category</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="row">
                <div class="col-lg-12 col-md-4 mb-4">
                    <form class="box bg-white" method="POST" enctype="multipart/form-data" id="addCategoryForm" action="{{ route('admin.store_category') }}">
                    @csrf
                        <div class="box-row flex-wrap">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Category Name</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control chkAlphabets" name="category_name" autocomplete="off" value="{{ old('category_name') }}" placeholder="Category Name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Parent Category</label>
                                    <div class="input-group">
                                        <select name="parent_id" class="form-control">
                                            <option hidden="" value="0">--Select--</option>
                                            @if(!$categories->isEmpty())
                                                @foreach($categories as $category)
                                                    <option
                                                    @if($category->id==old('parent_id'))
                                                        selected
                                                    @endif
                                                    value="{{ $category->id }}">{{ $category->category_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Image</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" name="image_name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 text-center">
                                <a href="{{ route('admin.list_category') }}" class="btn light">Cancel</a>
                                <button type="submit" class="btn light">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
@endsection
@push('current-page-js')
<script type="text/javascript">
$("#addCategoryForm").validate({
    rules: {
        category_name: {
            required: true,
        },
    },
    messages:{
        category_name:{
            required: 'Category Name is required.'
        },
    }
});
</script>
@endpush