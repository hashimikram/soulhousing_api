@extends('backend.layout.master')
@section('breadcrumb_title', 'Patients List')
@section('breadcrumb_li_1', 'Home')
@section('breadcrumb_li_2', 'Patients Management - Users')
@section('breadcrumb_href', route('dashboard'))
@section('patients_management_li', 'here show')
@section('patients_a', 'active')
@section('page_title', 'All Patients')
@section('content')
    <div id="kt_app_content_container" class="app-container">
        <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_pane_1" data-target="#kt_tab_pane_1"
                   onclick="loadTableData(1)">All Patients</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_2" data-target="#kt_tab_pane_2"
                   onclick="loadTableData(2)">New</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_3" data-target="#kt_tab_pane_3"
                   onclick="loadTableData(3)">Assigned Patients</a>
            </li>
        </ul>


        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                      transform="rotate(45 17.0365 15.1223)" fill="currentColor"/>
                                <path
                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                    fill="currentColor"/>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <input type="text" data-kt-user-table-filter="search"
                               class="form-control form-control-solid w-250px ps-14" placeholder="Search user"/>
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        <a href="{{route('patients.create')}}" class="btn btn-primary"><span
                                class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                          transform="rotate(-90 11.364 20.364)" fill="currentColor"/>
                                    <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                          fill="currentColor"/>
                                </svg>
                            </span>Add Patient</a>
                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body py-4">
                <!--begin::Table-->
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
                        <div id="table-container-1">
                            <!-- Table will be loaded here -->
                        </div>
                    </div>
                    <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
                        <div id="table-container-2">
                            <!-- Table will be loaded here -->
                        </div>
                    </div>
                    <div class="tab-pane fade" id="kt_tab_pane_3" role="tabpanel">
                        <div id="table-container-3">
                            <!-- Table will be loaded here -->
                        </div>
                    </div>
                </div>

                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>

@endsection
@section('custom_js')
    <script>
        function loadTableData(tabId) {
            const tableContainer = $(`#table-container-${tabId}`);
            $.ajax({
                url: `/fetch-patients/${tabId}`,
                method: 'GET',
                success: function (data) {
                    tableContainer.html(data.html);
                },
                error: function (xhr, status, error) {
                    console.error('AJAX request failed:', status, error);
                }
            });

        }

        $(document).ready(function () {
            loadTableData(1);

            $('a[data-target]').on('click', function () {
                const tabId = $(this).data('target');
                loadTableData(tabId);
            });
        });
    </script>

@endsection
