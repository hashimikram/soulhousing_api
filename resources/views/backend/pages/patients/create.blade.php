@extends('backend.layout.master')
@section('breadcrumb_title', 'Create Patient')
@section('breadcrumb_li_1', 'Home')
@section('breadcrumb_li_2', 'Patients Management - Create Patient')
@section('breadcrumb_href', route('dashboard'))
@section('patients_management_li', 'here show')
@section('patients_a', 'active')
@section('page_title', 'Create Patient')
@section('content')
    <form id="kt_modal_add_user_form" class="form" action="{{ route('patients.store') }}" method="POST"
          enctype="multipart/form-data">
        @csrf
        <div id="kt_app_content_container" class="app-container">
            <!--begin::Card-->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Patient Information</h3>
                </div>
                <!--begin::Card body-->
                <div class="card-body py-4">
                    <!--begin::Form-->
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll"
                         data-kt-scroll="true"
                         data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                         data-kt-scroll-dependencies="#kt_modal_add_user_header"
                         data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="d-block fw-semibold fs-6 mb-5">Profile Picture</label>
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
                        <div class="col-md-6">
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Provider</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select class="form-control form-control-solid mb-3 mb-lg-0" name="provider_id">
                                    <option value="">Select Provider</option>
                                    @foreach ($providers as $details)
                                        <option value="{{ $details->id }}"
                                            {{ old('provider_id') == $details->id ? 'selected' : '' }}>{{ $details->name }}
                                        </option>
                                    @endforeach

                                </select>
                                @error('provider_id')
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div data-field="gender" data-validator="notEmpty">{{ $message }}</div>
                                </div>
                                @enderror
                                <!--end::Input-->
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">Title</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="title" required
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Mr, Mrs"
                                           value="{{ old('title') }}">
                                    @error('title')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="title" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class=" required fw-semibold fs-6 mb-2">First Name</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="first_name" required
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="John"
                                           value="{{ old('first_name') }}">
                                    @error('first_name')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="first_name" data-validator="notEmpty">{{ $message }}</div>
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
                                    <label class="fw-semibold fs-6 mb-2">Middle Name</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="middle_name"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Elwa"
                                           value="{{ old('middle_name') }}">
                                    @error('middle_name')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="middle_name" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fw-semibold fs-6 mb-2">Last Name</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="last_name"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Doe"
                                           value="{{ old('last_name') }}">
                                    @error('last_name')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="last_name" data-validator="notEmpty">{{ $message }}</div>
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
                                    <label class=" fw-semibold fs-6 mb-2">Social Security No</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="social_security_no"
                                           class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="123-45-6789"
                                           value="{{ old('social_security_no') }}">
                                    @error('social_security_no')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="social_security_no" data-validator="notEmpty">
                                            {{ $message }}</div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class=" fw-semibold fs-6 mb-2">Medical Dependency</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="medical_dependency"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Specify"
                                           value="{{ old('medical_dependency') }}">
                                    @error('medical_dependency')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="medical_dependency" data-validator="notEmpty">
                                            {{ $message }}</div>
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
                                    <label class="required fw-semibold fs-6 mb-2">Medical ID</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="medical_number"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="123456789"
                                           value="{{ old('medical_number') }}" required>
                                    @error('medical_number')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="medical_number" data-validator="notEmpty">{{ $message }}
                                        </div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">Gender</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select class="form-control form-control-solid mb-3 mb-lg-0" name="gender" required>
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
                                        <div data-field="gender" data-validator="notEmpty">{{ $message }}</div>
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
                                    <label class=" fw-semibold fs-6 mb-2">Date of Birth</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="date" name="date_of_birth"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="01/01/1990"
                                           value="{{ old('date_of_birth') }}"/>
                                    @error('date_of_birth')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="date_of_birth" data-validator="notEmpty">{{ $message }}
                                        </div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class=" fw-semibold fs-6 mb-2">Age</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="age"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="30"
                                           value="{{ old('age') }}"/>
                                    @error('age')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="age" data-validator="notEmpty">{{ $message }}</div>
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
                                    <label class=" fw-semibold fs-6 mb-2">Language</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="language"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="English"
                                           value="{{ old('language') }}"/>
                                    @error('language')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="language" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fw-semibold fs-6 mb-2">Marital Status</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select class="required form-control form-control-solid mb-3 mb-lg-0"
                                            name="marital_status" required>
                                        <option>Select Marital Status</option>
                                        <option value="Married"
                                            {{ old('marital_status') == 'Married' ? 'selected' : '' }}>
                                            Married
                                        </option>
                                        <option value="Widow" {{ old('marital_status') == 'Widow' ? 'selected' : '' }}>
                                            Widow
                                        </option>
                                        <option
                                            value="Single" {{ old('marital_status') == 'Single' ? 'selected' : '' }}>
                                            Single
                                        </option>
                                        <option value="Divorced"
                                            {{ old('marital_status') == 'Divorced' ? 'selected' : '' }}>
                                            Divorced
                                        </option>
                                    </select>
                                    @error('marital_status')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="language" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class=" fw-semibold fs-6 mb-2">Referral Source 1</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select class="required form-control form-control-solid mb-3 mb-lg-0"
                                            name="referral_source_1">
                                        <option>Select Referral Source 1</option>
                                        <option value="Married"
                                            {{ old('referral_source_1') == 'Hospital' ? 'selected' : '' }}>
                                            Hospital
                                        </option>
                                        <option
                                            value="Widow" {{ old('referral_source_1') == 'Case Manager' ? 'selected' : '' }}>
                                            Case Manager
                                        </option>
                                    </select>
                                    @error('referral_source_1')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="referral_source_1" data-validator="notEmpty">{{ $message }}
                                        </div>
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
                                    <label class=" fw-semibold fs-6 mb-2">Referral Source 2</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="referral_source_2"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Source 2"
                                           value="{{ old('referral_source_2') }}"/>
                                    @error('referral_source_2')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="referral_source_2" data-validator="notEmpty">{{ $message }}
                                        </div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class=" fw-semibold fs-6 mb-2">Current Insurance</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="financial_class"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Class 1"
                                           value="{{ old('financial_class') }}"/>
                                    @error('financial_class')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="financial_class" data-validator="notEmpty">{{ $message }}
                                        </div>
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
                                    <label class=" fw-semibold fs-6 mb-2">Current Insurance No</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="financial_class_name"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Class Name"
                                           value="{{ old('financial_class_name') }}"/>
                                    @error('financial_class_name')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="financial_class_name" data-validator="notEmpty">
                                            {{ $message }}</div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class=" fw-semibold fs-6 mb-2">Doctor Name</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="doctor_name"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Dr. Smith"
                                           value="{{ old('doctor_name') }}"/>
                                    @error('doctor_name')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="doctor_name" data-validator="notEmpty">{{ $message }}</div>
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
                                    <label class=" fw-semibold fs-6 mb-2">NPI</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="npp"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="NPI Value"
                                           value="{{ old('npp') }}"/>
                                    @error('npp')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="npp" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class=" fw-semibold fs-6 mb-2">Auth</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="auth"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Auth Value"
                                           value="{{ old('auth') }}"/>
                                    @error('auth')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="auth" data-validator="notEmpty">{{ $message }}</div>
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
                                    <label class=" fw-semibold fs-6 mb-2">Employer</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="employer"
                                           class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="Company Name"
                                           value="{{ old('employer') }}"/>
                                    @error('employer')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="employer" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class=" fw-semibold fs-6 mb-2">Account No/Type</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="account_no"
                                           class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="Account No/Type"
                                           value="{{ old('account_no') }}"/>
                                    @error('account_no')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="occupation" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class=" fw-semibold fs-6 mb-2">Occupation</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="occupation"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Job Title"
                                           value="{{ old('occupation') }}"/>
                                    @error('occupation')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="occupation" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                        </div>

                        <!--begin::Input group-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class=" fw-semibold fs-6 mb-2">Adm.DX</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="adm_dx"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Adm.DX"
                                           value="{{ old('adm_dx') }}"/>
                                    @error('adm_dx')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="adm_dx" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class=" fw-semibold fs-6 mb-2">Resid Military</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="resid_military"
                                           class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="Resid Military"
                                           value="{{ old('resid_military') }}"/>
                                    @error('resid_military')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="resid_military" data-validator="notEmpty">{{ $message }}
                                        </div>
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
                                    <label class=" fw-semibold fs-6 mb-2">Service</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="service"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Service"
                                           value="{{ old('service') }}"/>
                                    @error('service')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="service" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->

                    </div>
                </div>
            </div>
            <!--begin::Card-->
            <br>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Contact Information</h3>
                </div>
                <!--begin::Card body-->
                <div class="card-body py-4">
                    <!--begin::Form-->
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll"
                         data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                         data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header"
                         data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">

                        <!--begin::Input group-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class=" fw-semibold fs-6 mb-2">Address</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="address"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Address"
                                           value="{{ old('address') }}"/>
                                    @error('address')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="country" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class=" fw-semibold fs-6 mb-2">City</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="city"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="City"
                                           value="{{ old('city') }}"/>
                                    @error('city')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="city" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class=" fw-semibold fs-6 mb-2">State</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select class="form-control form-control-solid mb-3 mb-lg-0" name="state">
                                        <option value="">select</option>
                                        <option value="1">Alaska</option>
                                        <option value="2">Alabama</option>
                                        <option value="3">Arkansas</option>
                                        <option value="4">American Samoa</option>
                                        <option value="5">Arizona</option>
                                        <option value="6">California</option>
                                        <option value="7">Colorado</option>
                                        <option value="8">Connecticut</option>
                                        <option value="9">District of Columbia</option>
                                        <option value="10">Delaware</option>
                                        <option value="11">Florida</option>
                                        <option value="12">Federated States of Micronesia</option>
                                        <option value="13">Georgia</option>
                                        <option value="14">Guam</option>
                                        <option value="15">Hawaii</option>
                                        <option value="16">Iowa</option>
                                        <option value="17">Idaho</option>
                                        <option value="18">Illinois</option>
                                        <option value="19">Indiana</option>
                                        <option value="20">Kansas</option>
                                        <option value="21">Kentucky</option>
                                        <option value="22">Louisiana</option>
                                        <option value="23">Massachusetts</option>
                                        <option value="24">Maryland</option>
                                        <option value="25">Maine</option>
                                        <option value="26">Marshall Islands</option>
                                        <option value="27">Michigan</option>
                                        <option value="28">Minnesota</option>
                                        <option value="29">Missouri</option>
                                        <option value="30">Northern Mariana Islands</option>
                                        <option value="31">Mississippi</option>
                                        <option value="32">Montana</option>
                                        <option value="33">North Carolina</option>
                                        <option value="34">North Dakota</option>
                                        <option value="35">Nebraska</option>
                                        <option value="36">New Hampshire</option>
                                        <option value="37">New Jersey</option>
                                        <option value="38">New Mexico</option>
                                        <option value="39">Nevada</option>
                                        <option value="40">New York</option>
                                        <option value="41">Ohio</option>
                                        <option value="42">Oklahoma</option>
                                        <option value="43">Oregon</option>
                                        <option value="44">Pennsylvania</option>
                                        <option value="45">Puerto Rico</option>
                                        <option value="46">Palau</option>
                                        <option value="47">Rhode Island</option>
                                        <option value="48">South Carolina</option>
                                        <option value="49">South Dakota</option>
                                        <option value="50">Tennessee</option>
                                        <option value="51">Texas</option>
                                        <option value="52">Utah</option>
                                        <option value="53">Virginia</option>
                                        <option value="54">Virgin Islands</option>
                                        <option value="55">Vermont</option>
                                        <option value="56">Washington</option>
                                        <option value="57">Wisconsin</option>
                                        <option value="58">West Virginia</option>
                                        <option value="59">Wyoming</option>
                                    </select>
                                    @error('state')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="state" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class=" fw-semibold fs-6 mb-2">Zip Code</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="zip_code"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Zip Code"
                                           value="{{ old('zip_code') }}"/>
                                    @error('zip_code')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="zip_code" data-validator="notEmpty">{{ $message }}</div>
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
                                    <input type="text" name="country"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Country"
                                           value="{{ old('country') }}"/>
                                    @error('country')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="country" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class=" fw-semibold fs-6 mb-2">Email</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="email" name="email"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Email"
                                           value="{{ old('email') }}"/>
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
                                    <label class=" fw-semibold fs-6 mb-2">Phone No</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="phone_no"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Phone No"
                                           value="{{ old('phone_no') }}"/>
                                    @error('phone_no')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="phone_no" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->

                    </div>

                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Other Contact</h3>
                </div>
                <!--begin::Card body-->
                <div class="card-body py-4">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll"
                         data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                         data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header"
                         data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">

                        <!--begin::Input group-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fw-semibold fs-6 mb-2">Name</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="other_contact_name"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Name"
                                           value="{{ old('other_contact_name') }}"/>
                                    @error('other_contact_name')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="name" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fw-semibold fs-6 mb-2">Address</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="other_contact_address"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Address"
                                           value="{{ old('other_contact_address') }}"/>
                                    @error('other_contact_address')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="address" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fw-semibold fs-6 mb-2">Country</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="other_contact_country"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Country"
                                           value="{{ old('other_contact_country') }}"/>
                                    @error('other_contact_country')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="country" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fw-semibold fs-6 mb-2">State</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select class="form-control form-control-solid mb-3 mb-lg-0"
                                            name="other_contact_state">
                                        <option value="">select</option>
                                        <option value="1">Alaska</option>
                                        <option value="2">Alabama</option>
                                        <option value="3">Arkansas</option>
                                        <option value="4">American Samoa</option>
                                        <option value="5">Arizona</option>
                                        <option value="6">California</option>
                                        <option value="7">Colorado</option>
                                        <option value="8">Connecticut</option>
                                        <option value="9">District of Columbia</option>
                                        <option value="10">Delaware</option>
                                        <option value="11">Florida</option>
                                        <option value="12">Federated States of Micronesia</option>
                                        <option value="13">Georgia</option>
                                        <option value="14">Guam</option>
                                        <option value="15">Hawaii</option>
                                        <option value="16">Iowa</option>
                                        <option value="17">Idaho</option>
                                        <option value="18">Illinois</option>
                                        <option value="19">Indiana</option>
                                        <option value="20">Kansas</option>
                                        <option value="21">Kentucky</option>
                                        <option value="22">Louisiana</option>
                                        <option value="23">Massachusetts</option>
                                        <option value="24">Maryland</option>
                                        <option value="25">Maine</option>
                                        <option value="26">Marshall Islands</option>
                                        <option value="27">Michigan</option>
                                        <option value="28">Minnesota</option>
                                        <option value="29">Missouri</option>
                                        <option value="30">Northern Mariana Islands</option>
                                        <option value="31">Mississippi</option>
                                        <option value="32">Montana</option>
                                        <option value="33">North Carolina</option>
                                        <option value="34">North Dakota</option>
                                        <option value="35">Nebraska</option>
                                        <option value="36">New Hampshire</option>
                                        <option value="37">New Jersey</option>
                                        <option value="38">New Mexico</option>
                                        <option value="39">Nevada</option>
                                        <option value="40">New York</option>
                                        <option value="41">Ohio</option>
                                        <option value="42">Oklahoma</option>
                                        <option value="43">Oregon</option>
                                        <option value="44">Pennsylvania</option>
                                        <option value="45">Puerto Rico</option>
                                        <option value="46">Palau</option>
                                        <option value="47">Rhode Island</option>
                                        <option value="48">South Carolina</option>
                                        <option value="49">South Dakota</option>
                                        <option value="50">Tennessee</option>
                                        <option value="51">Texas</option>
                                        <option value="52">Utah</option>
                                        <option value="53">Virginia</option>
                                        <option value="54">Virgin Islands</option>
                                        <option value="55">Vermont</option>
                                        <option value="56">Washington</option>
                                        <option value="57">Wisconsin</option>
                                        <option value="58">West Virginia</option>
                                        <option value="59">Wyoming</option>
                                    </select>
                                    @error('other_contact_state')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="state" data-validator="notEmpty">{{ $message }}</div>
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
                                    <label class="fw-semibold fs-6 mb-2">City</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="other_contact_city"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="City"
                                           value="{{ old('other_contact_city') }}"/>
                                    @error('other_contact_city')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="city" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fw-semibold fs-6 mb-2">Zip Code</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="other_contact_zip_code"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Zip Code"
                                           value="{{ old('other_contact_zip_code') }}"/>
                                    @error('other_contact_zip_code')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="zip_code" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fw-semibold fs-6 mb-2">Phone No</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="other_contact_phone_no"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Phone No"
                                           value="{{ old('other_contact_phone_no') }}"/>
                                    @error('other_contact_phone_no')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="phone_no" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fw-semibold fs-6 mb-2">Relationship</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="relationship"
                                           class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="Relationship"
                                           value="{{ old('relationship') }}"/>
                                    @error('relationship')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="relationship" data-validator="notEmpty">{{ $message }}
                                        </div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fw-semibold fs-6 mb-2">Cell</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="other_contact_cell"
                                           class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Cell"
                                           value="{{ old('other_contact_cell') }}"/>
                                    @error('other_contact_cell')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="cell" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                    <!--end::Input-->
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->

                    </div>

                </div>
            </div>
            <br>
            <div class="card">
                <button type="submit" class="btn btn-success">Add Patient</button>
            </div>
        </div>
    </form>

@endsection
