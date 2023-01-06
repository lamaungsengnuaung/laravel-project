@extends('user.layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5" style="height: 700px">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            {{-- <th>No.</th> --}}
                            <th>Date</th>
                            <th>OrderCode</th>
                            <th>Amount</th>
                            {{-- <th>Total</th> --}}
                            <th>Status</th>
                        </tr>
                    </thead>

                    {{-- {{ dd(count($carts)) }} --}}
                    <tbody class="align-middle" id="tBody">
                        @foreach ($orders as $order)
                            <tr>
                                <td class="align-middle" hidden>{{ $order->id }} </td>
                                <td class="align-middle">{{ $order->updated_at->format('Y-m-d H:i:s') }} </td>

                                <td class="align-middle">{{ $order->order_code }} </td>
                                <td class="align-middle" id="price">{{ $order->total_price }} Ks</td>
                                @switch($order->status)
                                    @case(1)
                                        <td class="align-middle text-success"><i class="fa-regular fa-circle-check px-1"></i>Success
                                        </td>
                                    @break

                                    @case(2)
                                        <td class="align-middle text-danger"><i
                                                class="fa-solid fa-triangle-exclamation px-1"></i>Rejected </td>
                                    @break

                                    @default
                                        <td class="align-middle text-primary"><i class="fa-solid fa-spinner px-1"></i>Pending ....
                                        </td>
                                @endswitch

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
