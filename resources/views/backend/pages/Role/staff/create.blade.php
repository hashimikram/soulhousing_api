@extends('backend.layout.master')
@section('breadcrumb_title','Create Staff')
@section('breadcrumb_li_1','Home')
@section('breadcrumb_li_2','Sub Admins Management - Sub Admins')
@section('breadcrumb_href', route('dashboard'))
@section('sub_admin_management_li', 'here show')
@section('sub_admin_a', 'active')
@section('page_title','Create Sub Admin')
@section('content')
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Card-->
        <div class="card">

            <!--begin::Card body-->
            <div class="card-body py-4">
                <!--begin::Form-->
                <form id="kt_modal_add_user_form" class="form" action="{{ route('sub-admin.store') }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll"
                         data-kt-scroll="true"
                         data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                         data-kt-scroll-dependencies="#kt_modal_add_user_header"
                         data-kt-scroll-wrappers="#kt_modal_add_user_scroll"
                         data-kt-scroll-offset="300px">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Name</label>
                                    <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="Admin" required value="{{ old('name') }}"/>
                                    @error('name')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="name" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Email</label>
                                    <input type="email" name="email"
                                           class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="john@doe.com" required value="{{ old('email') }}"/>
                                    @error('email')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="name" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Password</label>
                                    <input type="password" name="password"
                                           class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="*******" required value="{{ old('password') }}"/>
                                    @error('password')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="name" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Phone</label>
                                    <input type="text" name="phone"
                                           class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="+262 3782 162527" required value="{{ old('phone') }}"/>
                                    @error('phone')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="name" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <label class="required form-label">Select Role</label>
                                    <select class="form-select" name="role_id" data-control="select2"
                                            required>
                                        <option>Select Role</option>
                                        @foreach($roles as $data)
                                            <option value="{{$data->id}}">{{$data->role_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('role_id')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="first_name"
                                             data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="text-center pt-15">
                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
                            </button>
                        </div>
                    </div>
                </form>
                <!--end::Form-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>

@endsection
