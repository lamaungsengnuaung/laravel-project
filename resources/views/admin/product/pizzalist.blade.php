@extends('admin.layouts.master')
@section('title', 'products list')
@section('barContent')
    {{-- search box --}}
    <form class="form-header" action=" {{ route('products#list') }} " method="get">
        @csrf
        <input class="au-input au-input--xl " type="text" name="searchData" value=" {{ request('searchData') }} "
            placeholder="Search for datas &amp; reports..." />
        <button class="au-btn--submit" type="submit">
            <i class="zmdi zmdi-search"></i>
        </button>
    </form>
@endsection
@section('content')
    <div class="col-md-12">
        <!-- DATA TABLE -->
        <div class="table-data__tool">
            <div class="table-data__tool-left shadow-sm">
                <div class="overview-wrap ">
                    <h2 class="title-1 m-2">Product List</h2>

                </div>
            </div>
            <div class="table-data__tool-right">
                <a href="{{ route('products#createPage') }} ">
                    <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                        <i class="zmdi zmdi-plus"></i>add product
                    </button>
                </a>

            </div>
        </div>
        @if (session('deleteMessage'))
            <div class="alert alert-warning alert-dismissible fade show col-6" role="alert">
                <strong>{{ session('deleteMessage') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('updateMessage'))
            <div class="alert alert-warning alert-dismissible fade show col-6" role="alert">
                <strong>{{ session('updateMessage') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row">
            <div class="col-3 offset-8  p-2 bg-white" @if (!request('searchData')) style="visibility: hidden" @endif>
                <h4>Search Key : <strong class="ps-2 text-danger">{{ request('searchData') }}
                    </strong>
                </h4>
            </div>
            <div class="col">
                <i class="fas fa-database px-1 "></i> <strong>{{ $product->total() }} </strong>
            </div>
        </div>
        @if (count($product) != 0)
            <div class="table-responsive table-responsive-data2 p-md-2">
                <table class="table table-data2">
                    <thead>
                        <tr>
                            <th> image</th>
                            <th>name </th>
                            <th>category</th>
                            <th>price</th>
                            <th> description</th>
                            <th>waiting_time</th>
                            <th>viewer</th>

                        </tr>
                    </thead>

                    <tbody>
                        <tr class="spacer"></tr>



                        @foreach ($product as $item)
                            <tr class="tr-shadow ">
                                <td><img src=" {{ asset('storage/' . $item->image) }} " alt="pizza"
                                        class="img-thumbnail rounded shadow-sm " style="width:300px">
                                </td>
                                <td>{{ $item->name }} </td>
                                <td class="desc">{{ $item->category_name }} </td>
                                <td>{{ $item->price }}Ks </td>
                                <td class="">{{ Str::words($item->description, 8, '. . . .') }} </td>
                                <td> {{ $item->waiting_time }} min</td>
                                <td>{{ $item->view_count }} <i class="fa fa-eye ml-1" aria-hidden="true"></i></td>

                                <td>
                                    <div class="table-data-feature">

                                        <a href="{{ route('products#detailPage', $item->id) }} " class="item"
                                            data-toggle="tooltip" data-placement="top" title="Detail">
                                            <i class="fa-regular fa-file-lines"></i>
                                        </a>
                                        <a href="{{ route('products#editPage', $item->id) }} " class="item"
                                            data-toggle="tooltip" data-placement="top" title="Edit">
                                            <i class="zmdi zmdi-edit"></i>
                                        </a>
                                        {{-- {{ dd(Auth::user()->id) }} --}}
                                        <form action="{{ route('products#delete', $item->id) }} " method="post">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="item" data-toggle="tooltip" data-placement="top"
                                                title="Delete">
                                                <i class="zmdi zmdi-delete"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                            <tr class="spacer"></tr>
                        @endforeach

                    </tbody>

                </table>
            </div>
        @else
            <h3 class="text-center my-5">There is no Product</h3>
        @endif
        <div class="my-2 pb-3">

            {{ $product->links() }}

        </div>
        <!-- END DATA TABLE -->
    </div>
@endsection
