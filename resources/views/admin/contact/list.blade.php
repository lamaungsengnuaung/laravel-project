@extends('admin.layouts.master')
@section('title', 'admin list')
@section('barContent')
    <h3>ADMIN FEEDBACK DASHBOARD</h3>
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
        <div class="row mb-3">
            <div class="col-3 offset-8 shadow-sm p-2 " @if (!request('searchData')) style="visibility: hidden" @endif>
                <h4>Search Key : <strong class="ps-2 text-danger">{{ request('searchData') }}
                    </strong>
                </h4>
            </div>
            <div class="col">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-6 p-2" style="height:800px; overflow:auto;">
                <div class="table-responsive table-responsive-data2">
                    <table class="table table-data2">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>name</th>
                                <th>email</th>
                                <th>message</th>
                                <th>post date</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr class="spacer"></tr>
                            {{-- {{ dd($adminsData->toArray()) }} --}}
                            @foreach ($message as $msg)
                                <tr class="tr-shadow dataRow">

                                    <td class="contactId">{{ $msg->id }}</td>
                                    <td>{{ $msg->name }} </td>
                                    {{-- <td>{{ $msg->role }} </td> --}}
                                    <td>{{ $msg->email }}</td>
                                    <td>{{ Str::words($msg->message, 4, '. . . . . .') }} </td>
                                    <td>{{ $msg->created_at->format('Y M d') }} </td>

                                </tr>
                                <tr class="spacer"></tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>

            </div>
            <div class="col-6">
                <div class="pl-5">
                    <div class="card" style="height: 800px; overflow:auto;">
                        <div class="card-header">
                            <div class="row mb-3">
                                <div class="col-6 h5">ID</div>
                                <div class="col-6 h5 id">{{ $message[0]->id }} </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6 h5"><i class="fa fa-user" aria-hidden="true"></i> Name</div>
                                <div class="col-6 h5 text-capitalize name">{{ $message[0]->name }} </div>
                            </div>
                            <div class="row">
                                <div class="col-6 h5"><i class="fas fa-mail-bulk  me-1  "></i> Email</div>
                                <div class="col-6 h5 email">{{ $message[0]->email }}</div>
                            </div>

                        </div>
                        <div class="card-body text-dark font-medium">
                            <h5 class="card-title">Feedback</h5>
                            <p class="message" style="text-indent: 40px; font-size:20px; word-spacing:12px">
                                {{ $message[0]->message }}
                            </p>
                        </div>
                        <div class="card-footer p-3">
                            <h5 class="text-muted date float-right">{{ $message[0]->created_at }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- END DATA TABLE -->
    </div>
@endsection
@section('scriptSection')
    <script>
        $(document).ready(function() {
            console.log('working.');
            $('.dataRow').click(function() {
                $childNode = $(this).children();
                $contactId = $childNode.first().html() * 1;
                console.log($contactId);
                $.ajax({
                    type: 'get',
                    url: '/contact/ajax/detail',
                    data: {
                        'id': $contactId
                    },
                    dataType: 'json',
                    success: function(response) {
                        // console.log(response);
                        $('.id').text(response.id)
                        $('.name').text(response.name);
                        $('.email').text(response.email);
                        $('.message').text(response.message);
                        $('.date').text(response.created_at.replace("T", "  ").substr(0, 20));
                    }
                })

            })

        })
    </script>
@endsection
