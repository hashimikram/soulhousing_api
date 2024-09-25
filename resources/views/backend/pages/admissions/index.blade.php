@php use App\Models\Facility;use App\Models\User; @endphp
@extends('backend.layout.master')
@section('breadcrumb_title', 'Admissions List')
@section('breadcrumb_li_1', 'Home')
@section('breadcrumb_li_2', 'Admissions Management - Admissions')
@section('breadcrumb_href', route('dashboard'))
@section('admission_li', 'here show')
@section('admission_a', 'active')
@section('page_title', 'All Admissions')
@section('content')
    <div id="kt_app_content_container" class="app-container">
        <!--begin::Card-->
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Filter Options</span>
                </h3>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admissions.index') }}">
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
                                <label class="form-label fs-6 fw-semibold">From:</label>
                                <input type="date" name="start_date" autocomplete="off" class="form-control"
                                       value="{{ request('start_date') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-10">
                                <label class="form-label fs-6 fw-semibold">To:</label>
                                <input type="date" name="end_date" autocomplete="off" class="form-control"
                                       value="{{ request('end_date') }}">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                </form>
            </div>
        </div>
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <h3 class="card-label">All Admissions</h3>
                </div>
                <!--begin::Card title-->

            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body py-4">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="">
                    <!--begin::Table head-->
                    <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-125px">Facility</th>
                        <th class="min-w-125px">Provider</th>
                        <th class="min-w-125px">Patient</th>
                        <th class="min-w-125px">Admission Date</th>
                        <th class="min-w-125px">Info</th>
                        <th class="min-w-125px">Status</th>

                    </tr>
                    <!--end::Table row-->
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody class="text-gray-600 fw-semibold">
                    <!--begin::Table row-->
                    @foreach ($admissions as $key => $data)
                        <tr>

                            <td>{{ $data->facility->name ?? 'N/A' }}</td>
                            <td class="align-items-center">
                                <div class="d-flex align-items-center me-3">
                                    <div class="symbol symbol-circle symbol-50px overflow-hidden me-2">
                                        <a href="{{ route('user.show', $data->staff->id) }}">
                                            <div class="symbol-label">
                                                <img src="{{ image_url($data->staff->userDetail->image) }}"
                                                     alt="{{ $data->staff->name ?? 'N/A' }}"
                                                     class="w-100"/>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <a href="{{ route('user.show', $data->staff->id) }}"
                                           class="text-gray-800 text-hover-primary mb-1">
                                            {{ $data->staff->name ?? 'N/A' }}
                                            {{ $data->staff->userDetail->last_name ?? 'N/A' }}
                                        </a>
                                        <span>{{ $data->staff->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="align-items-center">
                                <div class="d-flex align-items-center me-3">
                                    <div class="symbol symbol-circle symbol-50px overflow-hidden me-2">
                                        <a href="#">
                                            <div class="symbol-label">
                                                <img src="{{ image_url($data->patient->profile_pic) }}"
                                                     alt="{{ $data->patient->first_name ?? 'N/A' }}"
                                                     class="w-100"/>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <a href="#"
                                           class="text-gray-800 text-hover-primary mb-1">
                                            {{ $data->patient->first_name ?? 'N/A' }}
                                            {{ $data->patient->last_name ?? 'N/A' }}
                                        </a>
                                        <span>{{ $data->patient->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ date('d-M-Y',strtotime($data->admission_date)) }}</td>

                            <td>
                                <div class="d-flex flex-column">
                                    <span class="text-gray-800 fw-bolder">Floor: {{$data->floor_name ?? 'N/A'}}</span>
                                    <span class="text-gray-800 fw-bolder">Room: {{$data->room_name ?? 'N/A'}}</span>
                                    <span class="text-gray-800 fw-bolder">Bed: {{$data->bed_name ?? 'N/A'}}</span>
                                </div>
                            </td>
                            <td>
                                <span
                                    class="badge badge-light-{{ $data->status == '1' ? 'success' : 'danger' }} fw-bolder">
                                    {{ $data->status == '1' ? 'Admitted' : 'Discharged' }}
                                </span>

                        </tr>
                    @endforeach

                    <!--end::Table row-->
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>

@endsection
