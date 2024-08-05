@extends('backend.layout.master')
@section('breadcrumb_title','Dashboard')
@section('breadcrumb_li_1','Home')
@section('breadcrumb_li_2','Dashboard')
@section('breadcrumb_href', route('dashboard'))
@section('dashboard_li', 'here show')
@section('dashboard_a', 'active')
@section('page_title','Admin Dashboard')
@section('content')
    <div class="app-container container-fluid" id="kt_app_content_container">
        <!--begin::Row-->
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <!--begin::Col-->
            <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                <!--begin::Card widget 20-->
                <div
                    class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end mb-5 mb-xl-10"
                    style="background-color: #F1416C;background-image:url('{{asset('backend/assets/media/patterns/vector-1.png')}}">
                    <!--begin::Header-->
                    <div class="card-header pt-5">
                        <!--begin::Title-->
                        <div class="card-title d-flex flex-column">
                            <!--begin::Amount-->
                            <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">69</span>
                            <!--end::Amount-->
                            <!--begin::Subtitle-->
                            <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Active Patients</span>
                            <div class="text-inverse-dark bg-dark p-2">You Are Login
                                as {{ucfirst(auth()->user()->user_type)}}</div>
                            <!--end::Subtitle-->
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Header-->
                </div>
                <!--end::Card widget 20-->
            </div>
            <!--end::Col-->


        </div>
        <!--end::Row-->
    </div>
@endsection
