@extends('admin.layout.master')
@section('title', 'Floor Management')
@section('floor_li_1', 'active')
@section('floor_li_child_1', 'active')
@section('floor_li_child_1in', 'active')
@section('content')
    <div class="content-body">
        <div class="mt-3 container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add New Floor</h4>
                            <div class="basic-form">
                                <form method="POST" action="{{ route('floors.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="title">Floor Name <span class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('floor_name') is-invalid @enderror"
                                                name="floor_name" value="{{ old('floor_name') }}"
                                                placeholder="Enter Floor Name" required>
                                            @error('floor_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <button type="submit" class="text-center btn btn-dark btn-block">Add New
                                        Flooor</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Floor Management</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered zero-configuration">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Floor Name</th>
                                            <th>Total Rooms</th>
                                            <th>Total Beds Count</th>
                                            <th>Occupied Beds Count</th>
                                            <th>Vacant Beds Count</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $floorData)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $floorData['floor_name'] }}</td>
                                                <td><span
                                                        class="rounded label gradient-4">{{ $floorData['total_rooms_count'] }}</span>
                                                </td>
                                                <td><span
                                                        class="label gradient-1 btn-rounded">{{ $floorData['total_beds_count'] }}</span>
                                                </td>
                                                <td><span
                                                        class="label gradient-8 btn-rounded">{{ $floorData['occupied_beds_count'] }}</span>
                                                </td>
                                                <td><span
                                                        class="label btn-rounded gradient-2">{{ $floorData['vacant_beds_count'] }}</span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <a href="{{ route('facility.edit', $floorData['id']) }}"
                                                            data-toggle="tooltip" data-placement="top" title="Edit"
                                                            data-original-title="Edit"><i
                                                                class="fa fa-pencil color-muted m-r-5"></i> </a>
                                                        <form action="{{ route('facility.destroy', $floorData['id']) }}"
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
