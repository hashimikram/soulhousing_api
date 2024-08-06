@extends('backend.layout.master')
@section('breadcrumb_title', 'Create User')
@section('breadcrumb_li_1', 'Home')
@section('breadcrumb_li_2', 'User Management - Users')
@section('breadcrumb_href', route('dashboard'))
@section('user_management_li', 'here show')
@section('users_a', 'active')
@section('page_title', 'Create User')
@section('custom_css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
@endsection
@section('content')
    <form id="kt_modal_add_user_form" class="form" action="{{ route('user.store') }}" method="POST"
          enctype="multipart/form-data">
        @csrf
        <div id="kt_app_content_container" class="app-container">
            <!--begin::Card-->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">User Information</h3>
                </div>
                <!--begin::Card body-->
                <div class="card-body py-4">
                    <!--begin::Form-->
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll"
                         data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                         data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header"
                         data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="d-block fw-semibold fs-6 mb-5">Avatar</label>
                            <!--end::Label-->
                            <!--begin::Image placeholder-->
                            <style>
                                .image-input-placeholder {
                                    background-image: url("{{ asset('backend/assets/media/svg/files/blank-image.svg') }}");
                                }

                                [data-theme="dark"] .image-input-placeholder {
                                    background-image: url("{{ asset('backend/assets/media/svg/files/blank-image-dark.svg') }}");
                                }
                            </style>
                            <!--end::Image placeholder-->
                            <!--begin::Image input-->
                            <div class="image-input image-input-outline image-input-placeholder"
                                 data-kt-image-input="true">
                                <!--begin::Preview existing avatar-->
                                <div class="image-input-wrapper w-125px h-125px"
                                     style="
                                            background-image: url({{ image_url('placeholder.jpg') }});
                                          ">
                                </div>
                                <!--end::Preview existing avatar-->
                                <!--begin::Label-->
                                <label
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                    <i class="bi bi-pencil-fill fs-7"></i>
                                    <!--begin::Inputs-->
                                    <input type="file" name="image" accept=".png, .jpg, .jpeg"/>
                                    <input type="hidden" name="avatar_remove"/>
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Label-->
                                <!--begin::Cancel-->
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <!--end::Cancel-->
                                <!--begin::Remove-->
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <!--end::Remove-->
                            </div>
                            <!--end::Image input-->
                            <!--begin::Hint-->
                            <div class="form-text">
                                Allowed file types: png, jpg, jpeg.
                            </div>
                            <!--end::Hint-->
                            @error('image')
                            <div class="fv-plugins-message-container invalid-feedback">
                                <div data-field="email" data-validator="notEmpty">{{ $message }}</div>
                            </div>
                            @enderror
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row">
                            <div class="col-md-6">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">Title</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="title"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Mr, Mrs"
                                           required value="{{ old('title') }}"/>
                                    @error('title')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="email" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror


                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">First Name</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="first_name"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="John"
                                           value="{{ old('first_name') }}"/>
                                    @error('first_name')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="email" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class=" fw-semibold fs-6 mb-2">Middle Name</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="middle_name"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Elwa"
                                           value="{{ old('middle_name') }}"/>
                                    @error('middle_name')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="email" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class=" fw-semibold fs-6 mb-2">Last Name</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="last_name"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Doe"
                                           value="{{ old('last_name') }}"/>
                                    @error('last_name')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="email" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->


                        <!--begin::Input group-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">Email</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="email" name="email" required
                                           class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="example@domain.com" value="{{ old('email') }}"/>
                                    @error('email')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="email" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">Password</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="password" name="password" required
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="******"/>
                                    @error('password')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="email" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">Gender</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select class="form-control form-control-solid mb-3 mb-lg-0" name="gender"
                                            required>
                                        <option>Select Gender</option>
                                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>
                                            Female
                                        </option>
                                        <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other
                                        </option>
                                    </select>
                                    @error('gender')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="email" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">Date of Birth</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="date" name="date_of_birth" required
                                           class="form-control form-control-solid mb-3 mb-lg-0"
                                           value="{{ old('date_of_birth') }}"/>
                                    @error('date_of_birth')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="email" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class=" fw-semibold fs-6 mb-2">Country</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="country" placeholder="United State"
                                           class="form-control form-control-solid mb-3 mb-lg-0"
                                           value="{{ old('country') }}"/>
                                    @error('country')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="email" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">User Type</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select class="form-control form-control-solid mb-3 mb-lg-0" name="user_type"
                                            required>
                                        <option>Select User Type</option>
                                        <option value="provider"
                                            {{ old('user_type') == 'provider' ? 'selected' : '' }}>
                                            Provider
                                        </option>
                                        <option value="nurse" {{ old('user_type') == 'nurse' ? 'selected' : '' }}>
                                            Nurse
                                        </option>
                                        <option value="maintenance"
                                            {{ old('user_type') == 'maintenance' ? 'selected' : '' }}>
                                            Maintenance
                                        </option>
                                        <option value="operation"
                                            {{ old('user_type') == 'operation' ? 'selected' : '' }}>
                                            Operation
                                        </option>
                                    </select>
                                    @error('user_type')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="email" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">Speciality</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select class="form-control form-control-solid mb-3 mb-lg-0" name="speciality_id"
                                            required>
                                        <option>Select Speciality</option>
                                        @foreach (\App\Models\ListOption::where('list_id', 'Specialty')->get() as $speciality_details)
                                            <option value="{{ $speciality_details->id }}"
                                                {{ old('specialty_id') == $speciality_details->id ? 'selected' : '' }}>
                                                {{ $speciality_details->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('speciality_id')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="email" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">Facilities</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select
                                        class="form-control form-control-solid mb-3 mb-lg-0 js-example-basic-multiple"
                                        multiple="multiple" name="facilities[]"
                                        required>
                                        <option value="">Select Facilities</option>
                                        @foreach (\App\Models\Facility::all() as $data)
                                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('gender')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="email" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fw-semibold fs-6 mb-2">Role</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select class="form-control form-control-solid mb-3 mb-lg-0" name="role_id">
                                        <option value="">Select Role</option>
                                        @foreach (\App\Models\Role::all() as $data)
                                            <option value="{{ $data->id }}">{{ $data->role_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('role_id')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="email" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->

                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">
                                Discard
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection
@section('custom_js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('.js-example-basic-multiple').select2();
        });
    </script>
@endsection
