@extends('backend.layout.master')
@section('breadcrumb_title','Create Floor')
@section('breadcrumb_li_1','Home')
@section('breadcrumb_li_2','Floors Management - Create Floor')
@section('breadcrumb_href', route('dashboard'))
@section('floors_management_li', 'here show')
@section('floors_a', 'active')
@section('page_title','Create Floor')
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
                <form id="floor-form" class="form kt_add_data_modal" action="{{ route('floors.store') }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf

                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll"
                         data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                         data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header"
                         data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-7">
                                    <label class="required form-label">Select Facility</label>
                                    <select class="form-select" name="facility_id" data-control="select2" required>
                                        <option>Select Facility</option>
                                        @foreach($facilities as $data)
                                            <option value="{{$data->id}}">{{$data->address}}</option>
                                        @endforeach
                                    </select>
                                    @error('facility_id')
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div data-field="facility_id" data-validator="notEmpty">{{ $message }}</div>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="container mt-5">
                            <button type="button" class="btn btn-success mb-3" id="add-floor-btn">Add Floor</button>
                            <div id="floor-container"></div>
                        </div>

                        <div class="text-center pt-15">
                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
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
            const addFloorBtn = document.getElementById('add-floor-btn');
            const form = document.getElementById('floor-form');

            addFloorBtn.addEventListener('click', function () {
                const floorIndex = document.querySelectorAll('.floor-box').length;
                const floorBox = document.createElement('div');
                floorBox.className = 'floor-box';
                floorBox.innerHTML = `
                <div class="input-container mb-5">
                    <input type="text" class="form-control floor-title" required name="floors[${floorIndex}][title]" placeholder="Enter Floor title">
                    <button type="button" class="btn btn-sm btn-icon btn-light-danger delete-floor-btn">
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="7.05025" y="15.5356" width="12" height="2" rx="1" transform="rotate(-45 7.05025 15.5356)" fill="currentColor"></rect>
                                <rect x="8.46447" y="7.05029" width="12" height="2" rx="1" transform="rotate(45 8.46447 7.05029)" fill="currentColor"></rect>
                            </svg>
                        </span>
                    </button>
                </div>
                <button type="button" class="btn btn-primary add-room-btn">Add Room</button>
                <div class="rooms-container mt-5"></div>
            `;
                floorContainer.appendChild(floorBox);
            });

            floorContainer.addEventListener('click', function (e) {
                if (e.target && e.target.classList.contains('add-room-btn')) {
                    const floorBox = e.target.closest('.floor-box');
                    const roomsContainer = floorBox.querySelector('.rooms-container');
                    const floorIndex = Array.from(floorContainer.children).indexOf(floorBox);
                    const roomIndex = roomsContainer.querySelectorAll('.room-box').length;

                    const roomBox = document.createElement('div');
                    roomBox.className = 'room-box';
                    roomBox.innerHTML = `
                    <div class="input-container mb-5">
                        <input type="text" class="form-control room-title"  required name="floors[${floorIndex}][rooms][${roomIndex}][title]" placeholder="Enter Room title">
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

                if (e.target && e.target.classList.contains('add-bed-btn')) {
                    const roomBox = e.target.closest('.room-box');
                    const bedsContainer = roomBox.querySelector('.beds-container');
                    const floorBox = roomBox.closest('.floor-box');
                    const floorIndex = Array.from(floorContainer.children).indexOf(floorBox);
                    const roomIndex = Array.from(floorBox.querySelectorAll('.room-box')).indexOf(roomBox);
                    const bedIndex = bedsContainer.querySelectorAll('.bed-box').length;

                    const bedField = document.createElement('div');
                    bedField.className = 'form-group bed-box';
                    bedField.innerHTML = `
                    <div class="input-container mb-5">
                        <input type="text" class="form-control bed-title" required name="floors[${floorIndex}][rooms][${roomIndex}][beds][${bedIndex}][title]" placeholder="Enter Bed title">
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

                if (e.target && e.target.closest('.delete-floor-btn')) {
                    const floorBox = e.target.closest('.floor-box');
                    floorBox.remove();
                }

                if (e.target && e.target.closest('.delete-room-btn')) {
                    const roomBox = e.target.closest('.room-box');
                    roomBox.remove();
                }

                if (e.target && e.target.closest('.delete-bed-btn')) {
                    const bedField = e.target.closest('.form-group');
                    bedField.remove();
                }
            });

            form.addEventListener('submit', function (e) {
                if (document.querySelectorAll('.floor-box').length === 0) {
                    e.preventDefault();
                    alert('At least one floor is required.');
                    const submitButton = form.querySelector('button[type="submit"]');
                    submitButton.removeAttribute('disabled');
                    submitButton.innerHTML = 'Submit';
                }
            });
        });
    </script>
@endsection
