@extends('admin.layouts.master')
@section('title', 'orders list')
@section('barContent')
    {{-- search box --}}
    <form class="form-header" action=" {{ route('orders#search') }} " method="post">
        @csrf
        <a href="{{ route('orders#list') }} " class="au-btn--submit" data-toggle="tooltip" title="refresh"><i
                class="fa-sharp fa-solid fa-arrow-rotate-right text-dark"></i>
        </a>
        <input class="au-input au-input--xl input-group" type="text" name="searchData"
            value=" {{ request('searchData') }} " placeholder="Search for datas &amp; reports..." />
        <select name="filterStatus" id="filterStatus" class="form-select   input-group bg-primary text-white col-3"
            style="letter-spacing: 2px">
            <option value="9" @if (request('filterStatus') == '9') selected @endif>ALL STATUS</option>
            <option value="0" @if (request('filterStatus') == '0') selected @endif>
                PENDING</option>
            <option value="1" @if (request('filterStatus') == '1') selected @endif>SUCCESS</option>
            <option value="2" @if (request('filterStatus') == '2') selected @endif>REJECT</option>
        </select>
        <button class="au-btn--submit" type="submit" id="search">
            <i class="zmdi zmdi-search"></i>
        </button>
    </form>

    {{-- {{ print request('searchData') }} --}}
@endsection
@section('content')
    <div class="col-md-12">
        <!-- DATA TABLE -->
        <div class="table-data__tool">
            <div class="table-data__tool-left shadow-sm">
                <div class="overview-wrap ">
                    <h2 class="title-1 h4 px-5">Order List</h2>
                    <i class="fa fa-database mr-2" aria-hidden="true"></i>{{ count($orders) }}

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-3 offset-8 shadow-sm p-2 border border-danger"
                @if (!request('searchData')) style="visibility: hidden" @endif>
                <h4>
                    {{-- <i class="fas fa-database px-2 "> <strong>{{ count($orders) }} </strong></i> --}}
                    Search Key : <strong class="ps-2 text-danger">{{ request('searchData') }}
                    </strong>

                </h4>
            </div>

        </div>

        <div class="table-responsive table-responsive-data2 p-md-2">
            <table class="table table-data2">
                <thead>
                    <tr>
                        <th hidden>id</th>
                        <th>date</th>

                        <th>user_Id</th>
                        <th>order_code</th>
                        <th>amount</th>
                        <th>status</th>

                    </tr>
                </thead>
                @if (!count($orders))
                    <td class="text-center shadow" colspan="5">
                        <h3>Refresh<i class="fa-solid fa-exclamation mx-3"></i> | Search Data empty <i </h3>
                    </td>
                    <td></td>
                    <td></td>
                @else
                    <tbody>
                        <tr class="spacer"></tr>
                        <span id="dataList">
                            @foreach ($orders as $item)
                                <tr class="tr-shadow ">
                                    <td id="orderId" hidden>{{ $item->id }} </td>
                                    <td>{{ $item->created_at }} </td>

                                    <td class="border-2 border-danger">{{ $item->user_id }} </td>
                                    <td> <a href="{{ route('orders#listInfo', $item->order_code) }} "
                                            class="text-decoration-none">
                                            {{ $item->order_code }}
                                        </a>
                                    </td>
                                    <td>{{ $item->total_price }} Ks </td>
                                    <td class="shadow">
                                        <select name="inputStatus" class="changeStatus form-control" id="status"
                                            class="form-control">
                                            <option title="option" value="0"
                                                @if ($item->status == 0) selected @endif>
                                                Pending
                                            </option>
                                            <option title="option" value="1"
                                                @if ($item->status == 1) selected @endif>
                                                Success
                                            </option>
                                            <option title="option" value="2"
                                                @if ($item->status == 2) selected @endif>
                                                Reject
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                                <tr class="spacer"></tr>
                            @endforeach
                        </span>

                    </tbody>
                @endif
            </table>
        </div>

    </div>
@endsection
@section('scriptSection')
    {{-- change status --}}
    <script>
        $(document).ready(function() {
            console.log('working');
            $('.changeStatus').change(function() {
                $currentStatus = $(this).val();
                // console.log($currentStatus);
                $parentNode = $(this).parents('tr');
                $orderId = $parentNode.find('#orderId').text();
                console.log($orderId, $currentStatus);
                $.ajax({
                    type: 'get',
                    url: "/orders/ajax/changeStatus",
                    data: {
                        'orderId': $orderId,
                        'currentStatus': $currentStatus
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                    }

                })

            })
        })
    </script>
    {{-- filter by Status --}}
    <script>
        $(document).ready(function() {
            console.log('working');
            $('#filterStatus').change(function() {
                $currentStatus = $(this).val();
                // console.log($currentStatus);
                // $parentNode = $(this).parents('tr');
                // $orderId = $parentNode.find('#orderId').text();
                console.log($currentStatus);
                $.ajax({
                    type: 'get',
                    url: "/orders/ajax/filterStatus",
                    data: {
                        'currentStatus': $currentStatus
                    },
                    dataType: 'json',
                    success: function(response) {
                        // logger(response);
                        $list = '';
                        for ($i = 0; $i < response.length; $i++) {
                            $list += `
                         <tr class="tr-shadow ">
                            <td id="orderId" class="h5 text-muted" hidden>${response[$i].id} </td>
                            <td class="h5 text-muted">${response[$i].created_at.replace("T"," ").substr(0,19)} </td>

                            <td class="h5 text-muted">${response[$i].user_id} </td>
                            <td class="h5 text-muted">${response[$i].order_code} </td>
                            <td class="h5 text-muted">${response[$i].total_price} Ks</td>
                            <td class="h5 bg-secondary bg-opacity-25 text-muted">${response[$i].status==0?"Pending":response[$i].status==1?"Success":"Reject"}</td>
                            <td class="shadow">
                            </td>
                        </tr>
                        <tr class="spacer"></tr>
                        `;
                        }

                        $('tbody').html($list);


                    }

                })

            })
        })
    </script>

@endsection
{{-- @switch(response[$i].status)
    @case(1)
        <option title="option" value="1" selected> Success ${response[$i].status}</option>
    @break

    @case(2)
        <option title="option" value="2" selected> Reject ${response[$i].status} </option>
    @break

    @default
        <option title="option" value="1" selected>Pending ${response[$i].status}</option>
@endswitch --}}
