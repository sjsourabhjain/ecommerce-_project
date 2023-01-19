@extends('layouts.admin')
@section('content')
        <div class="page-title col-sm-12">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h3 m-0">Add Offer</h1>
                </div>
                <div class="col-md-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Offer</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="row">
                <div class="col-lg-12 col-md-4 mb-4">
                    <form class="box bg-white" method="POST" enctype="multipart/form-data" id="addOfferForm" action="{{ route('admin.store_offer') }}">
                    @csrf
                        <div class="box-row flex-wrap">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Coupon Code</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control chkAlphabets" name="coupon_code" autocomplete="off" placeholder="Coupon Code">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Discount Type</label>
                                    <div class="input-group">
                                        <select name="discount_type" class="form-control">
                                            <option value="1">Fixed</option>
                                            <option value="2">Percentage</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Discount value</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control chkAlphabets" name=" discount_value" autocomplete="off" placeholder="Discount Value">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Expiry Date</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control chkAlphabets" name="expiry_date" autocomplete="off" placeholder="date">
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
                            <div class="col-md-12 mb-3 text-center">
                                <a href="{{ route('admin.list_offer') }}" class="btn light">Cancel</a>
                                <button type="submit" class="btn light">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
@endsection
@push('current-page-js')
<script type="text/javascript">
$("#addOfferForm").validate({
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