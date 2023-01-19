@extends('layouts.admin')
@section('content')
    <div class="page-title col-sm-12">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3 m-0">Order</h1>
            </div>
            <div class="col-md-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Order</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="row">
            <div class="col-lg-12 col-md-4 mb-4">
                <div class="box bg-white">
                    <div class="box-title pb-0">
                        <h5>Order Details</h5>
                    </div>
                    <div class="box-row flex-wrap user-contact">
                        <div class="d-flex">
                            <label>User Name</label>
                            <span class="text-muted">{{ $order_details->userDetails->full_name }}</span>
                        </div>
                        <div class="d-flex">
                            <label>Total (INR)</label>
                            <span class="text-muted">{{ $order_details->total_price }}</span>
                        </div>
                        @if(!$order_details->orderDetails->isEmpty())
                            @foreach($order_details->orderDetails as $orderDetail)
                            <div class="d-flex">
                                <p><strong>Product Name:</strong> {{ $orderDetail->productDetails->product_name }}</p>
                                <label>Variants</label>
                                <span class="text-muted">
                                @if(!$orderDetail->productVariantCombination->combinationDetails->isEmpty())
                                    @foreach($orderDetail->productVariantCombination->combinationDetails as $combinationDetail)
                                        <li>{{ $combinationDetail->variantDetails->name }} - {{ $combinationDetail->variant_value }} ( Qty: {{ $orderDetail->quantity }}, Price: {{ $orderDetail->price }})</li>
                                    @endforeach
                                @endif
                                </span>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection