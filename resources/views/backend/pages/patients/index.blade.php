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
                <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_pane_1" data-target="1"
                    onclick="loadTableData(1)">All Patients</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_2" data-target="2"
                    onclick="loadTableData(2)">New</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_3" data-target="3"
                    onclick="loadTableData(3)">Assigned Patients</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_4" data-target="4"
                    onclick="loadTableData(4)">Blacklist Patients</a>
            </li>
        </ul>


        <!--begin::Card-->
        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <a href="{{ route('patients.create') }}" class="btn btn-primary"><span class="svg-icon svg-icon-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                    transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                    fill="currentColor" />
                            </svg>
                        </span>Add Patient</a>
                </div>
            </div>
            <div class="card-body py-4">
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
                    <div class="tab-pane fade" id="kt_tab_pane_4" role="tabpanel">
                        <div id="table-container-4">
                            <!-- Table will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('custom_js')
    <script>
        $(document).ready(function() {

            // Initial load for the default tab
            loadTableData(1);

            // Event listener for tab clicks
            $('a[data-target]').on('click', function() {
                const tabId = $(this).data('target');
                console.log('Tab ID:', tabId);
                loadTableData(tabId);
            });

            // Delete button functionality
            $(document).on('click', '.delete-button', function(event) {
                event.preventDefault();
                const userId = $(this).data('id');

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
                        const form = $('<form>', {
                            method: 'POST',
                            action: `/patient/delete/${userId}`
                        }).append($('<input>', {
                            type: 'hidden',
                            name: '_token',
                            value: '{{ csrf_token() }}'
                        }), $('<input>', {
                            type: 'hidden',
                            name: '_method',
                            value: 'DELETE'
                        }));

                        $('body').append(form);
                        form.submit();
                    }
                });
            });

        });

        function loadTableData(tabId) {
            const tableContainer = $(`#table-container-${tabId}`);
            const loader = $(`#loader-${tabId}`);

            console.log('Loading data for Tab ID:', tabId);

            // Show the loader before starting the AJAX request
            loader.show();

            $.ajax({
                url: `/fetch-patients/${tabId}`,
                method: 'GET',
                success: function(data) {
                    // Hide the loader after data is loaded
                    loader.hide();

                    tableContainer.html(data.html);

                    // Initialize or re-initialize DataTables
                    if ($.fn.DataTable.isDataTable(`#table-container-${tabId} .patient_table`)) {
                        $(`#table-container-${tabId} .patient_table`).DataTable().destroy();
                    }

                    $(`#table-container-${tabId} .patient_table`).DataTable({
                        "paging": true,
                        "pageLength": 10,
                        "lengthChange": false,
                        "ordering": false
                    });
                },
                error: function(xhr, status, error) {
                    // Hide the loader if the request fails
                    loader.hide();
                    console.error('AJAX request failed:', status, error);
                }
            });
        }
    </script>

@endsection
