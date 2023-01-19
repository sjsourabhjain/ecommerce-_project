@extends('layouts.admin')
@section('content')
        <div class="page-title col-sm-12">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h3 m-0">Product Variant Images</h1>
                </div>
                <div class="col-md-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Product Variant Images</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="row">
                <div class="col-lg-12 col-md-4 mb-4">
                    <div class="box bg-white">
                    <form method="POST" enctype="multipart/form-data" id="addProductForm" action="{{ route('admin.store_product_variant_images') }}">
                    @csrf
                        <input type="hidden" name="comb_id" value="{{ request()->comb_id }}">
                        <input type="hidden" name="product_id" value="{{ request()->product_id }}">
                        <div class="box-row flex-wrap">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Image</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" name="product_variant_image">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 text-center">
                                <a href="{{ route('admin.list_product') }}" class="btn light">Cancel</a>
                                <button type="submit" class="btn light">Submit</button>
                            </div>
                        </div>
                    </form>
                        <div class="box-row">
                            <div class="box-content">
                                <table id="dataTable" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Image</th>
                                            <th scope="col">Is Primary</th>
                                            <th scope="col" class="action">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($images))
                                            @foreach($images as $image)
                                                <tr>
                                                    <th scope="row">{{ $loop->iteration }}</th>
                                                    <td><img height="100" width="100" src="{{ asset('uploads/'.$image->image_name) }}" loading="lazy"></td>
                                                    <td><input name="primary_image" onclick="setPrimaryImage('{{ $image->id }}','{{ $image->comb_id }}')" checked="{{ $image->is_primary==1 ? 'checked' : '' }}" type="radio"/></td>
                                                    <td class="action">
                                                        <a href="{{ route('admin.delete_product_variant_image',['id'=>$image->id,'product_id'=>request()->id]) }}">
                                                            <button type="button" class="icon-btn delete">
                                                                <i class="fal fa-trash"></i>
                                                            </button>
                                                        </a> 
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                </div>
                </div>
@endsection
@push('current-page-js')
<script type="text/javascript">
    function setPrimaryImage(id,combId){
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url : "{{ route('admin.update_product_variant_primay_image') }}",
            data : { 'id' : id, 'comb_id' : combId},
            type : 'POST',
            success : function(resp){
                alert(resp.message);
            },
            error: function(err){
                alert(err);
            }
        });
    }
</script>
@endpush