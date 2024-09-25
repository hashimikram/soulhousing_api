@extends('backend.layout.master')
@section('breadcrumb_title', 'Website Setup')
@section('breadcrumb_li_1', 'Home')
@section('breadcrumb_li_2', 'Website Management - Website')
@section('breadcrumb_href', route('dashboard'))
@section('website_setup_li', 'here show')
@section('website_setup_a', 'active')
@section('page_title', 'Website Setup')
@section('content')
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Card-->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Website Info</h3>
            </div>
            <!--begin::Card body-->
            <div class="card-body py-4">
                <!--begin::Form-->
                <form id="kt_modal_add_role_form"
                      class="form fv-plugins-bootstrap5 fv-plugins-framework kt_add_data_modal"
                      action="{{ route('website-setup.store') }}" method="POST">
                    @csrf
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_role_scroll">
                        <!-- Platform Name -->
                        <div class="fv-row mb-10 fv-plugins-icon-container">
                            <label class="fs-5 fw-bold form-label mb-2">
                                <span class="required">Platform Name</span>
                            </label>
                            <input class="form-control form-control-solid"
                                   placeholder="Platform Name"
                                   value="{{ old('platform_name', $settings['platform_name'] ?? '') }}"
                                   name="platform_name">
                            @error('platform_name')
                            <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Platform Address -->
                        <div class="fv-row mb-10 fv-plugins-icon-container">
                            <label class="fs-5 fw-bold form-label mb-2">
                                <span class="required">Platform Address</span>
                            </label>
                            <input class="form-control form-control-solid"
                                   placeholder="Platform Address"
                                   value="{{ old('platform_address', $settings['platform_address'] ?? '') }}"
                                   name="platform_address">
                            @error('platform_address')
                            <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Platform Contact -->
                        <div class="fv-row mb-10 fv-plugins-icon-container">
                            <label class="fs-5 fw-bold form-label mb-2">
                                <span class="required">Platform Contact</span>
                            </label>
                            <input class="form-control form-control-solid"
                                   placeholder="Platform Contact"
                                   value="{{ old('platform_contact', $settings['platform_contact'] ?? '') }}"
                                   name="platform_contact">
                            @error('platform_contact')
                            <div class="fv-plugins-message-container invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">Submit</span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>

@endsection
