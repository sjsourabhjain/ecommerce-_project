@extends('layouts.admin')
@section('content')
        <div class="page-title col-sm-12">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h3 m-0">Product Variant</h1>
                </div>
                <div class="col-md-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Product Variant</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="row">
                <div class="col-lg-12 col-md-4 mb-4">
                    <div class="box bg-white">
                    <form method="POST" enctype="multipart/form-data" id="addProductForm" action="{{ route('admin.store_product_variant') }}">
                    @csrf
                        <input type="hidden" name="product_id" value="{{ request()->id }}">
                        <div class="box-row flex-wrap">
                            @if(!$product_variants->isEmpty())
                                @foreach($product_variants as $variant)
                                    <div class="col-md-3 mb-3">
                                        <div class="form-group">
                                            <label>{{ $variant->variantDetails->name }}</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control chkAlphabets" name="variants[{{ $variant->variant_id }}]" autocomplete="off" value="{{ old('product_name') }}" placeholder="{{ $variant->variantDetails->name }}">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label>Price</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control chkAlphabets" name="price" autocomplete="off" value="{{ old('price') }}" placeholder="Price">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <div class="input-group">
                                            <textarea class="form-control" id="content" name="description" placeholder="Description"></textarea>
                                        </div>
                                    </div>
                                </div>
                            @endif
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
                                        <th scope="col">Variants</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Is Primary</th>
                                        <th scope="col" class="action">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($combinations))
                                        @foreach($combinations as $combination)
                                            <tr>
                                                <td scope="row">{{ $loop->iteration }}</td>
                                                <td><ul>
                                                    @foreach($combination->combinationDetails as $detail)
                                                        <li>{{ $detail->variantDetails->name }} - {{ $detail->variant_value }}</li>
                                                    @endforeach
                                                </ul></td>
                                                <td>{{ $combination->price }}</td>
                                                <td>{{ $combination->description }}</td>
                                                <td><input name="primary_variant" onclick="setPrimaryVariant('{{ $combination->id }}','{{ request()->id }}')" checked ="{{ $combination->is_primary==1 ? 'checked ' : '' }}" type="radio"/></td>
                                                <td class="action">
                                                    <a href="{{ route('admin.manage_product_variant_images',['comb_id'=>$combination->id,'product_id'=>$combination->product_id]) }}">
                                                        <button type="button" class="icon-btn edit">
                                                            <i class="fal fa-edit"></i>
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
<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
<script type="text/javascript">
document.querySelector('#content');
function setPrimaryVariant(combinationId,productId){
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url : "{{ route('admin.update_product_primay_variant') }}",
        data : { 'pvc_id' : combinationId, 'product_id' : productId },
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