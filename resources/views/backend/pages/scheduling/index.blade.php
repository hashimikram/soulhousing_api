@extends('backend.layout.master')
@section('breadcrumb_title', 'Scheduling List')
@section('breadcrumb_li_1', 'Home')
@section('breadcrumb_li_2', 'Scheduling Management - Scheduling')
@section('breadcrumb_href', route('dashboard'))
@section('scheduling_li', 'here show')
@section('scheduling_a', 'active')
@section('page_title', 'All Scheduling')
@section('content')
    <div id="kt_app_content_container" class="app-container">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <h3 class="card-label">All Scheduling</h3>
                </div>
                <!--begin::Card title-->

            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body py-4">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="">
                    <!--begin::Table head-->
                    <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                        <th class="min-w-125px">Facility</th>
                        <th class="min-w-125px">User</th>
                        <th class="min-w-125px">Member</th>
                        <th class="min-w-125px">Info</th>
                    </tr>
                    <!--end::Table row-->
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody class="text-gray-600 fw-semibold">
                    <!--begin::Table row-->
                    @foreach ($events as $key => $data)
                        <tr>

                            <td>{{ $data->facility->name }}</td>
                            <td class="align-items-center">
                                <div class="d-flex align-items-center me-3">
                                    <div class="symbol symbol-circle symbol-50px overflow-hidden me-2">
                                        <a href="{{ route('user.show', $data->user->id) }}">
                                            <div class="symbol-label">
                                                <img src="{{ image_url($data->user->userDetail->image) }}"
                                                     alt="{{ $data->user->name ?? 'N/A' }}"
                                                     class="w-100"/>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <a href="{{ route('user.show', $data->user->id) }}"
                                           class="text-gray-800 text-hover-primary mb-1">
                                            {{ $data->user->name ?? 'N/A' }}
                                            {{ $data->user->userDetail->last_name ?? 'N/A' }}
                                        </a>
                                        <span>{{ $data->user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="align-items-center">
                                <div class="d-flex align-items-center me-3">
                                    <div class="symbol symbol-circle symbol-50px overflow-hidden me-2">
                                        <a href="{{ route('user.show', $data->member->id) }}">
                                            <div class="symbol-label">
                                                <img src="{{ image_url($data->member->userDetail->image) }}"
                                                     alt="{{ $data->member->name ?? 'N/A' }}"
                                                     class="w-100"/>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <a href="{{ route('user.show', $data->member->id) }}"
                                           class="text-gray-800 text-hover-primary mb-1">
                                            {{ $data->member->name ?? 'N/A' }}
                                            {{ $data->member->userDetail->last_name ?? 'N/A' }}
                                        </a>
                                        <span>{{ $data->member->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="text-gray-800 fw-bolder">Description: {{$data->description}}</span>
                                    <span class="text-gray-800 fw-bolder">Date: {{$data->date}}</span>
                                    <span
                                        class="text-gray-800 fw-bolder">Start Time: {{date('h:s:i a', strtotime($data->time))}}</span>
                                    <span
                                        class="text-gray-800 fw-bolder">End Time: {{date('h:s:i a', strtotime($data->end_time))}}</span>
                                    <span
                                        class="badge badge-light-info fw-bolder">Status: {{ucfirst($data->status)}}</span>
                                </div>
                            </td>

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
