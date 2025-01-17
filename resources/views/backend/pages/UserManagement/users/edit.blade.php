@php use App\Models\ListOption; @endphp
@php use App\Models\Facility; @endphp
@extends('backend.layout.master')
@section('breadcrumb_title', 'Edit User')
@section('breadcrumb_li_1', 'Home')
@section('breadcrumb_li_2', 'User Management - Edit User')
@section('breadcrumb_href', route('dashboard'))
@section('user_management_li', 'here show')
@section('users_a', 'active')
@section('page_title', 'Edit User')
@section('content')
    <div id="kt_app_content_container" class="app-container">
        <!--begin::Card-->
        <div class="card">

            <!--begin::Card body-->
            <div class="card-body py-4">
                <!--begin::Form-->
                <form id="kt_modal_add_user_form" class="form" action="{{ route('user.update', $user->id) }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll"
                         data-kt-scroll="true"
                         data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                         data-kt-scroll-dependencies="#kt_modal_add_user_header"
                         data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <label class="d-block fw-semibold fs-6 mb-5">Avatar</label>
                            <style>
                                .image-input-placeholder {
                                    background-image: url("{{ asset('backend/assets/media/svg/files/blank-image.svg') }}");
                                }

                                [data-theme="dark"] .image-input-placeholder {
                                    background-image: url("{{ asset('backend/assets/media/svg/files/blank-image-dark.svg') }}");
                                }
                            </style>
                            <div class="image-input image-input-outline image-input-placeholder"
                                 data-kt-image-input="true">
                                <div class="image-input-wrapper w-125px h-125px"
                                     style="background-image: url({{ image_url($user->userDetail->image) }});"></div>
                                <label
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                    <i class="bi bi-pencil-fill fs-7"></i>
                                    <input type="file" name="image" accept=".png, .jpg, .jpeg"/>
                                    <input type="hidden" name="avatar_remove"/>
                                </label>
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                            </div>
                            <div class="form-text">
                                Allowed file types: png, jpg, jpeg.
                            </div>
                            @error('image')
                            <div class="fv-plugins-message-container invalid-feedback">
                                <div data-field="image" data-validator="notEmpty">{{ $message }}</div>
                            </div>
                            @enderror
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Title</label>
                                    <input type="text" name="title"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Mr, Mrs"
                                           required
                                           value="{{ old('title', $user->userDetail->title) }}"/>
                                    @error('title')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="title" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">First Name</label>
                                    <input type="text" name="first_name"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="John"
                                           required
                                           value="{{ old('first_name', $user->name) }}"/>
                                    @error('first_name')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="first_name" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <label class="fw-semibold fs-6 mb-2">Middle Name</label>
                                    <input type="text" name="middle_name"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Elwa"
                                           value="{{ old('middle_name', $user->userDetail->middle_name) }}"/>
                                    @error('middle_name')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="middle_name" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <label class="fw-semibold fs-6 mb-2">Last Name</label>
                                    <input type="text" name="last_name"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Doe"
                                           value="{{ old('last_name', $user->userDetail->last_name) }}"/>
                                    @error('last_name')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="last_name" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Email</label>
                                    <input type="email" name="email" required readonly
                                           class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="example@domain.com" value="{{ old('email', $user->email) }}"/>
                                    @error('email')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="email" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Gender</label>
                                    <select class="form-control form-control-solid mb-3 mb-lg-0" name="gender" required>
                                        <option>Select Gender</option>
                                        <option value="Male"
                                            {{ old('gender', $user->userDetail->gender) == 'Male' ? 'selected' : '' }}>
                                            Male
                                        </option>
                                        <option value="Female"
                                            {{ old('gender', $user->userDetail->gender) == 'Female' ? 'selected' : '' }}>
                                            Female
                                        </option>
                                        <option value="Other"
                                            {{ old('gender', $user->userDetail->gender) == 'Other' ? 'selected' : '' }}>
                                            Other
                                        </option>
                                    </select>
                                    @error('gender')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="gender" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <label class="required fw-semibold fs-6 mb-2">Date of Birth</label>
                                    <input type="date" name="date_of_birth" required
                                           class="form-control form-control-solid mb-3 mb-lg-0"
                                           value="{{ old('date_of_birth', $user->userDetail->date_of_birth) }}"/>
                                    @error('date_of_birth')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="date_of_birth" data-validator="notEmpty">{{ $message }}
                                        </div>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <label class="fw-semibold fs-6 mb-2">Country</label>
                                    <input type="text" name="country" placeholder="United States"
                                           class="form-control form-control-solid mb-3 mb-lg-0"
                                           value="{{ old('country', $user->userDetail->country) }}"/>
                                    @error('country')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="country" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">

                                    <label class="required fw-semibold fs-6 mb-2">User Type</label>

                                    <select class="form-control form-control-solid mb-3 mb-lg-0" name="user_type"
                                            required>
                                        <option>Select User Type</option>
                                        <option value="provider" @if ($user->user_type == 'provider') selected @endif>
                                            Provider
                                        </option>
                                        <option value="nurse" @if ($user->user_type == 'nurse') selected @endif>
                                            Nurse
                                        </option>
                                        <option value="maintenance"
                                                @if ($user->user_type == 'maintenance') selected @endif>
                                            Maintenance
                                        </option>
                                        <option value="operation" @if ($user->user_type == 'operation') selected @endif>
                                            Operation
                                        </option>
                                    </select>
                                    @error('user_type')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="email" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">Speciality</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select class="form-control form-control-solid mb-3 mb-lg-0" name="speciality_id"
                                            required>
                                        <option>Select Speciality</option>
                                        @foreach (ListOption::where('list_id', 'Specialty')->get() as $speciality_details)
                                            <option value="{{ $speciality_details->id }}"
                                                    @if ($user->userDetail->speciality_id == $speciality_details->id) selected @endif>
                                                {{ $speciality_details->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('speciality_id')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="speciality_id" data-validator="notEmpty">{{ $message }}
                                        </div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">Facilities</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select
                                        class="form-control form-control-solid mb-3 mb-lg-0 js-example-basic-multiple"
                                        multiple="multiple" name="facilities[]" required>
                                        <option value="">Select Facilities</option>
                                        @php
                                            $selectedFacilities = json_decode($user->userDetail->facilities, true) ?? [];
                                        @endphp
                                        @foreach (Facility::all() as $data)
                                            <option value="{{ $data->id }}"
                                                    @if(in_array($data->id, $selectedFacilities)) selected @endif>
                                                {{ $data->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('facilities')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="facilities" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                        </div>

                        <!--end::Input group-->

                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3">Discard</button>
                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Scroll-->
                </form>

                <!--end::Form-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>

@endsection
@section('custom_js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('.js-example-basic-multiple').select2();
        });
    </script>
@endsection
