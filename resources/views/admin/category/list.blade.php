@extends('admin.layouts.master')
@section('title', 'category list')
@section('barContent')
    {{-- search box --}}
    <form class="form-header" action="{{ route('category#list') }} " method="get">
        @csrf
        <input class="au-input au-input--xl" type="text" name="searchData" value="{{ request('searchData') }} "
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
            <div class="table-data__tool-left">
                <div class="overview-wrap">
                    <h2 class="title-1">Category List</h2>

                </div>
            </div>
            <div class="table-data__tool-right">
                <a href="{{ route('category#createPage') }} ">
                    <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                        <i class="zmdi zmdi-plus"></i>add cartegory
                    </button>
                </a>

            </div>
        </div>

        @if (session('deleteSuccess'))
            <div class="alert alert-warning alert-dismissible fade show col-6" role="alert">
                <strong>{{ session('deleteSuccess') }}</strong>
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
            <div class="col-3 offset-8 shadow-sm p-2 " @if (!request('searchData')) style="visibility: hidden" @endif>
                <h4>Search Key : <strong class="ps-2 text-danger">{{ request('searchData') }}
                    </strong>
                </h4>
            </div>
            <div class="col">
                <i class="fas fa-database px-1 "></i> <strong>{{ $categories->total() }} </strong>
            </div>
        </div>
        @if (count($categories) != 0)
            <div class="table-responsive table-responsive-data2">
                <table class="table table-data2">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>name</th>
                            <th>created date</th>
                            <th></th>

                        </tr>
                    </thead>

                    <tbody>
                        <tr class="spacer"></tr>
                        @foreach ($categories as $category)
                            <tr class="tr-shadow">

                                <td>{{ $category['id'] }} </td>
                                <td>{{ $category['name'] }} </td>
                                <td>{{ $category['created_at']->format('j - F - Y') }} </td>
                                <td>
                                    <div class="table-data-feature">

                                        <a href="{{ route('category#edit', $category['id']) }} " class="item"
                                            data-toggle="tooltip" data-placement="top" title="Edit">
                                            <i class="zmdi zmdi-edit"></i>
                                        </a>

                                        <form action="{{ route('category#delete', $category['id']) }} " method="post">
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
            <h3 class="text-center my-5">There is no Category.</h3>
        @endif
        <div class="my-2">
            {{ $categories->links() }}

        </div>
        <!-- END DATA TABLE -->
    </div>
@endsection
