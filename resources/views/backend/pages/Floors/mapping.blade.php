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
                    @foreach($floor->rooms as $index => $room)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $index }}">
                                <button class="accordion-button {{ $index == 0 ? '' : 'collapsed' }}" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $index }}"
                                        aria-expanded="{{ $index == 0 ? 'true' : 'false' }}"
                                        aria-controls="collapse{{ $index }}">
                                    {{ $room->room_name }}
                                </button>
                            </h2>
                            <div id="collapse{{ $index }}"
                                 class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}"
                                 aria-labelledby="heading{{ $index }}"
                                 data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row">
                                        @foreach($room->beds as $bed)
                                            <div class="col-md-4">
                                                <label>{{ $bed->bed_title }}</label>
                                                <input type="text" class="form-control bed-search"
                                                       data-bed-id="{{ $bed->id }}">
                                                <div class="dropdown">
                                                    <div class="dropdown-menu"
                                                         aria-labelledby="dropdownMenuButton"></div>
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

        @endsection
        @section('custom_js')
            <script>
                $(document).ready(function () {
                    $('.bed-search').on('input', function () {
                        var bedId = $(this).data('bed-id');
                        var query = $(this).val();
                        var $dropdownMenu = $(this).next('.dropdown').find('.dropdown-menu');

                        if (query.length > 2) {
                            $.ajax({
                                url: '{{ route("patients.search") }}', // Adjust the route as needed
                                method: 'GET',
                                data: {query: query, bed_id: bedId},
                                success: function (data) {
                                    $dropdownMenu.empty().show();
                                    if (data.length) {
                                        data.forEach(function (patient) {
                                            $dropdownMenu.append('<a class="dropdown-item" href="#">' + patient.first_name + '</a>');
                                        });
                                    } else {
                                        $dropdownMenu.append('<a class="dropdown-item disabled" href="#">No results found</a>');
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
                        $(this).closest('.dropdown').prev('.bed-search').val(patientName);
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
