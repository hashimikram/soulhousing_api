@php use App\Models\User; @endphp
@php use App\Models\ListOption; @endphp
@php use App\Models\Facility; @endphp
@extends('backend.layout.master')
@section('breadcrumb_title', 'Encounters List')
@section('breadcrumb_li_1', 'Home')
@section('breadcrumb_li_2', 'Encounters - Manage')
@section('breadcrumb_href', route('dashboard'))
@section('encounter_management_li', 'here show')
@section('encounter_a', 'active')
@section('page_title', 'All Encounters')
@section('content')
    <div id="kt_app_content_container" class="app-container">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Filter Options</span>
                </h3>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('encounters.index') }}">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-10">
                                <label class="form-label fs-6 fw-semibold">Patient First Name:</label>
                                <input type="text" name="first_name" autocomplete="off" placeholder="First Name"
                                       class="form-control" value="{{ request('first_name') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-10">
                                <label class="form-label fs-6 fw-semibold">Patient Last Name:</label>
                                <input type="text" name="last_name" autocomplete="off" placeholder="Last Name"
                                       class="form-control" value="{{ request('last_name') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-10">
                                <label class="form-label fs-6 fw-semibold">Providers:</label>
                                <select name="provider" class="form-select form-select-solid fw-bold"
                                        data-kt-select2="true"
                                        data-placeholder="Select option" data-allow-clear="true">
                                    <option value="">Select Provider</option>
                                    @foreach (User::whereNot('user_type','super_admin')->get() as $providers)
                                        <option value="{{ $providers->id }}"
                                            {{ request('provider') == $providers->id ? 'selected' : '' }}>
                                            {{ $providers->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-10">
                                <label class="form-label fs-6 fw-semibold">Speciality:</label>
                                <select name="specialty" class="form-select form-select-solid fw-bold"
                                        data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true">
                                    <option value="">Select Speciality</option>
                                    @foreach (ListOption::where('list_id', 'Specialty')->get() as $speciality)
                                        <option value="{{ $speciality->id }}"
                                            {{ request('specialty') == $speciality->id ? 'selected' : '' }}>
                                            {{ $speciality->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-10">
                                <label class="form-label fs-6 fw-semibold">Facility:</label>
                                <select name="facility" class="form-select form-select-solid fw-bold"
                                        data-kt-select2="true"
                                        data-placeholder="Select option" data-allow-clear="true">
                                    <option value="">Select Facility</option>
                                    @foreach (Facility::all() as $facility)
                                        <option value="{{ $facility->id }}"
                                            {{ request('facility') == $facility->id ? 'selected' : '' }}>
                                            {{ $facility->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-10">
                                <label class="form-label fs-6 fw-semibold">Start Date:</label>
                                <input type="date" name="start_date" autocomplete="off" class="form-control"
                                       value="{{ request('start_date') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-10">
                                <label class="form-label fs-6 fw-semibold">End Date:</label>
                                <input type="date" name="end_date" autocomplete="off" class="form-control"
                                       value="{{ request('end_date') }}">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                </form>
            </div>
        </div>
        <!--begin::Card-->
        <div class="card">
            <div class="card-header border-0 pt-6">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Encounters List</span>
                    <span class="text-muted fw-semibold fs-7">There is Total {{ count($encounters) }} Visible</span>
                </h3>
            </div>

            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <!--begin::Export-->
                    <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_export_users">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr078.svg-->
                        <span class="svg-icon svg-icon-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.3" x="12.75" y="4.25" width="12" height="2" rx="1"
                                      transform="rotate(90 12.75 4.25)" fill="currentColor"/>
                                <path
                                    d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z"
                                    fill="currentColor"/>
                                <path opacity="0.3"
                                      d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z"
                                      fill="currentColor"/>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->Export
                    </button>
                    <!--end::Export-->
                </div>
                <!--end::Toolbar-->
                <!--begin::Group actions-->
                <div class="d-flex justify-content-end align-items-center d-none" data-kt-user-table-toolbar="selected">
                    <div class="fw-bold me-5">
                        <span class="me-2" data-kt-user-table-select="selected_count"></span>Selected
                    </div>
                    <button type="button" class="btn btn-danger" data-kt-user-table-select="delete_selected">
                        Delete Selected
                    </button>
                </div>
                <!--end::Group actions-->
                <!--begin::Modal - Adjust Balance-->
                <div class="modal fade" id="kt_modal_export_users" tabindex="-1" aria-hidden="true">
                    <!--begin::Modal dialog-->
                    <div class="modal-dialog modal-dialog-centered mw-650px">
                        <!--begin::Modal content-->
                        <div class="modal-content">
                            <!--begin::Modal header-->
                            <div class="modal-header">
                                <!--begin::Modal title-->
                                <h2 class="fw-bold">Export Encounter</h2>
                                <!--end::Modal title-->
                                <!--begin::Close-->
                                <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                     data-kt-users-modal-action="close">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                    <span class="svg-icon svg-icon-1">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
                                                  rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"/>
                                            <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                                  transform="rotate(45 7.41422 6)" fill="currentColor"/>
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </div>
                                <!--end::Close-->
                            </div>
                            <!--end::Modal header-->
                            <!--begin::Modal body-->
                            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                <!--begin::Form-->
                                <form id="kt_modal_export_users_form" class="form"
                                      action="{{ route('export.encounter') }}" method="POST">
                                    @csrf
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-10">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold form-label mb-2">Select Export
                                            Format:</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select name="format" data-control="select2" data-placeholder="Select a format"
                                                data-hide-search="true" required
                                                class="form-select form-select-solid fw-bold">
                                            <option value="">Select Format</option>
                                            <option value="excel">Excel</option>
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Actions-->
                                    <div class="text-center">
                                        <button type="reset" class="btn btn-light me-3"
                                                data-kt-users-modal-action="cancel">
                                            Discard
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <span class="indicator-label">Submit</span>
                                        </button>
                                    </div>
                                    <!--end::Actions-->
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Modal body-->
                        </div>
                        <!--end::Modal content-->
                    </div>
                    <!--end::Modal dialog-->
                </div>
                <!--end::Modal - New Card-->
            </div>
            <!--end::Card toolbar-->

            <div class="card-body py-4">
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-5 myTable">
                        <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-125px">Facility</th>
                            <th class="min-w-125px">Provider</th>
                            <th class="min-w-125px">Patient</th>
                            <th class="min-w-125px">Encounter Date</th>
                            <th class="min-w-125px">Encounter Type</th>
                            <th class="min-w-125px">Specialty</th>
                            <th class="min-w-125px">Reason</th>
                            <th class="min-w-125px">Status</th>
                            <th class="min-w-125px">Action</th>

                        </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-semibold">
                        @foreach ($encounters as $encounter)
                            <tr>
                                <td>
                                    @if ($encounter->facility)
                                        {{ $encounter->facility->name }}
                                    @else
                                        Facility not found
                                    @endif
                                </td>
                                <td class="align-items-center">
                                    <div class="d-flex align-items-center me-3">
                                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-2">
                                            <a href="{{ route('user.show', $encounter->provider->id) }}">
                                                <div class="symbol-label">
                                                    <img src="{{ image_url($encounter->provider->userDetail->image) }}"
                                                         alt="{{ $encounter->provider->name ?? 'N/A' }}"
                                                         class="w-100"/>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <a href="{{ route('user.show', $encounter->provider->id) }}"
                                               class="text-gray-800 text-hover-primary mb-1">
                                                {{ $encounter->provider->name ?? 'N/A' }}
                                                {{ $encounter->provider->userDetail->last_name ?? 'N/A' }}
                                            </a>
                                            <span>{{ $encounter->provider->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-items-center">
                                    <div class="d-flex align-items-center me-3">
                                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-2">
                                            <a href="{{ route('user.show', $encounter->patient->id) }}">
                                                <div class="symbol-label">
                                                    <img src="{{ image_url($encounter->patient->profile_pic) }}"
                                                         alt="{{ $encounter->patient->first_name ?? 'N/A' }}"
                                                         class="w-100"/>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <a href="{{ route('user.show', $encounter->patient->id) }}"
                                               class="text-gray-800 text-hover-primary mb-1">
                                                {{ $encounter->patient->first_name ?? 'N/A' }}
                                                {{ $encounter->patient->last_name ?? 'N/A' }}
                                            </a>
                                            <span>{{ $encounter->patient->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ formatDate($encounter->encounter_date) }}</td>
                                <td>
                                    @if ($encounter->encounterType)
                                        {{ $encounter->encounterType->title }}
                                    @else
                                        Encounter type not found
                                    @endif
                                </td>
                                <td>
                                    @if ($encounter->specialty_type)
                                        {{ $encounter->specialty_type->title }}
                                    @else
                                        Specialty not found
                                    @endif
                                </td>
                                <td>{{ $encounter->reason ?? 'N/A' }}</td>
                                <td>{!! $encounter->status == '1'
                                        ? '<span class="badge badge-light-success">Signed</span>'
                                        : '<span class="badge badge-light-warning">Un-Signed</span>' !!}</td>
                                <td>
                                    <a href="{{ route('encounter.pdf', $encounter->id) }}" target="_blank"
                                       class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    <a href="{{ route('encounter.details', $encounter->id) }}"
                                       class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"><i
                                            class="las la-info-circle"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--end::Card-->
    </div>
@endsection
