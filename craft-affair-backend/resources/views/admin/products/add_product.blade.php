@extends('layouts.admin')
@section('content')
        <div class="page-title col-sm-12">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h3 m-0">Add Product</h1>
                </div>
                <div class="col-md-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Product</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="row">
                <div class="col-lg-12 col-md-4 mb-4">
                    <form class="box bg-white" method="POST" enctype="multipart/form-data" id="addProductForm" action="{{ route('admin.store_product') }}">
                    @csrf
                        <div class="box-row flex-wrap">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Name</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control chkAlphabets" name="product_name" autocomplete="off" value="{{ old('product_name') }}" placeholder="Product Name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Variants</label>
                                    <div class="input-group">
                                        <select class="selectpicker form-control" name="variants[]" multiple>
                                            @if(!$variants->isEmpty())
                                                @foreach($variants as $variant)
                                                    <option value="{{ $variant->id }}">{{ $variant->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>SKU ID</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control chkAlphabets" name="product_sku_id" autocomplete="off" value="{{ old('product_sku_id') }}" placeholder="Product SKU ID">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Category</label>
                                    <div class="input-group">
                                        <select name="category_id" class="form-control">
                                            <option hidden="" value="">--Select--</option>
                                            @if(!$categories->isEmpty())
                                                @foreach($categories as $category)
                                                    <option
                                                    @if($category->id==old('category_id'))
                                                        selected
                                                    @endif
                                                    value="{{ $category->id }}">{{ $category->category_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 text-center">
                                <a href="{{ route('admin.list_product') }}" class="btn light">Cancel</a>
                                <button type="submit" class="btn light">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
@endsection
@push('current-page-js')
<script type="text/javascript">
$("#addProductForm").validate({
    rules: {
        product_name: {
            required: true,
        },
        price: {
            required: true,
        },
        description: {
            required: true,
        },
    },
    messages:{
        product_name:{
            required: 'Product Name is required.'
        },
        price:{
            required: 'Price is required.'
        },
        description:{
            required: 'Description is required.'
        },
    }
});
</script>
@endpush