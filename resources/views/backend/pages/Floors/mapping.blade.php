@extends('backend.layout.master')
@section('breadcrumb_title', 'Bed Mapping')
@section('breadcrumb_li_1', 'Home')
@section('breadcrumb_li_2', 'Floors Management - Bed Mapping')
@section('breadcrumb_href', route('dashboard'))
@section('floors_management_li', 'here show')
@section('floors_a', 'active')
@section('page_title', 'Bed Mapping')
@section('custom_css')
    <style>
        .dropdown-item img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }
    </style>
@endsection
@section('content')
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="card">
            <div class="card-body bg-transparent py-4">
                <div class="accordion" id="accordionExample">
                    @foreach ($response['floor']['rooms'] as $index => $room)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $index }}">
                                <button class="accordion-button {{ $index == 0 ? '' : 'collapsed' }}" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}"
                                        aria-expanded="{{ $index == 0 ? 'true' : 'false' }}"
                                        aria-controls="collapse{{ $index }}">
                                    {{ $room['room_name'] }}
                                </button>
                            </h2>
                            <div id="collapse{{ $index }}"
                                 class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}"
                                 aria-labelledby="heading{{ $index }}" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row">
                                        @foreach ($room['beds'] as $bed)
                                            <div class="col-md-4 mb-4">
                                                <div class="card shadow-sm">
                                                    <div class="card-header"
                                                         style="background-color: rgb(223, 89, 89); color: rgb(255, 255, 255);min-height: 45px;">
                                                        <h3 class="card-title text-white">{{ $bed['bed_title'] }}</h3>
                                                    </div>
                                                    <div class="card-body" style="padding: 1rem 1.25rem;">
                                                        @if ($bed['patient'])
                                                            <p class="card-text">
                                                            <div>
                                                                <strong>{{ $bed['patient']['first_name'] }}
                                                                    {{ $bed['patient']['last_name'] }}</strong>
                                                            </div>
                                                            <div><strong>{{ $bed['patient']['gender'] }},</strong>
                                                                {{ $bed['patient']['date_of_birth'] }}</div>
                                                            <div><strong>MRN:</strong> {{ $bed['patient']['mrn_no'] }}
                                                            </div>
                                                            </p>
                                                        @else
                                                            <div class="input-group mb-3"
                                                                 style="height: 73px;align-items: center;">
                                                                <input type="text" class="form-control bed-search"
                                                                       style="height: 44px;"
                                                                       data-bed-id="{{ $bed['id'] }}"
                                                                       placeholder="Search patient..."
                                                                       aria-label="Search patient"/>
                                                                <span class="input-group-text"
                                                                      style="    height: 44px;">
                                                                    <span class="svg-icon svg-icon-1">
                                                                        <svg width="24" height="24"
                                                                             viewBox="0 0 24 24" fill="none"
                                                                             xmlns="http://www.w3.org/2000/svg">
                                                                            <rect opacity="0.5" x="17.0365" y="15.1223"
                                                                                  width="8.15546" height="2"
                                                                                  rx="1"
                                                                                  transform="rotate(45 17.0365 15.1223)"
                                                                                  fill="currentColor"></rect>
                                                                            <path
                                                                                d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                                                                fill="currentColor"></path>
                                                                        </svg>
                                                                    </span>
                                                                </span>
                                                            </div>
                                                            <div class="dropdown">
                                                                <div class="dropdown-menu w-100"
                                                                     aria-labelledby="dropdownMenuButton"></div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!--end::Accordion-->
            </div>
        </div>
    </div>
    @include('backend.pages.partials.transfer_patient_bed_modal')
@endsection



@section('custom_js')
    <script>
        $(document).ready(function () {
            function handleSearch($input) {
                const bedId = $input.data('bed-id');
                const query = $input.val();
                const $dropdownMenu = $input.closest('.input-group').next('.dropdown').find('.dropdown-menu');

                $dropdownMenu.empty().show().append(
                    '<a class="dropdown-item disabled" href="#"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...</a>'
                );

                if (query.length > 0) {
                    $.ajax({
                        url: '{{ route('patients.search') }}',
                        method: 'GET',
                        data: {
                            query: query,
                            bed_id: bedId
                        },
                        success: function (data) {
                            $dropdownMenu.empty().show();
                            if (data.length) {
                                data.forEach(function (patient) {
                                    $dropdownMenu.append(
                                        `<a class="dropdown-item" href="#" data-patient-id="${patient.id}">
                                        <img src="{{ image_url('${patient.profile_pic}') }}"  alt="${patient.first_name} ${patient.last_name}">
                                        ${patient.first_name} ${patient.last_name}
                                    </a>`
                                    );
                                });
                            } else {
                                $dropdownMenu.append(
                                    '<a class="dropdown-item disabled" href="#">No results found</a>'
                                );
                            }
                        },
                        error: function () {
                            $dropdownMenu.empty().append(
                                '<a class="dropdown-item disabled" href="#">Error occurred</a>');
                        }
                    });
                } else {
                    $dropdownMenu.empty().hide();
                }
            }

            $('.bed-search').on('input', function () {
                handleSearch($(this));
            });

            $(document).on('click', '.dropdown-item', function (e) {
                e.preventDefault();
                const $item = $(this);
                let patientName = $item.text().trim();
                const patientId = $item.data('patient-id');
                const $input = $item.closest('.dropdown').prev('.input-group').find('.bed-search');
                const newBedId = $input.data('bed-id');
                const oldBedId = $('#oldBedId').val();
                console.log(patientName);
                $input.val(patientName);
                $('.dropdown-menu').hide();

                $.ajax({
                    url: '{{ route('patients.assign') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        bed_id: newBedId,
                        patient_id: patientId
                    },
                    success: function (response) {
                        if (response.code) {
                            toastr.success(response.message || "Patient assigned to bed successfully.");
                            location.reload();
                        } else if (response.status === '1') {
                            $('#oldBedId').val(response.old_bed_id);
                            $('#newBedId').val(newBedId);
                            $('#patientId').val(patientId);
                            $('#transfer_patient_bed_modal').modal('show');
                        } else {
                            toastr.error(response.message || "An error occurred while assigning the patient.");
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        toastr.error('An unexpected error occurred: ' + textStatus + '.');
                    }
                });
            });

            $('#confirmTransfer').click(function () {
                $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...').attr('disabled', true);
                const oldBedId = $('#oldBedId').val();
                const newBedId = $('#newBedId').val();
                const patientId = $('#patientId').val();
                $.ajax({
                    url: '{{ route('patients.transfer') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        old_bed_id: oldBedId,
                        new_bed_id: newBedId,
                        patient_id: patientId
                    },
                    success: function (response) {
                        if (response.code) {
                            toastr.success(response.message || "Patient transferred successfully.");
                            location.reload();
                        } else {
                            toastr.error(response.message || "An error occurred while transferring the patient.");
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        toastr.error('An unexpected error occurred: ' + textStatus + '.');
                    }
                });
            });


            $(document).click(function (e) {
                if (!$(e.target).closest('.dropdown').length) {
                    $('.dropdown-menu').hide();
                }
            });
        });
    </script>
@endsection
