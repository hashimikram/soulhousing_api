@extends('admin.layout.master')
@section('title', 'Facility Management')
@section('facility_li_1', 'active')
@section('facility_li_child_2', 'active')
@section('facility_li_child_2in', 'active')
@section('content')
    <div class="content-body">
        <div class="mt-3 container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add New Facility</h4>
                            <div class="basic-form">
                                <form method="POST" action="{{ route('facility.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="title">Text <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('text') is-invalid @enderror"
                                                name="text" value="{{ old('text') }}" placeholder="Nine Leaves"
                                                required>
                                            @error('text')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <button type="submit" class="text-center btn btn-dark btn-block">Add Facility</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Facility Management</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered zero-configuration">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Address</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($facility as $key => $data)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $data->address }}</td>
                                                <td>{{ formatDate($data->created_at) }}</td>
                                                <td>
                                                    <span>
                                                        <a href="{{ route('facility.edit', $data->id) }}" data-toggle="tooltip"
                                                            data-placement="top" title="Edit"
                                                            data-original-title="Edit"><i
                                                                class="fa fa-pencil color-muted m-r-5"></i> </a>
                                                        <form action="{{ route('facility.destroy', $data->id) }}"
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
