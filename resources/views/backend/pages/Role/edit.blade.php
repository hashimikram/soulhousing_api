@extends('backend.layout.master')
@section('breadcrumb_title', 'Edit Role')
@section('breadcrumb_li_1', 'Home')
@section('breadcrumb_li_2', 'Roles Management - Roles')
@section('breadcrumb_href', route('dashboard'))
@section('roles_management_li', 'here show')
@section('roles_a', 'active')
@section('page_title', 'Edit Role')
@section('content')
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Card-->
        <div class="card">

            <!--begin::Card body-->
            <div class="card-body py-4">
                <!--begin::Form-->
                <form id="kt_modal_add_role_form" class="form fv-plugins-bootstrap5 fv-plugins-framework"
                      action="{{ route('roles.update',$role->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_role_scroll">
                        <!--begin::Input group-->
                        <div class="fv-row mb-10 fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="fs-5 fw-bold form-label mb-2">
                                <span class="required">Role name</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input class="form-control form-control-solid" placeholder="Enter a role name"
                                   name="role_name" value="{{$role->role_name}}">
                            <!--end::Input-->
                            <div class="fv-plugins-message-container invalid-feedback"></div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Permissions-->
                        <div class="fv-row">
                            <!--begin::Label-->
                            <label class="fs-5 fw-bold form-label mb-2">Sub Admin Permissions</label>
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
                                                <input class="form-check-input" type="checkbox" name="permissions[]"

                                                       value="1"
                                                    {{ in_array('1',$permissions) ? 'checked' : '' }}>
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
                                                <input class="form-check-input" type="checkbox" name="permissions[]"

                                                       value="2"
                                                    {{ in_array('2',$permissions) ? 'checked' : '' }}>
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
                                                <input class="form-check-input" type="checkbox" name="permissions[]"

                                                       value="3"
                                                    {{ in_array('4',$permissions) ? 'checked' : '' }}>
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
                                                <input class="form-check-input" type="checkbox" name="permissions[]"

                                                       value="4"
                                                    {{ in_array('4',$permissions) ? 'checked' : '' }}>
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
                                                <input class="form-check-input" type="checkbox" name="permissions[]"

                                                       value="5"
                                                    {{ in_array('5',$permissions) ? 'checked' : '' }}>
                                            </label>
                                            <!--end::Checkbox-->
                                        </td>
                                    </tr>
                                    <!--end::Table row-->
                                    <!--begin::Table row-->
                                    <tr>
                                        <td class="text-gray-800">Operations
                                        </td>
                                        <td>
                                            <!--begin::Checkbox-->
                                            <label class="form-check form-check-custom form-check-solid me-9">
                                                <input class="form-check-input" type="checkbox" name="permissions[]"

                                                       value="6"
                                                    {{ in_array('6',$permissions) ? 'checked' : '' }}>
                                            </label>
                                            <!--end::Checkbox-->
                                        </td>
                                    </tr>
                                    <!--end::Table row-->
                                    <!--begin::Table row-->
                                    <tr>
                                        <td class="text-gray-800">Staff Management
                                        </td>
                                        <td>
                                            <!--begin::Checkbox-->
                                            <label class="form-check form-check-custom form-check-solid me-9">
                                                <input class="form-check-input" type="checkbox" name="permissions[]"

                                                       value="7"
                                                    {{ in_array('7',$permissions) ? 'checked' : '' }}>
                                            </label>
                                            <!--end::Checkbox-->
                                        </td>
                                    </tr>
                                    <!--end::Table row-->
                                    <!--begin::Table row-->
                                    <tr>
                                        <td class="text-gray-800">Encounters
                                        </td>
                                        <td>
                                            <!--begin::Checkbox-->
                                            <label class="form-check form-check-custom form-check-solid me-9">
                                                <input class="form-check-input" type="checkbox" name="permissions[]"

                                                       value="8"
                                                    {{ in_array('8',$permissions) ? 'checked' : '' }}>
                                            </label>
                                            <!--end::Checkbox-->
                                        </td>
                                    </tr>
                                    <!--end::Table row-->
                                    <!--begin::Table row-->
                                    <tr>
                                        <td class="text-gray-800">Website Setup
                                        </td>
                                        <td>
                                            <!--begin::Checkbox-->
                                            <label class="form-check form-check-custom form-check-solid me-9">
                                                <input class="form-check-input" type="checkbox" name="permissions[]"

                                                       value="9"
                                                    {{ in_array('9',$permissions) ? 'checked' : '' }}>
                                            </label>
                                            <!--end::Checkbox-->
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-gray-800">Scheduling
                                        </td>
                                        <td>
                                            <!--begin::Checkbox-->
                                            <label class="form-check form-check-custom form-check-solid me-9">
                                                <input class="form-check-input" type="checkbox" name="permissions[]"
                                                       checked
                                                       value="10"
                                                    {{ in_array('10', $permissions) ? 'checked' : '' }}>
                                            </label>
                                            <!--end::Checkbox-->
                                        </td>
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
                        <hr>
                        <!--begin::Permissions-->
                        <div class="fv-row">
                            <!--begin::Label-->
                            <label class="fs-5 fw-bold form-label mb-2">Permissions</label>
                            <!--end::Label-->
                            <!--begin::Table wrapper-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5">
                                    <!--begin::Table body-->
                                    <tbody class="text-gray-600 fw-semibold">
                                    <tr>
                                        <div class="container mt-3">
                                            <div class="row">
                                                <div class="col-md-3 mb-3">
                                                    <div class="form-check form-check-inline form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                               id="flexSwitchCheckDefault1" name="permissions[]"
                                                               value="add_patient"
                                                            {{ in_array('add_patient',$permissions) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                               for="flexSwitchCheckDefault1">Add Patient</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <div class="form-check form-check-inline form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                               id="flexSwitchCheckDefault2" name="permissions[]"
                                                               value="bed_mapping"
                                                            {{ in_array('bed_mapping',$permissions) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                               for="flexSwitchCheckDefault2">Bed Mapping</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <div class="form-check form-check-inline form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                               id="flexSwitchCheckDefault2" name="permissions[]"
                                                               value="scheduling"
                                                            {{ in_array('scheduling',$permissions) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                               for="flexSwitchCheckDefault2">Scheduling</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <div class="form-check form-check-inline form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                               id="flexSwitchCheckDefault3" name="permissions[]"
                                                               value="maintenance"
                                                            {{ in_array('maintenance',$permissions) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                               for="flexSwitchCheckDefault3">Maintenance</label>
                                                    </div>
                                                </div>


                                            </div>

                                            <div class="row">
                                                <div class="col-md-3 mb-3">
                                                    <div class="form-check form-check-inline form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                               role="switch" id="flexSwitchCheckDefault4"
                                                               name="permissions[]" value="operation"
                                                            {{ in_array('operation',$permissions) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                               for="flexSwitchCheckDefault4">Operation</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="form-check form-check-inline form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                               role="switch" id="flexSwitchCheckDefault5"
                                                               name="permissions[]" value="video_calling"
                                                            {{ in_array('video_calling',$permissions) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                               for="flexSwitchCheckDefault5">Video Calling</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <div class="form-check form-check-inline form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                               role="switch" id="flexSwitchCheckDefault6"
                                                               name="permissions[]" value="summary_tab"
                                                            {{ in_array('summary_tab',$permissions) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                               for="flexSwitchCheckDefault6">Summary</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <div class="form-check form-check-inline form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                               role="switch" id="flexSwitchCheckDefault7"
                                                               name="permissions[]" value="demographics_tab"
                                                            {{ in_array('demographics_tab',$permissions) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                               for="flexSwitchCheckDefault7">Demographics</label>
                                                    </div>
                                                </div>


                                            </div>

                                            <div class="row">
                                                <div class="col-md-3 mb-3">
                                                    <div class="form-check form-check-inline form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                               role="switch" id="flexSwitchCheckDefault8"
                                                               name="permissions[]" value="insurance_tab"
                                                            {{ in_array('insurance_tab',$permissions) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                               for="flexSwitchCheckDefault8">Insurance</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="form-check form-check-inline form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                               role="switch" id="flexSwitchCheckDefault9"
                                                               name="permissions[]" value="contact_tab"
                                                            {{ in_array('contact_tab',$permissions) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                               for="flexSwitchCheckDefault9">Contact</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <div class="form-check form-check-inline form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                               role="switch" id="flexSwitchCheckDefault10"
                                                               name="permissions[]" value="admission_tab"
                                                            {{ in_array('admission_tab',$permissions) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                               for="flexSwitchCheckDefault10">Admission</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <div class="form-check form-check-inline form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                               role="switch" id="flexSwitchCheckDefault11"
                                                               name="permissions[]" value="problems"
                                                            {{ in_array('problems',$permissions) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                               for="flexSwitchCheckDefault11">Problems</label>
                                                    </div>
                                                </div>


                                            </div>

                                            <div class="row">
                                                <div class="col-md-3 mb-3">
                                                    <div class="form-check form-check-inline form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                               role="switch" id="flexSwitchCheckDefault12"
                                                               name="permissions[]" value="allergies"
                                                            {{ in_array('allergies',$permissions) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                               for="flexSwitchCheckDefault12">Allergies</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="form-check form-check-inline form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                               role="switch" id="flexSwitchCheckDefault13"
                                                               name="permissions[]" value="medication"
                                                            {{ in_array('medication',$permissions) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                               for="flexSwitchCheckDefault13">Medication</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <div class="form-check form-check-inline form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                               role="switch" id="flexSwitchCheckDefault14"
                                                               name="permissions[]" value="encounter"
                                                            {{ in_array('encounter',$permissions) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                               for="flexSwitchCheckDefault14">Encounter</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <div class="form-check form-check-inline form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                               role="switch" id="flexSwitchCheckDefault15"
                                                               name="permissions[]" value="vitals_tab"
                                                            {{ in_array('vitals_tab',$permissions) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                               for="flexSwitchCheckDefault15">Vitals</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <div class="form-check form-check-inline form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                               role="switch" id="flexSwitchCheckDefault15"
                                                               name="permissions[]" value="warning_letter_tab"
                                                            {{ in_array('warning_letter_tab',$permissions) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                               for="flexSwitchCheckDefault15">Warning Letter</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <div class="form-check form-check-inline form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                               role="switch" id="flexSwitchCheckDefault15"
                                                               name="permissions[]" value="medical_incident_tab"
                                                            {{ in_array('medical_incident_tab',$permissions) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                               for="flexSwitchCheckDefault15">Medical Incident</label>
                                                    </div>
                                                </div>


                                            </div>

                                            <div class="row">
                                                <div class="col-md-3 mb-3">
                                                    <div class="form-check form-check-inline form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                               role="switch" id="flexSwitchCheckDefault16"
                                                               name="permissions[]" value="documents_tab"
                                                            {{ in_array('documents_tab',$permissions) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                               for="flexSwitchCheckDefault16">Documents</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="form-check form-check-inline form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                               role="switch" id="flexSwitchCheckDefault17"
                                                               name="permissions[]" value="incidents"
                                                            {{ in_array('incidents',$permissions) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                               for="flexSwitchCheckDefault17">Incidents</label>
                                                    </div>
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
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]" value="bed_mapping_view"
                                                        {{ in_array('bed_mapping_view',$permissions) ? 'checked' : '' }}>
                                                    <span class="form-check-label">View</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]" value="insurance"
                                                        {{ in_array('assign_patient',$permissions) ? 'checked' : '' }}>
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
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]" value="demographics"
                                                        {{ in_array('demographics',$permissions) ? 'checked' : '' }}>
                                                    <span class="form-check-label">View</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]" value="update_demographics"
                                                        {{ in_array('insurance',$permissions) ? 'checked' : '' }}>
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
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]" value="insurance_table"
                                                        {{ in_array('insurance_table',$permissions) ? 'checked' : '' }}>
                                                    <span class="form-check-label">View</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]" value="insurance_add_button"
                                                        {{ in_array('insurance_add_button',$permissions) ? 'checked' : '' }}>
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
                                        <td class="text-gray-800">Contact</td>
                                        <!--end::Label-->
                                        <!--begin::Options-->
                                        <td>
                                            <!--begin::Wrapper-->
                                            <div class="d-flex">
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]" value="contact"
                                                        {{ in_array('contact',$permissions) ? 'checked' : '' }}>
                                                    <span class="form-check-label">View</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]" value="create_contact"
                                                        {{ in_array('contact',$permissions) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Create</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]" value="update_contact"
                                                        {{ in_array('contact',$permissions) ? 'checked' : '' }}>
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
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]" value="admission_table"
                                                        {{ in_array('admission_table',$permissions) ? 'checked' : '' }}>
                                                    <span class="form-check-label">View</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]" value="admission_add_button"
                                                        {{ in_array('admission_add_button',$permissions) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Add</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]" value="admission_action_col"
                                                        {{ in_array('admission_action_col',$permissions) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Discharge Patient</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]" value="admission_history_table"
                                                        {{ in_array('admission_history_table',$permissions) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Admission History</span>
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
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]" value="problem_view"
                                                        {{ in_array('problem_view',$permissions) ? 'checked' : '' }}>
                                                    <span class="form-check-label">View</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]" value="problem_add"
                                                        {{ in_array('problem_add',$permissions) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Create</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]" value="problem_edit"
                                                        {{ in_array('problem_edit',$permissions) ? 'checked' : '' }}>
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
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]" value="allergies_view"
                                                        {{ in_array('allergies_view',$permissions) ? 'checked' : '' }}>
                                                    <span class="form-check-label">View</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]" value="allergies_add"
                                                        {{ in_array('allergies_add',$permissions) ? 'checked' : '' }}>
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
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]" value="medication_view"
                                                        {{ in_array('medication_view',$permissions) ? 'checked' : '' }}>
                                                    <span class="form-check-label">View</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]" value="medication_add"
                                                        {{ in_array('medication_add',$permissions) ? 'checked' : '' }}>
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
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]" value="encounter_add"
                                                        {{ in_array('encounter_add',$permissions) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Create</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]" value="encounter_edit"
                                                        {{ in_array('encounter_edit',$permissions) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Update</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]" value="encounter_details"
                                                        {{ in_array('encounter_details',$permissions) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Details</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]" value="view_pdf_file"
                                                        {{ in_array('view_pdf_file',$permissions) ? 'checked' : '' }}>
                                                    <span class="form-check-label">View PDF</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]" value="sign_encounter"
                                                        {{ in_array('sign_encounter',$permissions) ? 'checked' : '' }}>
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
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]" value="document_table_view"
                                                        {{ in_array('document_table_view',$permissions) ? 'checked' : '' }}>
                                                    <span class="form-check-label">View</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]" value="document_add_button"
                                                        {{ in_array('document_add_button',$permissions) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Create</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]"
                                                           value="document_table_action_col"
                                                        {{ in_array('document_table_action_col',$permissions) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Action</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]"
                                                           value="document_table_edit_button"
                                                        {{ in_array('document_table_edit_button',$permissions) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Edit</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]"
                                                           value="document_delete_button"
                                                        {{ in_array('document_delete_button',$permissions) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Edit</span>
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
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]" value="vitals_table_view"
                                                        {{ in_array('vitals_table_view',$permissions) ? 'checked' : '' }}>
                                                    <span class="form-check-label">View</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]" value="vitals_add_button"
                                                        {{ in_array('vitals_add_button',$permissions) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Create</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]" value="vitals_table_edit_button"
                                                        {{ in_array('vitals_table_edit_button',$permissions) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Edit</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]" value="vitals_table_edit_button"
                                                        {{ in_array('vitals_table_edit_button',$permissions) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Delete</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]" value="vitals_table_action"
                                                        {{ in_array('vitals_table_action',$permissions) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Action</span>
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
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]" value="medical_table"
                                                        {{ in_array('medical_table',$permissions) ? 'checked' : '' }}>
                                                    <span class="form-check-label">View</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]" value="medical_add_button"
                                                        {{ in_array('medical_add_button',$permissions) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Create</span>
                                                </label>
                                                <!--end::Checkbox-->

                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]" value="medical_preview_col"
                                                        {{ in_array('medical_preview_col',$permissions) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Preview</span>
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
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]"
                                                           value="warning_letter_table_view"
                                                        {{ in_array('warning_letter_table_view',$permissions) ? 'checked' : '' }}>
                                                    <span class="form-check-label">View</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]"
                                                           value="warning_letter_add_button"
                                                        {{ in_array('warning_letter_add_button',$permissions) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Create</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]"
                                                           value="warning_letter_preview_col"
                                                        {{ in_array('warning_letter_preview_col',$permissions) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Preview</span>
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
                                        <td class="text-gray-800">Setting</td>
                                        <!--end::Label-->
                                        <!--begin::Options-->
                                        <td>
                                            <!--begin::Wrapper-->
                                            <div class="d-flex">
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]" value="setting"
                                                        {{ in_array('setting',$permissions) ? 'checked' : '' }}>
                                                    <span class="form-check-label">View</span>
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
            $('#kt_modal_add_role_form').on('submit', function (e) {
                var isChecked = $('input[name="permissions[]"]:checked').length > 0;
                if (!isChecked) {
                    e.preventDefault();
                    alert('Atleast Check One Permission');
                } else {
                    $('#permissions-error').hide();
                }
            });
        });
    </script>
@endsection
