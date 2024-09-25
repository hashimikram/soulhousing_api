@extends('backend.layout.master')
@section('breadcrumb_title','Roles List')
@section('breadcrumb_li_1','Home')
@section('breadcrumb_li_2','Roles Management - Roles')
@section('breadcrumb_href', route('dashboard'))
@section('roles_management_li', 'here show')
@section('roles_a', 'active')
@section('page_title','All Roles')
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
                    <a href="{{route('roles.create')}}" class="btn btn-primary">
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
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->

            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body py-4">
                <!--begin::Table-->
                <table
                    class="table align-middle table-row-dashed fs-6 gy-5"
                    id=""
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
                        <th class="min-w-125px">Role Name</th>
                        <th class="min-w-125px">Created At</th>
                        <th class="text-end min-w-100px">Actions</th>
                    </tr>
                    <!--end::Table row-->
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody class="text-gray-600 fw-semibold">
                    <!--begin::Table row-->
                    @foreach ($roles as $key => $data)
                        <tr>
                            <!--begin::Checkbox-->
                            <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="{{ $data->id }}"/>
                                </div>
                            </td>
                            <!--end::Checkbox-->
                            <td>{{ $data->role_name }}</td>
                            <td><span
                                    class="badge py-3 px-4 fs-7 badge-light-success">{{ formatDate($data->created_at) }}</span>
                            </td>
                            <!--begin::Action=-->
                            <td class="text-end">
                                <div class="ms-2">
                                    <button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary"
                                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen052.svg-->
                                        <span class="svg-icon svg-icon-5 m-0">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <rect x="10" y="10" width="4" height="4" rx="2" fill="currentColor"></rect>
                            <rect x="17" y="10" width="4" height="4" rx="2" fill="currentColor"></rect>
                            <rect x="3" y="10" width="4" height="4" rx="2" fill="currentColor"></rect>
                        </svg>
                    </span>
                                        <!--end::Svg Icon-->
                                    </button>
                                    <!--begin::Menu-->
                                    <div
                                        class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-150px py-4"
                                        data-kt-menu="true" style="">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="{{route('roles.edit',$data->id)}}" class="menu-link px-3">Edit</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link text-danger px-3 delete-button"
                                               data-id="{{ $data->id }}"
                                               data-kt-filemanager-table-filter="delete_row">Delete</a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu-->
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
