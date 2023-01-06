@extends('user.layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5 " style="height: 800px;">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Products</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    {{-- {{ dd(count($carts)) }} --}}
                    <tbody class="align-middle" id="tBody">
                        @foreach ($carts as $cart)
                            <tr>
                                <input type="hidden" id="productId" value="{{ $cart->product_id }} ">
                                <input type="hidden" id="cartId" value="{{ $cart->cart_id }} ">


                                <td class="align-middle"><img class="rounded" src="{{ asset('storage/' . $cart->image) }}"
                                        alt="" style="width: 100px;">
                                </td>
                                <td class="align-middle text-capitalize"> {{ $cart->name }}</td>
                                {{-- {{ dd($cart->id) }} --}}
                                {{-- <li id="userId" value="{{ Auth::user()->id }}" hidden></li> --}}

                                <td class="align-middle" id="price">{{ $cart->price }} Ks</td>
                                <td class="align-middle">
                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-warning btn-minus">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" id="qty"
                                            class="form-control form-control-sm bg-white border-0 text-center"
                                            value="{{ $cart->qty }} ">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-warning btn-plus">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle  col-2" id="totalPrice">{{ $cart->qty * $cart->price }} Ks</td>
                                <td class="align-middle"><button class="btn btn-sm btn-danger btn-remove" id="btnRemove"><i
                                            class="fa fa-times"></i></button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <h4 class="section-title position-relative text-uppercase mb-4"><span class="bg-white pr-3">Cart
                        Summary</span></h4>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3" id="parent_subtotal">
                            <h4>Subtotal</h4>
                            <h4 id="subtotal">{{ $totalprice }} </h4>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h4 class="font-weight-medium">Shipping</h4>
                            <h4 class="font-weight-medium" id="delivery">3000 Ks</h4>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h3>Total</h3>
                            <h3 id="totalcost">{{ $totalprice + 3000 }} Ks</h3>
                        </div>
                        <button id="btnOrder" class="btn btn-block btn-warning font-weight-bold my-3 py-3">Proceed To
                            Checkout</button>
                    </div>
                    <div class="pt-2">
                        <button id="btnClearC" class="btn btn-block btn-warning font-weight-bold my-3 py-3">Clear All
                            Carts</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection
@section('scriptSource')
    <script src="{{ asset('user/js/cart.js') }} "></script>
    <script>
        $('#btnOrder').click(function() {
            $orderList = [];
            $random = Math.floor(Math.random() * 100000001);
            // console.log($r);
            $('#tBody tr').each(function(index, row) {
                $orderList.push({
                    'user_id': {{ Auth::user()->id }},
                    'product_id': $(row).find('#productId').val() * 1,
                    'qty': $(row).find('#qty').val() * 1,
                    'total': $(row).find('#totalPrice').html().replace('Ks', '') * 1,
                    'order_code': 'POS' + $random,
                });
            });
            console.log($orderList);
            $.ajax({
                type: 'get',
                url: '/user/ajax/order',
                data: {
                    $orderList,
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status) {
                        window.location.href = "http://127.0.0.1:8000/user/homePage";
                    }
                }

            })
        });
    </script>
@endsection
