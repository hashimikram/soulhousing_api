@extends('backend.layout.master')
@section('breadcrumb_title', 'Edit Floor')
@section('breadcrumb_li_1', 'Home')
@section('breadcrumb_li_2', 'Floors Management - Edit Floor')
@section('breadcrumb_href', route('dashboard'))
@section('floors_management_li', 'here show')
@section('floors_a', 'active')
@section('page_title', 'Edit Floor')
@section('custom_css')
    <style>
        .floor-box, .room-box, .form-group {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .floor-box {
            background-color: #f9f9f9;
        }

        .room-box {
            background-color: #f1f1f1;
        }

        .form-group {
            background-color: #e9e9e9;
        }

        .input-container {
            display: flex;
            align-items: center;
        }

        .input-container input {
            flex: 1;
            margin-right: 10px;
            width: auto;
        }
    </style>
@endsection

@section('content')
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="card">
            <div class="card-body py-4">
                <form id="kt_modal_edit_user_form" class="form" action="{{ route('floors.update', $floor->id) }}"
                      method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_edit_user_scroll"
                         data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                         data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_edit_user_header"
                         data-kt-scroll-wrappers="#kt_modal_edit_user_scroll" data-kt-scroll-offset="300px">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <label class="required form-label">Select Provider</label>
                                    <select class="form-select" name="provider_id" data-control="select2" required
                                            disabled>
                                        @foreach($providers as $provider)
                                            <option
                                                value="{{ $provider->id }}" {{ $floor->provider_id == $provider->id ? 'selected' : '' }}>
                                                {{ $provider->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <label class="required form-label">Select Facility</label>
                                    <select class="form-select" name="facility_id" data-control="select2" required
                                            disabled>
                                        @foreach($facilities as $facility)
                                            <option
                                                value="{{ $facility->id }}" {{ $floor->facility_id == $facility->id ? 'selected' : '' }}>
                                                {{ $facility->address }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="container mt-5">
                            <div id="floor-container">
                                @if($floor)
                                    <div class="floor-box">
                                        <div class="input-container mb-5">
                                            <input type="text" class="form-control floor-title"
                                                   name="floors[{{ $floor->id }}][title]"
                                                   value="{{ $floor->floor_name }}" placeholder="Enter Floor title">
                                            <button type="button"
                                                    class="btn btn-sm btn-icon btn-light-danger delete-floor-btn">
                                                <span class="svg-icon svg-icon-1">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <rect opacity="0.5" x="7.05025" y="15.5356" width="12"
                                                              height="2" rx="1" transform="rotate(-45 7.05025 15.5356)"
                                                              fill="currentColor"></rect>
                                                        <rect x="8.46447" y="7.05029" width="12" height="2" rx="1"
                                                              transform="rotate(45 8.46447 7.05029)"
                                                              fill="currentColor"></rect>
                                                    </svg>
                                                </span>
                                            </button>
                                        </div>
                                        <button type="button" class="btn btn-primary add-room-btn">Add Room</button>
                                        <div class="rooms-container mt-5">
                                            @foreach($floor->rooms as $room)
                                                <div class="room-box" data-room-id="{{ $room->id }}">
                                                    <div class="input-container mb-5">
                                                        <input type="text" class="form-control room-title"
                                                               name="rooms[{{ $room->id }}][title]"
                                                               value="{{ $room->room_name }}"
                                                               placeholder="Enter Room title">
                                                        <button type="button"
                                                                class="btn btn-sm btn-icon btn-light-danger delete-room-btn">
                                                            <span class="svg-icon svg-icon-1">
                                                                <svg width="24" height="24" viewBox="0 0 24 24"
                                                                     fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <rect opacity="0.5" x="7.05025" y="15.5356"
                                                                          width="12" height="2" rx="1"
                                                                          transform="rotate(-45 7.05025 15.5356)"
                                                                          fill="currentColor"></rect>
                                                                    <rect x="8.46447" y="7.05029" width="12"
                                                                          height="2" rx="1"
                                                                          transform="rotate(45 8.46447 7.05029)"
                                                                          fill="currentColor"></rect>
                                                                </svg>
                                                            </span>
                                                        </button>
                                                    </div>
                                                    <button type="button" class="btn btn-primary add-bed-btn">Add Bed
                                                    </button>
                                                    <div class="beds-container mt-5">
                                                        @foreach($room->beds as $bed)
                                                            <div class="form-group" data-bed-id="{{ $bed->id }}">
                                                                <div class="input-container mb-5">
                                                                    <input type="text"
                                                                           class="form-control bed-title"
                                                                           name="beds[{{ $bed->id }}][title]"
                                                                           value="{{ $bed->bed_title }}"
                                                                           placeholder="Enter Bed title">
                                                                    <button type="button"
                                                                            class="btn btn-sm btn-icon btn-light-danger delete-bed-btn">
                                                                        <span class="svg-icon svg-icon-1">
                                                                            <svg width="24" height="24"
                                                                                 viewBox="0 0 24 24"
                                                                                 fill="none"
                                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                                <rect opacity="0.5" x="7.05025"
                                                                                      y="15.5356"
                                                                                      width="12" height="2" rx="1"
                                                                                      transform="rotate(-45 7.05025 15.5356)"
                                                                                      fill="currentColor"></rect>
                                                                                <rect x="8.46447" y="7.05029" width="12"
                                                                                      height="2" rx="1"
                                                                                      transform="rotate(45 8.46447 7.05029)"
                                                                                      fill="currentColor"></rect>
                                                                            </svg>
                                                                        </span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="text-center pt-15">
                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">Update</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('custom_js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const floorContainer = document.getElementById('floor-container');
            let roomCounter = Date.now(); // Use timestamp as a unique ID for new rooms
            let bedCounters = {}; // Object to store bed counters for each room

            floorContainer.addEventListener('click', function (e) {
                if (e.target && e.target.classList.contains('add-bed-btn')) {
                    const roomBox = e.target.closest('.room-box');
                    const bedsContainer = roomBox.querySelector('.beds-container');
                    const roomId = roomBox.dataset.roomId;

                    if (!bedCounters[roomId]) {
                        bedCounters[roomId] = Date.now();
                    }

                    const bedField = document.createElement('div');
                    bedField.className = 'form-group';
                    bedField.dataset.bedId = `new_${bedCounters[roomId]++}`; // Unique ID for new bed
                    bedField.innerHTML = `
                <div class="input-container mb-5">
                    <input type="hidden" name="beds[${bedField.dataset.bedId}][room_id]" value="${roomId}">
                    <input type="text" class="form-control bed-title" name="beds[${bedField.dataset.bedId}][title]" placeholder="Enter Bed title">
                    <button type="button" class="btn btn-sm btn-icon btn-light-danger delete-bed-btn">
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="7.05025" y="15.5356" width="12" height="2" rx="1" transform="rotate(-45 7.05025 15.5356)" fill="currentColor"></rect>
                                <rect x="8.46447" y="7.05029" width="12" height="2" rx="1" transform="rotate(45 8.46447 7.05029)" fill="currentColor"></rect>
                            </svg>
                        </span>
                    </button>
                </div>
            `;
                    bedsContainer.appendChild(bedField);
                }

                if (e.target && e.target.classList.contains('add-room-btn')) {
                    const floorBox = e.target.closest('.floor-box');
                    const roomsContainer = floorBox.querySelector('.rooms-container');

                    const roomBox = document.createElement('div');
                    roomBox.className = 'room-box';
                    roomBox.dataset.roomId = `new_${roomCounter++}`; // Unique ID for new room
                    bedCounters[roomBox.dataset.roomId] = Date.now(); // Initialize bed counter for this room
                    roomBox.innerHTML = `
                <div class="input-container mb-5">
                    <input type="text" class="form-control room-title" name="rooms[${roomBox.dataset.roomId}][title]" placeholder="Enter Room title">
                    <button type="button" class="btn btn-sm btn-icon btn-light-danger delete-room-btn">
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="7.05025" y="15.5356" width="12" height="2" rx="1" transform="rotate(-45 7.05025 15.5356)" fill="currentColor"></rect>
                                <rect x="8.46447" y="7.05029" width="12" height="2" rx="1" transform="rotate(45 8.46447 7.05029)" fill="currentColor"></rect>
                            </svg>
                        </span>
                    </button>
                </div>
                <button type="button" class="btn btn-primary add-bed-btn">Add Bed</button>
                <div class="beds-container mt-5"></div>
            `;
                    roomsContainer.appendChild(roomBox);
                }

                if (e.target && e.target.closest('.delete-floor-btn')) {
                    e.target.closest('.floor-box').remove();
                }

                if (e.target && e.target.closest('.delete-room-btn')) {
                    e.target.closest('.room-box').remove();
                }

                if (e.target && e.target.closest('.delete-bed-btn')) {
                    const bedGroup = e.target.closest('.form-group');
                    const bedIdInput = bedGroup.querySelector('.bed-delete-input');

                    if (bedGroup.dataset.bedId && !bedIdInput) {
                        bedGroup.innerHTML = `<input type="hidden" name="beds[${bedGroup.dataset.bedId}][delete]" value="1">`;
                    } else {
                        bedGroup.remove();
                    }
                }
            });
        });

    </script>
@endsection
