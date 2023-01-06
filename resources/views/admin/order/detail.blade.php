@extends('admin.layouts.master')
@section('title', 'orders list')
@section('barContent')
    {{-- search box --}}
    <h3> Order List Detail</h3>
@endsection
@section('content')
    <div class="col-md-12">
        <!-- DATA TABLE -->
        <div class="table-data__tool">
            <div class="table-data__tool-left shadow-sm">
                <div class="overview-wrap ">
                    <h2 class="title-1 h4 px-5">Order List</h2>
                    <i class="fa fa-database mr-2" aria-hidden="true"></i>{{ count($data) }}

                </div>
            </div>
            <div>
            </div>
        </div>
        <div class="col-1 offset-4 px-5">
            <button class="btn btn-dark px-3 text-white mb-2" onclick="history.back()"><i class="fa fa-arrow-left"
                    aria-hidden="true"></i></button>
        </div>
        <div class="row col-5">
            <div class="card mt-4">
                <div class="card-body">
                    <h3 class="text-uppercase"><i class="fa-solid fa-clipboard-list me-3"></i>Order Info</h3>
                    <small class="text-danger text-bold mt-1"><i class="fa-solid fa-circle-plus me-2"></i>Including Delivery
                        Fee (3000 Ks)</small>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col"> <i class="fa-solid fa-user me-3"></i>Name</div>
                        <div class="col">{{ strtoupper($data[0]->user_name) }} </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col "><i class="fa-solid fa-barcode me-3"></i>Order Code</div>
                        <div class="col">{{ $data[0]->order_code }} </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col"><i class="fa-solid fa-coins me-3"></i>Amount</div>
                        <div class="col">{{ $totalprice }} Ks</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col"> <i class="fa-solid fa-map-location-dot me-3"></i>Address</div>
                        <div class="col text-capitalize">{{ $data[0]->address }} </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col text-muted"> <i class="fa-regular fa-calendar-check me-3"></i>Order Date</div>
                        <div class="col text-muted ">{{ $data[0]->updated_at->format('d F Y h:i a') }} </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive table-responsive-data2 p-md-2">
            <table class="table table-data2">
                <thead>
                    <tr>
                        {{-- <th>id</th> --}}
                        <th>image</th>
                        <th>product</th>
                        <th>order code</th>
                        <th>qty</th>
                        <th>amount</th>
                        <th>order date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="spacer"></tr>
                    <span id="dataList">
                        @foreach ($data as $item)
                            <tr class="tr-shadow ">
                                <td id="orderId" hidden>{{ $item->id }} </td>
                                <td>
                                    <img src="{{ asset('storage/' . $item->image) }} " alt="" class="img-thumbnail"
                                        style="width: 150px">
                                </td>
                                <td>{{ $item->name }} </td>
                                <td>{{ $item->order_code }} </td>
                                <td>{{ $item->qty }} </td>
                                <td>{{ $item->total }} </td>
                                <td>{{ $item->created_at->format('d-F-Y') }} </td>
                            </tr>
                            <tr class="spacer"></tr>
                        @endforeach
                    </span>
                </tbody>

            </table>
        </div>
    </div>
@endsection
