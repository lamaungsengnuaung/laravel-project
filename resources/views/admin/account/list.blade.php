@extends('admin.layouts.master')
@section('title', 'admin list')
@section('barContent')
    {{-- search box --}}
    <form class="form-header" action="{{ route('admin#list') }} " method="get">
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
            <div class="table-data__tool-left shadow-sm">
                <div class="overview-wrap">
                    <h2 class="title-1 p-2">Admin List</h2>

                </div>
            </div>

        </div>

        @if (session('deleteSuccess'))
            <div class="alert alert-danger alert-dismissible fade show col-6" role="alert">
                <strong>{{ session('deleteSuccess') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('roleChange'))
            <div class="alert alert-info alert-dismissible fade show col-6" role="alert">
                <strong>{{ session('roleChange') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row mb-3">
            <div class="col-3 offset-8 shadow-sm p-2 " @if (!request('searchData')) style="visibility: hidden" @endif>
                <h4>Search Key : <strong class="ps-2 text-danger">{{ request('searchData') }}
                    </strong>
                </h4>
            </div>
            <div class="col">
                <i class="fas fa-database px-1"></i> <strong>{{ $adminsData->total() }}</strong>
            </div>
        </div>

        <div class="table-responsive table-responsive-data2">
            <table class="table table-data2">
                <thead>
                    <tr>

                        <th>image</th>
                        <th>name</th>
                        <th>email</th>
                        <th>gender</th>
                        <th>phone</th>
                        <th>address</th>
                        <th>created date</th>


                    </tr>
                </thead>

                <tbody>
                    <tr class="spacer"></tr>
                    {{-- {{ dd($adminsData->toArray()) }} --}}
                    @foreach ($adminsData as $adm)
                        <tr class="tr-shadow">
                            <td>
                                @if ($adm->image == null)
                                    @if ($adm->gender == 'female')
                                        <img src=" {{ asset('images/default-female.jpg') }} " style="width: 200px"
                                            alt="">
                                    @else
                                        <img src=" {{ asset('images/Default-welcomer.png') }} " style="width: 200px"
                                            alt="">
                                    @endif
                                @else
                                    <img src="{{ asset('storage/' . $adm->image) }}" style="width:200px" alt="">
                                @endif
                            </td>
                            <td id="adminId" hidden>{{ $adm->id }}</td>
                            <td>{{ $adm->name }} </td>
                            {{-- <td>{{ $adm->role }} </td> --}}
                            <td>{{ $adm->email }}</td>
                            <td>{{ $adm->gender }}</td>
                            <td>{{ $adm->phone }}</td>
                            <td>{{ $adm->address }}</td>
                            <td>{{ $adm->created_at }} </td>
                            <td>
                                <div class="table-data-feature">
                                    @if ($adm->id != Auth::user()->id)
                                        <select name="role" id="changeRole"
                                            class="form-control changeRole me-5 bg-warning">
                                            <option value="user" {{ $adm->role == 'user' ? 'selected' : '' }}>
                                                User
                                            </option>
                                            <option value="admin"{{ $adm->role == 'admin' ? 'selected' : '' }}>Admin
                                            </option>
                                        </select>

                                        <a href="{{ route('admin#changeRole', $adm->id) }} "
                                            class="item"data-toggle="tooltip" data-placement="top"
                                            title="Detail & Change-Role">
                                            <i class="fa-solid fa-person-circle-minus"></i></a>

                                        <form action="{{ route('admin#delete', $adm->id) }} " method="post">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="item" data-toggle="tooltip" data-placement="top"
                                                title="Delete">
                                                <i class="zmdi zmdi-delete"></i>
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('admin#info') }}">
                                            <div class="btn btn-lg btn-dark">
                                                <div class="status--denied">it is me</div>
                                            </div>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr class="spacer"></tr>
                    @endforeach

                </tbody>
            </table>

        </div>

        <div class="my-3">
            {{ $adminsData->links() }}
        </div>
        <!-- END DATA TABLE -->
    </div>
@endsection
@section('scriptSection')
    <script>
        $(document).ready(function() {
            console.log('working');
            $('.changeRole').change(function() {
                $currentRole = $(this).val();
                $parentNode = $(this).parents("tr");
                $adminId = $parentNode.find("#adminId").text();
                // console.log($currentRole, $adminId);
                $.ajax({
                    type: 'get',
                    url: '/admin/role/ajax/change',
                    data: {
                        'currentRole': $currentRole,
                        'adminId': $adminId
                    },
                    dataType: 'json',
                })
                location.reload();
            })
        })
    </script>
@endsection
