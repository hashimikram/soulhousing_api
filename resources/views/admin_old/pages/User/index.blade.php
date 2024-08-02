@extends('admin.layout.master')
@section('title', 'All Users')
@section('user_li_1', 'active')
@section('user_li_child_2', 'active')
@section('user_li_child_2in', 'active')
@section('content')
    <div class="content-body">
        <div class="mt-3 container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Data Table</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered zero-configuration">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>User Name</th>
                                            <th>Email</th>
                                            <th>Gender</th>
                                            <th>Date of Birth</th>
                                            <th>Country</th>
                                            <th>Registration Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $key => $data)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td><img class="mr-3" src="{{ image_url($data->userDetail->image) }}"
                                                        width="80" height="80" alt="">
                                                    {{ $data->userDetail->title }}
                                                    {{ $data->name }}</td>
                                                <td>{{ $data->userDetail->user_name }}</td>
                                                <td>{{ $data->email }}</td>
                                                <td>{{ $data->userDetail->gender }}</td>
                                                <td>{{ formatDate($data->userDetail->date_of_birth) }}
                                                    <span
                                                        class="p-1 label gradient-1">({{ \Carbon\Carbon::parse($data->userDetail->date_of_birth)->age }})</span>
                                                </td>
                                                <td>{{ $data->userDetail->country }}</td>
                                                <td>{{ formatDate($data->created_at) }}</td>
                                                <td>
                                                    <span>
                                                        <a href="{{ route('user.edit', $data->id) }}" data-toggle="tooltip"
                                                            data-placement="top" title="Edit"
                                                            data-original-title="Edit"><i
                                                                class="fa fa-pencil color-muted m-r-5"></i> </a>
                                                        <form action="{{ route('user.destroy', $data->id) }}"
                                                            class="d-inline" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" data-toggle="tooltip"
                                                                class="bg-white btn btn-transparent text-danger"
                                                                data-placement="top" class="text-danger" title="Delete"
                                                                data-original-title="Delete"><i
                                                                    class="fa fa-close tex-danger color-danger"></i></button>
                                                        </form>
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #/ container -->
    </div>
@endsection
