@extends('admin.layouts.master')
@section('title', 'customer list')
@section('barContent')
    {{-- search box --}}
    <form class="form-header" action="{{ route('customer#list') }} " method="get">
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
                    <h2 class="title-1">customer List</h2>

                </div>
            </div>

        </div>

        @if (session('deleteSuccess'))
            <div class="alert alert-danger alert-dismissible fade show col-6" role="alert">
                <strong><i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('deleteSuccess') }}</strong>
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
                <i class="fas fa-database px-1"></i> <strong>{{ $customersData->total() }}</strong>
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
                    {{-- {{ dd($customersData->toArray()) }} --}}
                    @if (count($customersData) != 0)

                        @foreach ($customersData as $customer)
                            <tr class="tr-shadow">
                                <td>
                                    @if ($customer->image == null)
                                        @if ($customer->gender == 'female')
                                            <img src=" {{ asset('images/default-female.jpg') }} " style="width: 200px"
                                                alt="">
                                        @else
                                            <img src=" {{ asset('images/Default-welcomer.png') }} " style="width: 200px"
                                                alt="">
                                        @endif
                                    @else
                                        <img src="{{ asset('storage/' . $customer->image) }}" style="width:200px"
                                            alt="">
                                    @endif
                                </td>
                                {{-- <td>{{ $customer->id }}({{ Auth::user()->id }}) </td> --}}
                                <td>{{ $customer->name }} </td>
                                <td id="customerId" hidden>{{ $customer->id }} </td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->gender }}</td>
                                <td>{{ $customer->phone }}</td>
                                <td>{{ $customer->address }}</td>
                                <td>{{ $customer->created_at }} </td>
                                <td>
                                    <select name="role" id="changeRole" class="form-control changeRole">
                                        <option value="user" {{ $customer->role == 'user' ? 'selected' : '' }}>Customer
                                        </option>
                                        <option value="admin"{{ $customer->role == 'admin' ? 'selected' : '' }}>Admin
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    <form action="{{ route('customer#delete', $customer->id) }} " method="post">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="item" data-toggle="tooltip" data-placement="top"
                                            title="Delete">
                                            <i class="zmdi zmdi-delete"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <tr class="spacer"></tr>
                        @endforeach
                    @else
                        <td colspan="7">
                            <h3 class="text-info text-center">There is no Customer.</h3>
                        </td>
                    @endif
                </tbody>

            </table>

        </div>
        <div class="my-3">
            {{ $customersData->links() }}
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
                // console.log($currentRole);
                $parentNode = $(this).parents('tr');
                $customerId = $parentNode.find('#customerId').text();
                // console.log($customerId, $currentRole);
                $.ajax({
                    type: 'get',
                    url: "/customer/ajax/changeRole",
                    data: {
                        'customerId': $customerId,
                        'currentRole': $currentRole
                    },
                    dataType: 'json',
                })
                location.reload();

            })
        })
    </script>
@endsection
