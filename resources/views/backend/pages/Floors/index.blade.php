@extends('backend.layout.master')
@section('breadcrumb_title','Floors List')
@section('breadcrumb_li_1','Home')
@section('breadcrumb_li_2','Floors Management - Floors')
@section('breadcrumb_href', route('dashboard'))
@section('floors_management_li', 'here show')
@section('floors_a', 'active')
@section('page_title','All Floors')
@section('content')
    <div
        id="kt_app_content_container"
        class="app-container"
    >
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div
                        class="d-flex align-items-center position-relative my-1"
                    >
                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                        <span
                            class="svg-icon svg-icon-1 position-absolute ms-6"
                        >
                            <svg
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                              <rect
                                  opacity="0.5"
                                  x="17.0365"
                                  y="15.1223"
                                  width="8.15546"
                                  height="2"
                                  rx="1"
                                  transform="rotate(45 17.0365 15.1223)"
                                  fill="currentColor"
                              />
                              <path
                                  d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                  fill="currentColor"
                              />
                            </svg>
                          </span>
                        <!--end::Svg Icon-->
                        <input
                            type="text"
                            data-kt-user-table-filter="search"
                            class="form-control form-control-solid w-250px ps-14"
                            placeholder="Search Facility"
                        />
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div
                        class="d-flex justify-content-end"
                        data-kt-user-table-toolbar="base"
                    >

                        <!--begin::Add user-->
                        <a href="{{route('floors.create')}}" class="btn btn-primary">
                              <span class="svg-icon svg-icon-2">
                              <svg
                                  width="24"
                                  height="24"
                                  viewBox="0 0 24 24"
                                  fill="none"
                                  xmlns="http://www.w3.org/2000/svg"
                              >
                                <rect
                                    opacity="0.5"
                                    x="11.364"
                                    y="20.364"
                                    width="16"
                                    height="2"
                                    rx="1"
                                    transform="rotate(-90 11.364 20.364)"
                                    fill="currentColor"
                                />
                                <rect
                                    x="4.36396"
                                    y="11.364"
                                    width="16"
                                    height="2"
                                    rx="1"
                                    fill="currentColor"
                                />
                              </svg>
                            </span> Add New Record
                        </a>

                        <!--end::Add user-->
                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body py-4">
                <!--begin::Table-->
                <table
                    class="table align-middle table-row-dashed fs-6 gy-5"
                    id="kt_table_users"
                >
                    <!--begin::Table head-->
                    <thead>
                    <!--begin::Table row-->
                    <tr
                        class="text-start text-muted fw-bold fs-7 text-uppercase gs-0"
                    >
                        <th class="w-10px pe-2">
                            <div
                                class="form-check form-check-sm form-check-custom form-check-solid me-3"
                            >
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    data-kt-check="true"
                                    data-kt-check-target="#kt_table_users .form-check-input"
                                    value="1"
                                />
                            </div>
                        </th>
                        <th class="min-w-125px">Facility Name</th>
                        <th class="min-w-125px">Floor Name</th>
                        <th class="min-w-125px">Total Rooms</th>
                        <th class="min-w-125px">Total Beds Count</th>
                        <th class="min-w-125px">Occupied Beds Count</th>
                        <th class="min-w-125px">Vacant Beds Count</th>
                        <th class="min-w-125px">Full Info</th>
                        <th class="text-end min-w-100px">Actions</th>
                    </tr>
                    <!--end::Table row-->
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody class="text-gray-600 fw-semibold">
                    <!--begin::Table row-->
                    @foreach ($data as $key => $floorData)
                        <tr>
                            <!--begin::Checkbox-->
                            <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="{{ $floorData['id'] }}"/>
                                </div>
                            </td>
                            <!--end::Checkbox-->
                            <td>{{ $floorData['facility_name'] }}</td>
                            <td>{{ $floorData['floor_name'] }}</td>
                            <td><span
                                    class="badge py-3 px-4 fs-7 badge-light-primary">{{ $floorData['total_rooms_count'] }}</span>
                            </td>
                            <td><span
                                    class="badge py-3 px-4 fs-7 badge-light-warning">{{ $floorData['total_beds_count'] }}</span>
                            </td>
                            <td><span
                                    class="badge py-3 px-4 fs-7 badge-light-danger">{{ $floorData['occupied_beds_count'] }}</span>
                            </td>
                            <td><span
                                    class="badge py-3 px-4 fs-7 badge-light-success">{{ $floorData['vacant_beds_count'] }}</span>
                            </td>
                            <td>
                                @foreach ($floorData['room_details'] as $roomDetail)
                                    <p>There are {{ $roomDetail['total_beds'] }} beds in {{ $roomDetail['room_name'] }}:
                                        {{ $roomDetail['occupied_beds'] }} occupied,
                                        {{ $roomDetail['pending_beds'] }} pending,
                                        {{ $roomDetail['vacant_beds'] }} vacant.
                                    </p>
                                @endforeach
                            </td>
                            <!--begin::Action=-->
                            <td class="text-end">
                                <div class="ms-2">
                                    <button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary"
                                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                    <span class="svg-icon svg-icon-5 m-0">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <rect x="10" y="10" width="4" height="4" rx="2" fill="currentColor"></rect>
                            <rect x="17" y="10" width="4" height="4" rx="2" fill="currentColor"></rect>
                            <rect x="3" y="10" width="4" height="4" rx="2" fill="currentColor"></rect>
                        </svg>
                    </span>
                                    </button>
                                    <div
                                        class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-150px py-4"
                                        data-kt-menu="true" style="">
                                        <div class="menu-item px-3">
                                            <a href="{{ route('floors.mapping', $floorData['id']) }}"
                                               class="menu-link px-3">Mapping</a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="{{ route('floors.edit', $floorData['id']) }}"
                                               class="menu-link px-3">Edit</a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link text-danger px-3 delete-button"
                                               data-id="{{ $floorData['id'] }}"
                                               data-kt-filemanager-table-filter="delete_row">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <!--end::Action=-->
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
