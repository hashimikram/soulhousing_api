@extends('backend.layout.master')
@section('breadcrumb_title','Create Role')
@section('breadcrumb_li_1','Home')
@section('breadcrumb_li_2','Roles Management - Roles')
@section('breadcrumb_href', route('dashboard'))
@section('roles_management_li', 'here show')
@section('roles_a', 'active')
@section('page_title','Create Role')
@section('content')
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Card-->
        <div class="card">

            <!--begin::Card body-->
            <div class="card-body py-4">
                <!--begin::Form-->
                <form id="kt_modal_add_role_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="#">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_role_scroll"
                    >
                        <!--begin::Input group-->
                        <div class="fv-row mb-10 fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="fs-5 fw-bold form-label mb-2">
                                <span class="required">Role name</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input class="form-control form-control-solid" placeholder="Enter a role name"
                                   name="role_name">
                            <!--end::Input-->
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Permissions-->
                        <div class="fv-row">
                            <!--begin::Label-->
                            <label class="fs-5 fw-bold form-label mb-2">Role Permissions</label>
                            <!--end::Label-->
                            <!--begin::Table wrapper-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5">
                                    <!--begin::Table body-->
                                    <tbody class="text-gray-600 fw-semibold">
                                    <!--begin::Table row-->
                                    <tr>
                                        <td class="text-gray-800">Users Management
                                        </td>
                                        <td>
                                            <!--begin::Checkbox-->
                                            <label class="form-check form-check-custom form-check-solid me-9">
                                                <input class="form-check-input" type="checkbox"
                                                       value="1" {{ in_array('1', old('permissions', [])) ? 'checked' : '' }}
                                                >
                                            </label>
                                            <!--end::Checkbox-->
                                        </td>
                                    </tr>
                                    <!--end::Table row-->
                                    <!--begin::Table row-->
                                    <tr>
                                        <td class="text-gray-800">Facility Management
                                        </td>
                                        <td>
                                            <!--begin::Checkbox-->
                                            <label class="form-check form-check-custom form-check-solid me-9">
                                                <input class="form-check-input" type="checkbox"
                                                       value="2" {{ in_array('2', old('permissions', [])) ? 'checked' : '' }}
                                                >
                                            </label>
                                            <!--end::Checkbox-->
                                        </td>
                                    </tr>
                                    <!--end::Table row-->
                                    <!--begin::Table row-->
                                    <tr>
                                        <td class="text-gray-800">Floors Management
                                        </td>
                                        <td>
                                            <!--begin::Checkbox-->
                                            <label class="form-check form-check-custom form-check-solid me-9">
                                                <input class="form-check-input" type="checkbox"
                                                       value="3" {{ in_array('3', old('permissions', [])) ? 'checked' : '' }}
                                                >
                                            </label>
                                            <!--end::Checkbox-->
                                        </td>
                                    </tr>
                                    <!--end::Table row-->
                                    <!--begin::Table row-->
                                    <tr>
                                        <td class="text-gray-800">Maintenance
                                        </td>
                                        <td>
                                            <!--begin::Checkbox-->
                                            <label class="form-check form-check-custom form-check-solid me-9">
                                                <input class="form-check-input" type="checkbox"
                                                       value="4" {{ in_array('4', old('permissions', [])) ? 'checked' : '' }}
                                                >
                                            </label>
                                            <!--end::Checkbox-->
                                        </td>
                                    </tr>
                                    <!--end::Table row-->
                                    <!--begin::Table row-->
                                    <tr>
                                        <td class="text-gray-800">Patient Management
                                        </td>
                                        <td>
                                            <!--begin::Checkbox-->
                                            <label class="form-check form-check-custom form-check-solid me-9">
                                                <input class="form-check-input" type="checkbox"
                                                       value="5" {{ in_array('5', old('permissions', [])) ? 'checked' : '' }}
                                                >
                                            </label>
                                            <!--end::Checkbox-->
                                        </td>
                                    </tr>
                                    <!--end::Table row-->
                                    <tr>
                                        <div class="row mt-3">
                                            <div class="col-md-12">

                                                <div class="form-check form-check-inline form-switch mb-3">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                           id="flexSwitchCheckDefault1"
                                                           name="permissions[]" value="add_patient"
                                                        {{ in_array('add_patient', old('permissions', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="flexSwitchCheckDefault1">Add
                                                        Patient</label>
                                                </div>

                                                <div class="form-check form-check-inline form-switch mb-3">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                           id="flexSwitchCheckDefault2"
                                                           name="permissions[]" value="bed_mapping"
                                                        {{ in_array('bed_mapping', old('permissions', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="flexSwitchCheckDefault2">Bed
                                                        Mapping</label>
                                                </div>


                                                <div class="form-check form-check-inline form-switch mb-5">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                           id="flexSwitchCheckDefault3"
                                                           name="permissions[]" value="maintenance"
                                                        {{ in_array('maintenance', old('permissions', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                           for="flexSwitchCheckDefault3">Maintenance</label>
                                                </div>
                                                <div class="form-check form-check-inline form-switch mb-5">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                           id="flexSwitchCheckDefault3"
                                                           name="permissions[]" value="operation"
                                                        {{ in_array('operation', old('permissions', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                           for="flexSwitchCheckDefault3">Operation</label>
                                                </div>
                                                <div class="form-check form-check-inline form-switch mb-5">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                           id="flexSwitchCheckDefault3"
                                                           name="permissions[]" value="video_calling"
                                                        {{ in_array('video_calling', old('permissions', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="flexSwitchCheckDefault3">Video
                                                        Calling</label>
                                                </div>
                                                <div class="form-check form-check-inline form-switch mb-5">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                           id="flexSwitchCheckDefault3"
                                                           name="permissions[]" value="summary"
                                                        {{ in_array('summary', old('permissions', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="flexSwitchCheckDefault3">Summary
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline form-switch mb-5">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                           id="flexSwitchCheckDefault3"
                                                           name="permissions[]" value="demographics"
                                                        {{ in_array('demographics', old('permissions', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="flexSwitchCheckDefault3">Demographics
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline form-switch mb-5">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                           id="flexSwitchCheckDefault3"
                                                           name="permissions[]" value="insurance"
                                                        {{ in_array('insurance', old('permissions', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="flexSwitchCheckDefault3">Isurance
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline form-switch mb-5">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                           id="flexSwitchCheckDefault3"
                                                           name="permissions[]" value="contact"
                                                        {{ in_array('contact', old('permissions', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="flexSwitchCheckDefault3">Contact
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline form-switch mb-5">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                           id="flexSwitchCheckDefault3"
                                                           name="permissions[]" value="admission"
                                                        {{ in_array('admission', old('permissions', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="flexSwitchCheckDefault3">Admission
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline form-switch mb-5">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                           id="flexSwitchCheckDefault3"
                                                           name="permissions[]" value="problems"
                                                        {{ in_array('problems', old('permissions', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="flexSwitchCheckDefault3">Problems
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline form-switch mb-5">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                           id="flexSwitchCheckDefault3"
                                                           name="permissions[]" value="allergies"
                                                        {{ in_array('allergies', old('permissions', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="flexSwitchCheckDefault3">Allergies
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline form-switch mb-5">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                           id="flexSwitchCheckDefault3"
                                                           name="permissions[]" value="medication"
                                                        {{ in_array('medication', old('permissions', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="flexSwitchCheckDefault3">Medication
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline form-switch mb-5">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                           id="flexSwitchCheckDefault3"
                                                           name="permissions[]" value="encounter"
                                                        {{ in_array('encounter', old('permissions', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="flexSwitchCheckDefault3">Encounter
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline form-switch mb-5">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                           id="flexSwitchCheckDefault3"
                                                           name="permissions[]" value="vitals"
                                                        {{ in_array('vitals', old('permissions', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="flexSwitchCheckDefault3">Vitals
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline form-switch mb-5">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                           id="flexSwitchCheckDefault3"
                                                           name="permissions[]" value="documents"
                                                        {{ in_array('documents', old('permissions', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="flexSwitchCheckDefault3">Documents
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline form-switch mb-5">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                           id="flexSwitchCheckDefault3"
                                                           name="permissions[]" value="incidents"
                                                        {{ in_array('incidents', old('permissions', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="flexSwitchCheckDefault3">Incidents
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </tr>
                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Label-->
                                        <td class="text-gray-800">Bed Mapping</td>
                                        <!--end::Label-->
                                        <!--begin::Options-->
                                        <td>
                                            <!--begin::Wrapper-->
                                            <div class="d-flex">
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                           value="bed_mapping_view"
                                                        {{ in_array('bed_mapping_view', old('permissions', [])) ? 'checked' : '' }}>
                                                    <span class="form-check-label">View</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                           value="insurance"
                                                        {{ in_array('assign_patient', old('permissions', [])) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Assign Patients</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </td>
                                        <!--end::Options-->
                                    </tr>
                                    <!--end::Table row-->
                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Label-->
                                        <td class="text-gray-800">Demographics</td>
                                        <!--end::Label-->
                                        <!--begin::Options-->
                                        <td>
                                            <!--begin::Wrapper-->
                                            <div class="d-flex">
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                           value="demographics"
                                                        {{ in_array('demographics', old('permissions', [])) ? 'checked' : '' }}>
                                                    <span class="form-check-label">View</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                           value="update_demographics"
                                                        {{ in_array('insurance', old('permissions', [])) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Update</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </td>
                                        <!--end::Options-->
                                    </tr>
                                    <!--end::Table row-->
                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Label-->
                                        <td class="text-gray-800">Insurance</td>
                                        <!--end::Label-->
                                        <!--begin::Options-->
                                        <td>
                                            <!--begin::Wrapper-->
                                            <div class="d-flex">
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                           value="insurance"
                                                        {{ in_array('insurance', old('permissions', [])) ? 'checked' : '' }}>
                                                    <span class="form-check-label">View</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                           value="create_insurance"
                                                        {{ in_array('insurance', old('permissions', [])) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Create</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                           value="update_insurance"
                                                        {{ in_array('insurance', old('permissions', [])) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Update</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </td>
                                        <!--end::Options-->
                                    </tr>
                                    <!--end::Table row-->
                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Label-->
                                        <td class="text-gray-800">Contact</td>
                                        <!--end::Label-->
                                        <!--begin::Options-->
                                        <td>
                                            <!--begin::Wrapper-->
                                            <div class="d-flex">
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                           value="contact"
                                                        {{ in_array('contact', old('permissions', [])) ? 'checked' : '' }}>
                                                    <span class="form-check-label">View</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                           value="create_contact"
                                                        {{ in_array('contact', old('permissions', [])) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Create</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                           value="update_contact"
                                                        {{ in_array('contact', old('permissions', [])) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Update</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </td>
                                        <!--end::Options-->
                                    </tr>
                                    <!--end::Table row-->
                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Label-->
                                        <td class="text-gray-800">Admissions</td>
                                        <!--end::Label-->
                                        <!--begin::Options-->
                                        <td>
                                            <!--begin::Wrapper-->
                                            <div class="d-flex">
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                           value="admission_view"
                                                        {{ in_array('admission_view', old('permissions', [])) ? 'checked' : '' }}>
                                                    <span class="form-check-label">View</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                           value="admission_add"
                                                        {{ in_array('admission_add', old('permissions', [])) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Create</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                           value="admission_discharge"
                                                        {{ in_array('admission_discharge', old('permissions', [])) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Discharge Patient</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </td>
                                        <!--end::Options-->
                                    </tr>
                                    <!--end::Table row-->
                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Label-->
                                        <td class="text-gray-800">Problems</td>
                                        <!--end::Label-->
                                        <!--begin::Options-->
                                        <td>
                                            <!--begin::Wrapper-->
                                            <div class="d-flex">
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                           value="problem_view"
                                                        {{ in_array('problem_view', old('permissions', [])) ? 'checked' : '' }}>
                                                    <span class="form-check-label">View</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                           value="problem_add"
                                                        {{ in_array('problem_add', old('permissions', [])) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Create</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                           value="problem_edit"
                                                        {{ in_array('problem_edit', old('permissions', [])) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Update</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </td>
                                        <!--end::Options-->
                                    </tr>
                                    <!--end::Table row-->
                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Label-->
                                        <td class="text-gray-800">Allergies</td>
                                        <!--end::Label-->
                                        <!--begin::Options-->
                                        <td>
                                            <!--begin::Wrapper-->
                                            <div class="d-flex">
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                           value="allergies_view"
                                                        {{ in_array('allergies_view', old('permissions', [])) ? 'checked' : '' }}>
                                                    <span class="form-check-label">View</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                           value="allergies_add"
                                                        {{ in_array('allergies_add', old('permissions', [])) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Create</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </td>
                                        <!--end::Options-->
                                    </tr>
                                    <!--end::Table row-->
                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Label-->
                                        <td class="text-gray-800">Medications</td>
                                        <!--end::Label-->
                                        <!--begin::Options-->
                                        <td>
                                            <!--begin::Wrapper-->
                                            <div class="d-flex">
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                           value="medication_view"
                                                        {{ in_array('medication_view', old('permissions', [])) ? 'checked' : '' }}>
                                                    <span class="form-check-label">View</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                           value="medication_add"
                                                        {{ in_array('medication_add', old('permissions', [])) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Create</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </td>
                                        <!--end::Options-->
                                    </tr>
                                    <!--end::Table row-->
                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Label-->
                                        <td class="text-gray-800">Encounters</td>
                                        <!--end::Label-->
                                        <!--begin::Options-->
                                        <td>
                                            <!--begin::Wrapper-->
                                            <div class="d-flex">
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                           value="encounter_add"
                                                        {{ in_array('encounter_add', old('permissions', [])) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Create</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                           value="encounter_edit"
                                                        {{ in_array('encounter_edit', old('permissions', [])) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Update</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                           value="encounter_details"
                                                        {{ in_array('encounter_details', old('permissions', [])) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Details</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                           value="view_pdf_file"
                                                        {{ in_array('view_pdf_file', old('permissions', [])) ? 'checked' : '' }}>
                                                    <span class="form-check-label">View PDF</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                           value="sign_encounter"
                                                        {{ in_array('sign_encounter', old('permissions', [])) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Sign Encounter</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </td>
                                        <!--end::Options-->
                                    </tr>
                                    <!--end::Table row-->
                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Label-->
                                        <td class="text-gray-800">Documents</td>
                                        <!--end::Label-->
                                        <!--begin::Options-->
                                        <td>
                                            <!--begin::Wrapper-->
                                            <div class="d-flex">
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                           value="document_view"
                                                        {{ in_array('document_view', old('permissions', [])) ? 'checked' : '' }}>
                                                    <span class="form-check-label">View</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                           value="document_add"
                                                        {{ in_array('document_add', old('permissions', [])) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Create</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                           value="document_preview"
                                                        {{ in_array('document_preview', old('permissions', [])) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Preview File</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </td>
                                        <!--end::Options-->
                                    </tr>
                                    <!--end::Table row-->

                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Label-->
                                        <td class="text-gray-800">Vitals</td>
                                        <!--end::Label-->
                                        <!--begin::Options-->
                                        <td>
                                            <!--begin::Wrapper-->
                                            <div class="d-flex">
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                           value="vital_view"
                                                        {{ in_array('vital_view', old('permissions', [])) ? 'checked' : '' }}>
                                                    <span class="form-check-label">View</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                           value="vital_add"
                                                        {{ in_array('vital_add', old('permissions', [])) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Create</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </td>
                                        <!--end::Options-->
                                    </tr>
                                    <!--end::Table row-->

                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Label-->
                                        <td class="text-gray-800">Medical Incident</td>
                                        <!--end::Label-->
                                        <!--begin::Options-->
                                        <td>
                                            <!--begin::Wrapper-->
                                            <div class="d-flex">
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                           value="view_medical_incident"
                                                        {{ in_array('view_medical_incident', old('permissions', [])) ? 'checked' : '' }}>
                                                    <span class="form-check-label">View</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                           value="create_medical_incident"
                                                        {{ in_array('create_medical_incident', old('permissions', [])) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Create</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </td>
                                        <!--end::Options-->
                                    </tr>
                                    <!--end::Table row-->

                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Label-->
                                        <td class="text-gray-800">Warning Letter</td>
                                        <!--end::Label-->
                                        <!--begin::Options-->
                                        <td>
                                            <!--begin::Wrapper-->
                                            <div class="d-flex">
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                           value="view_warning_letter"
                                                        {{ in_array('view_warning_letter', old('permissions', [])) ? 'checked' : '' }}>
                                                    <span class="form-check-label">View</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                           value="create_warning_letter"
                                                        {{ in_array('create_warning_letter', old('permissions', [])) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Create</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </td>
                                        <!--end::Options-->
                                    </tr>
                                    <!--end::Table row-->

                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Table wrapper-->
                        </div>
                        <!--end::Permissions-->
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

@section('custom_js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#kt_modal_add_user_form').on('submit', function (e) {
                var isChecked = $('input[name="permissions[]"]:checked').length > 0;
                if (!isChecked) {
                    e.preventDefault();
                    $('#permissions-error').show();
                } else {
                    $('#permissions-error').hide();
                }
            });
        });
    </script>
@endsection
