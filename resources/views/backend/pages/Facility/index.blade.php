@extends('backend.layout.master')
@section('breadcrumb_title','Facilities List')
@section('breadcrumb_li_1','Home')
@section('breadcrumb_li_2','Facility Management - Facilities')
@section('breadcrumb_href', route('dashboard'))
@section('facility_management_li', 'here show')
@section('facility_a', 'active')
@section('page_title','All Facilities')
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
                    <button
                        type="button"
                        class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#kt_modal_add_user_header"
                    >
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
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
                            </span>
                        <!--end::Svg Icon-->Add New Facility
                    </button>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <!--end::Toolbar-->
                    <!--begin::Modal - Add User-->
                    @include('backend.pages.Facility.modals.add')
                    <!--end::Modal - Add User-->
                </div>
                <!--end::Card toolbar-->
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
                        <th class="min-w-125px">Name</th>
                        <th class="min-w-125px">Address</th>
                        <th class="min-w-125px">Facility Type</th>
                        <th class="min-w-125px">Created Date</th>
                        <th class="text-end min-w-100px">Actions</th>
                    </tr>
                    <!--end::Table row-->
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody class="text-gray-600 fw-semibold">
                    <!--begin::Table row-->
                    @foreach ($facility as $key => $data)
                        <tr>
                            <!--begin::Checkbox-->
                            <td>
                                <div
                                    class="form-check form-check-sm form-check-custom form-check-solid"
                                >
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        value="{{$data->id}}"
                                    />
                                </div>
                            </td>
                            <!--end::Checkbox-->
                            <!--begin::Role=-->
                            <td>{{ $data->name }}</td>
                            <!--end::Role=-->
                            <!--begin::Role=-->
                            <td>{{ $data->address }}</td>
                            <!--end::Role=-->
                            <!--begin::Role=-->
                            <td>{{ $data->facility_type }}</td>
                            <!--end::Role=-->
                            <!--begin::Joined-->
                            <td>{{ formatDate($data->created_at) }}</td>
                            <!--begin::Joined-->
                            <!--begin::Action=-->
                            <td class="text-end">
                                <div class="ms-2">
                                    <button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary"
                                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen052.svg-->
                                        <span class="svg-icon svg-icon-5 m-0">
																			<svg width="24" height="24"
                                                                                 viewBox="0 0 24 24" fill="none"
                                                                                 xmlns="http://www.w3.org/2000/svg">
																				<rect x="10" y="10" width="4" height="4"
                                                                                      rx="2" fill="currentColor"></rect>
																				<rect x="17" y="10" width="4" height="4"
                                                                                      rx="2" fill="currentColor"></rect>
																				<rect x="3" y="10" width="4" height="4"
                                                                                      rx="2" fill="currentColor"></rect>
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
                                            <button type="button" data-bs-toggle="modal"
                                                    data-bs-target="#kt_modal_edit_user_header{{$data->id}}"
                                                    class="menu-link px-3 btn">Edit
                                            </button>

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
                        @include('backend.pages.Facility.modals.edit')
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
@section('custom_js')
    <script>
        $(document).ready(function () {
            @if($errors->any())
            $('#kt_modal_add_user_header').modal('show');
            @endif
        });

        document.addEventListener('DOMContentLoaded', function () {
            // Add event listener to all delete buttons
            document.querySelectorAll('.delete-button').forEach(function (button) {
                button.addEventListener('click', function (event) {
                    event.preventDefault();
                    var id = button.getAttribute('data-id');

                    // Show SweetAlert confirmation dialog
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Create a form dynamically
                            var form = document.createElement('form');
                            form.method = 'POST';
                            form.action = '/facility/' + id;

                            // Add CSRF token
                            var csrfInput = document.createElement('input');
                            csrfInput.type = 'hidden';
                            csrfInput.name = '_token';
                            csrfInput.value = '{{ csrf_token() }}';
                            form.appendChild(csrfInput);

                            // Add DELETE method
                            var methodInput = document.createElement('input');
                            methodInput.type = 'hidden';
                            methodInput.name = '_method';
                            methodInput.value = 'DELETE';
                            form.appendChild(methodInput);

                            // Append the form to the body and submit it
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            });
        });

    </script>

@endsection
