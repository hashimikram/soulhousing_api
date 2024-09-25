@extends('backend.layout.master')
@section('breadcrumb_title', 'Encounter Details')
@section('breadcrumb_li_1', 'Home')
@section('breadcrumb_li_2', 'Encounter - Details')
@section('breadcrumb_href', route('dashboard'))
@section('encounter_management_li', 'here show')
@section('encounter_a', 'active')
@section('page_title', 'Encounter Details')
@section('content')
    <div id="kt_app_content_container" class="app-container">

        <div class="card" style="background-color: #ecf5ff;">
            <!--begin::Body-->
            <div class="card-body p-lg-17">
                <!--begin::Layout-->
                <div class="d-flex flex-column flex-lg-row ">
                    <!--begin::Content-->
                    <div class="flex-lg-row-fluid me-0 me-lg-20">
                        <!--begin::Job-->
                        <div class="">
                            <!--begin::Description-->
                            @foreach ($formattedData as $data)
                                <div class="m-0 mb-4" style="height: 300px !important;
    overflow: auto;    border: 1px solid #e5e5e5;
    padding: 14px;    border-radius: 10px;    background-color: white;">
                                    <!--begin::Title-->
                                    <h4 class="fs-1 text-gray-800 w-bolder mb-6">{{ $data['section_title'] }}</h4>
                                    <!--end::Title-->

                                    <!-- Display section text based on slug -->
                                    @if ($data['section_slug'] == 'wound_evaluation')
                                        @foreach ($data['wound_details'] as $detail)
                                            <!-- Display wound details -->
                                            <div class="mb-3">
                                                <h5>Wound Detail</h5>
                                                <p>{{ $detail['description'] }}</p>
                                                <!-- Display images -->
                                                @if (isset($detail['images']))
                                                    @foreach ($detail['images'] as $image)
                                                        <img src="{{ $image }}" alt="Wound Image" class="img-fluid">
                                                    @endforeach
                                                @endif
                                            </div>
                                        @endforeach
                                    @elseif($data['section_slug'] == 'assessments')
                                        <!-- Display assessments notes -->
                                        @foreach ($data['assessment_notes'] as $note)
                                            <div class="mb-3">
                                                <p>{{ $note }}</p>
                                            </div>
                                        @endforeach
                                    @elseif($data['section_slug'] == 'mental_status_examination')
                                        <!-- Display mental status examination -->
                                        <div class="mb-3">
                                            {!! $data['section_text'] !!}
                                        </div>
                                    @else
                                        <!-- Display other sections -->
                                        <div class="mb-3">
                                            {!! $data['section_text'] !!}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <!--end::Job-->
                    </div>
                    <!--end::Content-->

                </div>
                <!--end::Layout-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Card-->
    </div>
@endsection
