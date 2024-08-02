@extends('backend.layout.master')
@section('breadcrumb_title', 'Edit Floor')
@section('breadcrumb_li_1', 'Home')
@section('breadcrumb_li_2', 'Floors Management - Edit Floor')
@section('breadcrumb_href', route('dashboard'))
@section('floors_management_li', 'here show')
@section('floors_a', 'active')
@section('page_title', 'Edit Floor')

@section('content')
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="card">
            <div class="card-body bg-transparent py-4">
                <div class="accordion" id="accordionExample">
                    @foreach ($floor->rooms as $index => $room)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $index }}">
                                <button class="accordion-button {{ $index == 0 ? '' : 'collapsed' }}" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}"
                                        aria-expanded="{{ $index == 0 ? 'true' : 'false' }}"
                                        aria-controls="collapse{{ $index }}">
                                    {{ $room->room_name }}
                                </button>
                            </h2>
                            <div id="collapse{{ $index }}"
                                 class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}"
                                 aria-labelledby="heading{{ $index }}" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row">
                                        @foreach ($room->beds as $bed)
                                            <div class="col-md-4">
                                                <label>{{ $bed->bed_title }}</label>
                                                @if ($bed->patient)
                                                    <div class="card-body">
                                                        <p class="card-text">
                                                        <div>
                                                            <strong>{{ $bed->patient->first_name }} {{ $bed->patient->last_name }}</strong>
                                                        </div>
                                                        <div><strong>{{ $bed->patient->gender }}
                                                                ,</strong> {{ $bed->patient->date_of_birth }}</div>
                                                        <div><strong>MWRN:</strong> {{ $bed->patient->mrn_no }}</div>
                                                        </p>
                                                    </div>
                                                @else
                                                    <div class="input-group mb-5">
                                                        <input type="text" class="form-control bed-search"
                                                               data-bed-id="{{ $bed->id }}"
                                                               placeholder="Recipient's username"
                                                               aria-label="Recipient's username"
                                                               aria-describedby="basic-addon2"/>
                                                        <span class="input-group-text" id="basic-addon2">
                                        <span class="svg-icon svg-icon-1">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546"
                                                      height="2" rx="1" transform="rotate(45 17.0365 15.1223)"
                                                      fill="currentColor"></rect>
                                                <path
                                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                        </span>
                                    </span>
                                                    </div>
                                                    <div class="dropdown">
                                                        <div class="dropdown-menu"
                                                             aria-labelledby="dropdownMenuButton"></div>
                                                    </div>
                                                @endif
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

        @endsection
        @section('custom_js')
            <script>
                $(document).ready(function () {
                    $('.bed-search').on('input', function () {
                        var bedId = $(this).data('bed-id');
                        var query = $(this).val();
                        var $dropdownMenu = $(this).closest('.input-group').next('.dropdown').find('.dropdown-menu');

                        if (query.length > 2) {
                            $.ajax({
                                url: '{{ route('patients.search') }}', // Adjust the route as needed
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
                                                '<a class="dropdown-item" href="#">' +
                                                patient.first_name + '</a>');
                                        });
                                    } else {
                                        $dropdownMenu.append(
                                            '<a class="dropdown-item disabled" href="#">No results found</a>'
                                        );
                                    }
                                }
                            });
                        } else {
                            $dropdownMenu.empty().hide();
                        }
                    });

                    $(document).on('click', '.dropdown-item', function (e) {
                        e.preventDefault();
                        var patientName = $(this).text();
                        $(this).closest('.dropdown').prev('.input-group').find('.bed-search').val(patientName);
                        $('.dropdown-menu').hide();
                    });

                    $(document).click(function (e) {
                        if (!$(e.target).closest('.dropdown').length) {
                            $('.dropdown-menu').hide();
                        }
                    });
                });
            </script>

@endsection
