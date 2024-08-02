@extends('admin.layout.master')
@section('title', 'Create User')
@section('user_li_1', 'active')

@section('content')
    <div class="content-body">
        <div class="mt-3 container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Vertical Form</h4>
                            <div class="basic-form">
                                <form method="POST" action="{{ route('user.update', $user->id) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="title">Title <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                                name="title" value="{{ $user->userDetail->title }}" placeholder="Mr, Mrs"
                                                required>
                                            @error('title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="first_name">First Name <span class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('first_name') is-invalid @enderror"
                                                name="first_name" value="{{ old('first_name', $user->first_name) }}"
                                                placeholder="First Name" required>
                                            @error('first_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="middle_name">Middle Name</label>
                                            <input type="text"
                                                class="form-control @error('middle_name') is-invalid @enderror"
                                                name="middle_name" value="{{ $user->userDetail->middle_name }}"
                                                placeholder="Middle Name">
                                            @error('middle_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="last_name">Last Name <span class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('last_name') is-invalid @enderror"
                                                name="last_name" value="{{ old('first_name', $user->last_name) }}"
                                                placeholder="Last Name" required>
                                            @error('last_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <div class="form-group col-md-4">
                                            <label for="gender">Gender</label>
                                            <select name="gender"
                                                class="form-control @error('gender') is-invalid @enderror">
                                                <option value="">Select Gender</option>
                                                <option @if ($user->userDetail->gender == 'Male') selected @endif value="Male"
                                                    {{ old('gender') == 'Male' ? 'selected' : '' }}>Male
                                                </option>
                                                <option @if ($user->userDetail->gender == 'Female') selected @endif value="Female"
                                                    {{ old('gender') == 'Female' ? 'selected' : '' }}>
                                                    Female</option>
                                                <option @if ($user->userDetail->gender == 'Other') selected @endif value="Other"
                                                    {{ old('gender') == 'Other' ? 'selected' : '' }}>
                                                    Other</option>
                                            </select>
                                            @error('gender')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="date_of_birth">Date of Birth</label>
                                            <input type="date"
                                                class="form-control @error('date_of_birth') is-invalid @enderror"
                                                name="date_of_birth" value="{{ $user->userDetail->date_of_birth }}">
                                            @error('date_of_birth')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="city">City</label>
                                            <input type="text" class="form-control @error('city') is-invalid @enderror"
                                                name="city" value="{{ $user->userDetail->city }}"
                                                placeholder="Bermingum">
                                            @error('city')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="country">Country</label>
                                            <input type="text"
                                                class="form-control @error('country') is-invalid @enderror" name="country"
                                                value="{{ $user->userDetail->country }}" placeholder="United State">
                                            @error('country')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="country">User Image</label>
                                            <input type="file"
                                                class="form-control-file @error('image') is-invalid @enderror"
                                                name="image">
                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <button type="submit" class="text-center btn btn-dark btn-block">Edit User</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #/ container -->
    </div>
@endsection
