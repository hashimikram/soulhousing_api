@extends('backend.layout.master')
@section('breadcrumb_title','User Details')
@section('breadcrumb_li_1','Home')
@section('breadcrumb_li_2','User Management - User Details')
@section('breadcrumb_href', route('dashboard'))
@section('user_management_li', 'here show')
@section('users_a', 'active')
@section('page_title','User Details')
@section('content')
    <div
        id="kt_app_content_container"
        class="app-container"
    >
        <!--begin::Navbar-->
        <div class="card mb-5 mb-xxl-8">
            <div class="card-body pt-9 pb-0">
                <!--begin::Details-->
                <div class="d-flex flex-wrap flex-sm-nowrap">
                    <!--begin: Pic-->
                    <div class="me-7 mb-4">
                        <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                            <img src="{{ image_url($user->userDetail->image) }}" alt="image"/>
                            <div
                                class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px"></div>
                        </div>
                    </div>
                    <!--end::Pic-->
                    <!--begin::Info-->
                    <div class="flex-grow-1">
                        <!--begin::Title-->
                        <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                            <!--begin::User-->
                            <div class="d-flex flex-column">
                                <!--begin::Name-->
                                <div class="d-flex align-items-center mb-2">
                                    <a href="#"
                                       class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ $user->name }} {{ $user->userDetail->middle_name }} {{ $user->userDetail->last_name }}</a>
                                    <a href="#">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen026.svg-->
                                        <span class="svg-icon svg-icon-1 svg-icon-primary">
																		<svg xmlns="http://www.w3.org/2000/svg"
                                                                             width="24px" height="24px"
                                                                             viewBox="0 0 24 24">
																			<path
                                                                                d="M10.0813 3.7242C10.8849 2.16438 13.1151 2.16438 13.9187 3.7242V3.7242C14.4016 4.66147 15.4909 5.1127 16.4951 4.79139V4.79139C18.1663 4.25668 19.7433 5.83365 19.2086 7.50485V7.50485C18.8873 8.50905 19.3385 9.59842 20.2758 10.0813V10.0813C21.8356 10.8849 21.8356 13.1151 20.2758 13.9187V13.9187C19.3385 14.4016 18.8873 15.491 19.2086 16.4951V16.4951C19.7433 18.1663 18.1663 19.7433 16.4951 19.2086V19.2086C15.491 18.8873 14.4016 19.3385 13.9187 20.2758V20.2758C13.1151 21.8356 10.8849 21.8356 10.0813 20.2758V20.2758C9.59842 19.3385 8.50905 18.8873 7.50485 19.2086V19.2086C5.83365 19.7433 4.25668 18.1663 4.79139 16.4951V16.4951C5.1127 15.491 4.66147 14.4016 3.7242 13.9187V13.9187C2.16438 13.1151 2.16438 10.8849 3.7242 10.0813V10.0813C4.66147 9.59842 5.1127 8.50905 4.79139 7.50485V7.50485C4.25668 5.83365 5.83365 4.25668 7.50485 4.79139V4.79139C8.50905 5.1127 9.59842 4.66147 10.0813 3.7242V3.7242Z"
                                                                                fill="currentColor"/>
																			<path
                                                                                d="M14.8563 9.1903C15.0606 8.94984 15.3771 8.9385 15.6175 9.14289C15.858 9.34728 15.8229 9.66433 15.6185 9.9048L11.863 14.6558C11.6554 14.9001 11.2876 14.9258 11.048 14.7128L8.47656 12.4271C8.24068 12.2174 8.21944 11.8563 8.42911 11.6204C8.63877 11.3845 8.99996 11.3633 9.23583 11.5729L11.3706 13.4705L14.8563 9.1903Z"
                                                                                fill="white"/>
																		</svg>
																	</span>
                                        <!--end::Svg Icon-->
                                    </a>
                                </div>
                                <!--end::Name-->
                                <!--begin::Info-->
                                <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                    <a href="#"
                                       class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                        <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                                        <span class="svg-icon svg-icon-4 me-1">
																	<svg width="18" height="18" viewBox="0 0 18 18"
                                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
																		<path opacity="0.3"
                                                                              d="M16.5 9C16.5 13.125 13.125 16.5 9 16.5C4.875 16.5 1.5 13.125 1.5 9C1.5 4.875 4.875 1.5 9 1.5C13.125 1.5 16.5 4.875 16.5 9Z"
                                                                              fill="currentColor"/>
																		<path
                                                                            d="M9 16.5C10.95 16.5 12.75 15.75 14.025 14.55C13.425 12.675 11.4 11.25 9 11.25C6.6 11.25 4.57499 12.675 3.97499 14.55C5.24999 15.75 7.05 16.5 9 16.5Z"
                                                                            fill="currentColor"/>
																		<rect x="7" y="6" width="4" height="4" rx="2"
                                                                              fill="currentColor"/>
																	</svg>
																</span>
                                        <!--end::Svg Icon-->{{ $user->userDetail->user_name }}</a>
                                    <a href="#"
                                       class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen018.svg-->
                                        <span class="svg-icon svg-icon-4 me-1">
																	<svg width="24" height="24" viewBox="0 0 24 24"
                                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
																		<path opacity="0.3"
                                                                              d="M18.0624 15.3453L13.1624 20.7453C12.5624 21.4453 11.5624 21.4453 10.9624 20.7453L6.06242 15.3453C4.56242 13.6453 3.76242 11.4453 4.06242 8.94534C4.56242 5.34534 7.46242 2.44534 11.0624 2.04534C15.8624 1.54534 19.9624 5.24534 19.9624 9.94534C20.0624 12.0453 19.2624 13.9453 18.0624 15.3453Z"
                                                                              fill="currentColor"/>
																		<path
                                                                            d="M12.0624 13.0453C13.7193 13.0453 15.0624 11.7022 15.0624 10.0453C15.0624 8.38849 13.7193 7.04535 12.0624 7.04535C10.4056 7.04535 9.06241 8.38849 9.06241 10.0453C9.06241 11.7022 10.4056 13.0453 12.0624 13.0453Z"
                                                                            fill="currentColor"/>
																	</svg>
																</span>
                                        <!--end::Svg Icon-->{{ $user->userDetail->city }}
                                        . {{ $user->userDetail->country }}</a>
                                    <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                        <!--begin::Svg Icon | path: icons/duotune/communication/com011.svg-->
                                        <span class="svg-icon svg-icon-4 me-1">
																	<svg width="24" height="24" viewBox="0 0 24 24"
                                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
																		<path opacity="0.3"
                                                                              d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19Z"
                                                                              fill="currentColor"/>
																		<path
                                                                            d="M21 5H2.99999C2.69999 5 2.49999 5.10005 2.29999 5.30005L11.2 13.3C11.7 13.7 12.4 13.7 12.8 13.3L21.7 5.30005C21.5 5.10005 21.3 5 21 5Z"
                                                                            fill="currentColor"/>
																	</svg>
																</span>
                                        <!--end::Svg Icon-->{{ $user->email }}</a>
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::User-->
                            <!--begin::Actions-->
                            <div class="d-flex my-4">
                                <a href="#" class="btn btn-sm btn-light me-2" id="kt_user_follow_button">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr012.svg-->
                                    <span class="svg-icon svg-icon-3 d-none">
																	<svg width="24" height="24" viewBox="0 0 24 24"
                                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
																		<path opacity="0.3"
                                                                              d="M10 18C9.7 18 9.5 17.9 9.3 17.7L2.3 10.7C1.9 10.3 1.9 9.7 2.3 9.3C2.7 8.9 3.29999 8.9 3.69999 9.3L10.7 16.3C11.1 16.7 11.1 17.3 10.7 17.7C10.5 17.9 10.3 18 10 18Z"
                                                                              fill="currentColor"/>
																		<path
                                                                            d="M10 18C9.7 18 9.5 17.9 9.3 17.7C8.9 17.3 8.9 16.7 9.3 16.3L20.3 5.3C20.7 4.9 21.3 4.9 21.7 5.3C22.1 5.7 22.1 6.30002 21.7 6.70002L10.7 17.7C10.5 17.9 10.3 18 10 18Z"
                                                                            fill="currentColor"/>
																	</svg>
																</span>
                                    <!--end::Svg Icon-->
                                    <!--begin::Indicator label-->
                                    <span class="indicator-label">Follow</span>
                                    <!--end::Indicator label-->
                                    <!--begin::Indicator progress-->
                                    <span class="indicator-progress">Please wait...
																<span
                                                                    class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    <!--end::Indicator progress-->
                                </a>
                                <a href="#" class="btn btn-sm btn-primary me-2" data-bs-toggle="modal"
                                   data-bs-target="#kt_modal_offer_a_deal">Hire Me</a>
                            </div>
                            <!--end::Actions-->
                        </div>
                        <!--end::Title-->
                        <!--begin::Stats-->
                        <div class="d-flex flex-wrap flex-stack">
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-column flex-grow-1 pe-8">
                                <!--begin::Stats-->
                                <div class="d-flex flex-wrap">
                                    <!--begin::Stat-->
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                        <!--begin::Number-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
                                            <span class="svg-icon svg-icon-3 svg-icon-success me-2">
																			<svg width="24" height="24"
                                                                                 viewBox="0 0 24 24" fill="none"
                                                                                 xmlns="http://www.w3.org/2000/svg">
																				<rect opacity="0.5" x="13" y="6"
                                                                                      width="13" height="2" rx="1"
                                                                                      transform="rotate(90 13 6)"
                                                                                      fill="currentColor"/>
																				<path
                                                                                    d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
                                                                                    fill="currentColor"/>
																			</svg>
																		</span>
                                            <!--end::Svg Icon-->
                                            <div class="fs-2 fw-bold" data-kt-countup="true"
                                                 data-kt-countup-value="{{$total_patients}}">0
                                            </div>
                                        </div>
                                        <!--end::Number-->
                                        <!--begin::Label-->
                                        <div class="fw-semibold fs-6 text-gray-400">Patients Under This Doctor</div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Stat-->
                                </div>
                                <!--end::Stats-->
                            </div>
                            <!--end::Wrapper-->
                            <!--begin::Progress-->
                            <div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
                                <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                    <span class="fw-semibold fs-6 text-gray-400">Profile Compleation</span>
                                    <span class="fw-bold fs-6">50%</span>
                                </div>
                                <div class="h-5px mx-3 w-100 bg-light mb-3">
                                    <div class="bg-success rounded h-5px" role="progressbar" style="width: 50%;"
                                         aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <!--end::Progress-->
                        </div>
                        <!--end::Stats-->
                    </div>
                    <!--end::Info-->
                </div>
                <!--end::Details-->
                <!--begin::Navs-->
                <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                    <!--begin::Nav item-->
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 active"
                           href="../../demo1/dist/pages/user-profile/overview.html">Permissions</a>
                    </li>
                    <!--end::Nav item-->
                </ul>
                <!--begin::Navs-->
            </div>
        </div>
        <!--end::Navbar-->
        <!--begin::Row-->
        <div class="row g-5 g-xxl-8">
            <!--begin::Col-->
            <div class="col-xl-7">
                <!--begin::Feeds Widget 1-->
                <div class="card mb-5 mb-xxl-8">
                    <!--begin::Body-->
                    <div class="card-body pb-0">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <!--begin::Form-->
                        @php
                            // Extract the JSON string from the permissions field
                            $permissionsJson = $user->roles->flatMap(function ($role) {
                                return $role->permissions; // This should be a JSON string
                            })->first(); // Assuming you want the first item if there's only one role

                            // Decode the JSON string into an array
                            $permissionsArray = json_decode($permissionsJson, true);

                            // Make sure $permissionsArray is an array
                            if (is_array($permissionsArray)) {
                                $userPermissions = $permissionsArray; // No need to access ['permissions'] if the decoded result is directly an array
                            } else {
                                $userPermissions = []; // Fallback if decoding fails
                            }
                        @endphp


                        <form id="kt_modal_add_user_form" class="form" action="{{ route('roles.store') }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll"
                                 data-kt-scroll="true"
                                 data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                                 data-kt-scroll-dependencies="#kt_modal_add_user_header"
                                 data-kt-scroll-wrappers="#kt_modal_add_user_scroll"
                                 data-kt-scroll-offset="300px">

                                <input type="hidden" value="{{$user->id}}" name="user_id">
                                <!--begin::Input group-->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="fv-row mb-7">
                                            <label class="required fw-semibold fs-6 mb-2">Role Name</label>
                                            <input type="text" name="name"
                                                   class="form-control form-control-solid mb-3 mb-lg-0"
                                                   placeholder="Editor" required
                                                   value="{{ old('name') }}"/>
                                            @error('name')
                                            <div class="fv-plugins-message-container invalid-feedback">
                                                <div data-field="title" data-validator="notEmpty">{{ $message }}</div>
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <!--end::Input group-->

                                <!-- Section: Permissions -->
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <h5 class="mb-4">Permissions</h5>

                                        <div class="form-check form-check-inline form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefault1"
                                                   name="permissions[]" value="add_patient"
                                                {{ in_array('add_patient', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexSwitchCheckDefault1">Add
                                                Patient</label>
                                        </div>

                                        <div class="form-check form-check-inline form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefault2"
                                                   name="permissions[]" value="bed_mapping"
                                                {{ in_array('bed_mapping', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexSwitchCheckDefault2">Bed
                                                Mapping</label>
                                        </div>


                                        <div class="form-check form-check-inline form-switch mb-5">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefault3"
                                                   name="permissions[]" value="maintenance"
                                                {{ in_array('maintenance', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                   for="flexSwitchCheckDefault3">Maintenance</label>
                                        </div>
                                        <div class="form-check form-check-inline form-switch mb-5">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefault3"
                                                   name="permissions[]" value="operation"
                                                {{ in_array('operation', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                   for="flexSwitchCheckDefault3">Operation</label>
                                        </div>
                                        <div class="form-check form-check-inline form-switch mb-5">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefault3"
                                                   name="permissions[]" value="video_calling"
                                                {{ in_array('video_calling', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexSwitchCheckDefault3">Video
                                                Calling</label>
                                        </div>
                                        <div class="form-check form-check-inline form-switch mb-5">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefault3"
                                                   name="permissions[]" value="summary"
                                                {{ in_array('summary', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexSwitchCheckDefault3">Summary
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline form-switch mb-5">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefault3"
                                                   name="permissions[]" value="demographics"
                                                {{ in_array('demographics', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexSwitchCheckDefault3">Demographics
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline form-switch mb-5">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefault3"
                                                   name="permissions[]" value="admission"
                                                {{ in_array('admission', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexSwitchCheckDefault3">Admission
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline form-switch mb-5">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefault3"
                                                   name="permissions[]" value="problems"
                                                {{ in_array('problems', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexSwitchCheckDefault3">Problems
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline form-switch mb-5">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefault3"
                                                   name="permissions[]" value="allergies"
                                                {{ in_array('allergies', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexSwitchCheckDefault3">Allergies
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline form-switch mb-5">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefault3"
                                                   name="permissions[]" value="medication"
                                                {{ in_array('medication', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexSwitchCheckDefault3">Medication
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline form-switch mb-5">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefault3"
                                                   name="permissions[]" value="encounter"
                                                {{ in_array('encounter', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexSwitchCheckDefault3">Encounter
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline form-switch mb-5">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefault3"
                                                   name="permissions[]" value="vitals"
                                                {{ in_array('vitals', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexSwitchCheckDefault3">Vitals
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline form-switch mb-5">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefault3"
                                                   name="permissions[]" value="documents"
                                                {{ in_array('documents', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexSwitchCheckDefault3">Documents
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline form-switch mb-5">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefault3"
                                                   name="permissions[]" value="incidents"
                                                {{ in_array('incidents', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexSwitchCheckDefault3">Incidents
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section: Demographics -->
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <h5 class="mb-4">Bed Mapping</h5>

                                        <div class="form-check form-check-inline form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefaultDemographics1" name="permissions[]"
                                                   value="bed_mapping_view"
                                                {{ in_array('bed_mapping_view', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexSwitchCheckDefaultDemographics1">View</label>
                                        </div>

                                        <div class="form-check form-check-inline form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefaultDemographics2" name="permissions[]"
                                                   value="insurance"
                                                {{ in_array('assign_patient', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexSwitchCheckDefaultDemographics2">Assign
                                                Patients</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section: Demographics -->
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <h5 class="mb-4">Demographics</h5>

                                        <div class="form-check form-check-inline form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefaultDemographics1" name="permissions[]"
                                                   value="demographics"
                                                {{ in_array('demographics', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexSwitchCheckDefaultDemographics1">Demographics</label>
                                        </div>

                                        <div class="form-check form-check-inline form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefaultDemographics2" name="permissions[]"
                                                   value="insurance"
                                                {{ in_array('insurance', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexSwitchCheckDefaultDemographics2">Insurance</label>
                                        </div>

                                        <div class="form-check form-check-inline form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefaultDemographics3" name="permissions[]"
                                                   value="contact"
                                                {{ in_array('contact', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexSwitchCheckDefaultDemographics3">Contact</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section: Admissions -->
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <h5 class="mb-4">Admissions</h5>

                                        <div class="form-check form-check-inline form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefaultAdmissions1" name="permissions[]"
                                                   value="admission_add"
                                                {{ in_array('admission_add', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                   for="flexSwitchCheckDefaultAdmissions1">Add</label>
                                        </div>

                                        <div class="form-check form-check-inline form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefaultAdmissions2" name="permissions[]"
                                                   value="admission_view"
                                                {{ in_array('admission_view', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                   for="flexSwitchCheckDefaultAdmissions2">View</label>
                                        </div>

                                        <div class="form-check form-check-inline form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefaultAdmissions3" name="permissions[]"
                                                   value="admission_discharge"
                                                {{ in_array('admission_discharge', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexSwitchCheckDefaultAdmissions3">Discharge</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section: Problems -->
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <h5 class="mb-4">Problems</h5>

                                        <div class="form-check form-check-inline form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefaultAdmissions1" name="permissions[]"
                                                   value="problem_add"
                                                {{ in_array('problem_add', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                   for="flexSwitchCheckDefaultAdmissions1">Add</label>
                                        </div>

                                        <div class="form-check form-check-inline form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefaultAdmissions2" name="permissions[]"
                                                   value="problem_view"
                                                {{ in_array('problem_view', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                   for="flexSwitchCheckDefaultAdmissions2">View</label>
                                        </div>

                                        <div class="form-check form-check-inline form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefaultAdmissions3" name="permissions[]"
                                                   value="problem_edit"
                                                {{ in_array('problem_edit', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                   for="flexSwitchCheckDefaultAdmissions3">Edit</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section: Allergies -->
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <h5 class="mb-4">Allergies</h5>

                                        <div class="form-check form-check-inline form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefaultAdmissions1" name="permissions[]"
                                                   value="allergies_add"
                                                {{ in_array('allergies_add', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                   for="flexSwitchCheckDefaultAdmissions1">Add</label>
                                        </div>

                                        <div class="form-check form-check-inline form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefaultAdmissions2" name="permissions[]"
                                                   value="allergies_view"
                                                {{ in_array('allergies_view', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                   for="flexSwitchCheckDefaultAdmissions2">View</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section: Medications -->
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <h5 class="mb-4">Medications</h5>

                                        <div class="form-check form-check-inline form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefaultAdmissions1" name="permissions[]"
                                                   value="medication_add"
                                                {{ in_array('medication_add', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                   for="flexSwitchCheckDefaultAdmissions1">Add</label>
                                        </div>

                                        <div class="form-check form-check-inline form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefaultAdmissions2" name="permissions[]"
                                                   value="medication_view"
                                                {{ in_array('medication_view', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                   for="flexSwitchCheckDefaultAdmissions2">View</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section: Speciality Selection -->
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <h5 class="mb-4">Encounters</h5>
                                        <div class="form-check form-check-inline form-switch mb-5">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefault3"
                                                   name="permissions[]" value="encounter_add"
                                                {{ in_array('encounter_add', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexSwitchCheckDefault3">Add</label>
                                        </div>
                                        <div class="form-check form-check-inline form-switch mb-5">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefault3"
                                                   name="permissions[]" value="encounter_view"
                                                {{ in_array('encounter_view', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexSwitchCheckDefault3">View</label>
                                        </div>
                                        <div class="form-check form-check-inline form-switch mb-5">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefault3"
                                                   name="permissions[]" value="encounter_edit"
                                                {{ in_array('encounter_edit', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexSwitchCheckDefault3">Edit</label>
                                        </div>
                                        <div class="form-check form-check-inline form-switch mb-5">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefault3"
                                                   name="permissions[]" value="encounter_details"
                                                {{ in_array('encounter_details', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                   for="flexSwitchCheckDefault3">Details</label>
                                        </div>
                                        <div class="form-check form-check-inline form-switch mb-5">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefault3"
                                                   name="permissions[]" value="encounter_view"
                                                {{ in_array('encounter_view', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexSwitchCheckDefault3">View
                                                PDF</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section: Documents -->
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <h5 class="mb-4">Documents</h5>

                                        <div class="form-check form-check-inline form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefaultAdmissions1" name="permissions[]"
                                                   value="document_add"
                                                {{ in_array('document_add', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                   for="flexSwitchCheckDefaultAdmissions1">Add</label>
                                        </div>

                                        <div class="form-check form-check-inline form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefaultAdmissions2" name="permissions[]"
                                                   value="document_view"
                                                {{ in_array('document_view', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                   for="flexSwitchCheckDefaultAdmissions2">View</label>
                                        </div>

                                        <div class="form-check form-check-inline form-switch mb-5">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefault3"
                                                   name="permissions[]" value="document_preview"
                                                {{ in_array('document_preview', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexSwitchCheckDefault3">Preview
                                                File</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section: Vitals -->
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <h5 class="mb-4">Vitals</h5>

                                        <div class="form-check form-check-inline form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefaultAdmissions1" name="permissions[]"
                                                   value="vital_add"
                                                {{ in_array('vital_add', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                   for="flexSwitchCheckDefaultAdmissions1">Add</label>
                                        </div>

                                        <div class="form-check form-check-inline form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefaultAdmissions2" name="permissions[]"
                                                   value="vital_view"
                                                {{ in_array('vital_view', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                   for="flexSwitchCheckDefaultAdmissions2">View</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section: Vitals -->
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <h5 class="mb-4">Incidents</h5>

                                        <div class="form-check form-check-inline form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefaultAdmissions1" name="permissions[]"
                                                   value="medical_incident"
                                                {{ in_array('medical_incident', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexSwitchCheckDefaultAdmissions1">Medical
                                                Incident</label>
                                        </div>

                                        <div class="form-check form-check-inline form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="flexSwitchCheckDefaultAdmissions2" name="permissions[]"
                                                   value="warning_letter"
                                                {{ in_array('warning_letter', old('permissions', $userPermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexSwitchCheckDefaultAdmissions2">Warning
                                                Letter</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="text-center pt-15">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="indicator-label">Submit</span>
                                    </button>
                                </div>

                            </div>
                        </form>

                        <!--end::Form-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Feeds Widget 1-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->
    </div>

@endsection
@section('custom_js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#kt_modal_add_user_form').submit(function (event) {
                event.preventDefault();

                var permissions = [];
                $('input[name="permissions[]"]:checked').each(function () {
                    permissions.push($(this).val());
                });

                if (permissions.length === 0) {
                    alert('Please select at least one permission!');
                    return false;
                }

                $(this).unbind('submit').submit();
            });
        });
    </script>
@endsection
