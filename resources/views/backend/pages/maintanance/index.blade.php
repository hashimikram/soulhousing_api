@extends('backend.layout.master')
@section('breadcrumb_title','Maintenance List')
@section('breadcrumb_li_1','Home')
@section('breadcrumb_li_2','Maintenance Management - Maintenance')
@section('breadcrumb_href', route('dashboard'))
@section('additional_management_li', 'here show')
@section('maintenance_a', 'active')
@section('page_title','All Maintenance Tweets')
@section('content')
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Row-->
        <div class="row g-5 g-xl-8" id="tweets-container">
            <!--begin::Col-->
            @foreach($tweets as $data)
                <div class="col-xl-4 tweet-item">
                    <!--begin::Feeds Widget 1-->
                    <div class="card mb-5 mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body pb-0">
                            <!--begin::Header-->
                            <div class="d-flex align-items-center mb-5">
                                <!--begin::User-->
                                <div class="d-flex align-items-center flex-grow-1">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-45px me-5">
                                        <img src="{{image_url($data->user->details->image)}}" alt="">
                                    </div>
                                    <!--end::Avatar-->
                                    <!--begin::Info-->
                                    <div class="d-flex flex-column">
                                        <a href="#"
                                           class="text-gray-900 text-hover-primary fs-6 fw-bold">{{$data->user->name}}</a>
                                        <span
                                            class="text-gray-400 fw-bold">{{ \Carbon\Carbon::parse($data->created_at)->diffForHumans() }}</span>
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::User-->
                                <!--begin::Menu-->
                                <div class="my-0">
                                    <button type="button"
                                            class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary"
                                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                                        <span class="svg-icon svg-icon-2">
																	<svg xmlns="http://www.w3.org/2000/svg" width="24px"
                                                                         height="24px" viewBox="0 0 24 24">
																		<g stroke="none" stroke-width="1" fill="none"
                                                                           fill-rule="evenodd">
																			<rect x="5" y="5" width="5" height="5"
                                                                                  rx="1" fill="currentColor"></rect>
																			<rect x="14" y="5" width="5" height="5"
                                                                                  rx="1" fill="currentColor"
                                                                                  opacity="0.3"></rect>
																			<rect x="5" y="14" width="5" height="5"
                                                                                  rx="1" fill="currentColor"
                                                                                  opacity="0.3"></rect>
																			<rect x="14" y="14" width="5" height="5"
                                                                                  rx="1" fill="currentColor"
                                                                                  opacity="0.3"></rect>
																		</g>
																	</svg>
																</span>
                                        <!--end::Svg Icon-->
                                    </button>
                                    <!--begin::Menu 2-->
                                    <div
                                        class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
                                        data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <div class="menu-content fs-6 text-dark fw-bold px-3 py-4">Action
                                            </div>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu separator-->
                                        <div class="separator mb-3 opacity-75"></div>
                                        <!--end::Menu separator-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <button
                                                type="button"
                                                class="menu-link px-3 btn btn-transparent show-review-modal"
                                                data-tweet-id="{{$data->id}}"
                                            >
                                                Submit Review
                                            </button>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu 2-->
                                </div>
                                <!--end::Menu-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Post-->
                            <div class="mb-5">
                                <!--begin::Text-->
                                @if(isset($data->file_name))
                                    @php
                                        // Get the file extension
                                        $fileExtension = pathinfo($data->file_name, PATHINFO_EXTENSION);
                                        // Define video extensions
                                        $videoExtensions = ['mp4', 'webm', 'ogg'];
                                    @endphp

                                    @if(in_array(strtolower($fileExtension), $videoExtensions))
                                        <!-- Display video if the file is a video -->
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <video class="embed-responsive-item rounded h-300px w-100" controls>
                                                <source src="{{ image_url($data->file_name) }}"
                                                        type="video/{{ $fileExtension }}">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>
                                    @else
                                        <!-- Display image if the file is not a video -->
                                        <div class="bgi-no-repeat bgi-size-cover rounded min-h-250px mb-5"
                                             style="background-image:url('{{ image_url($data->file_name) }}');"></div>
                                    @endif
                                @endif

                                <p class="text-gray-800 fw-normal mb-5">{{$data->body}}</p>
                                <!--end::Text-->
                                @if($data->comment)
                                    {{-- Admin Review--}}
                                    <div class="mb-5">
                                        <!--begin::Text-->
                                        <p class="text-gray-800 bg-gray-50 fw-normal mb-5 p-1"
                                           style="background-color: #ededed;"><span style="font-weight: 600">Admin Review: </span> {{$data->comment}}
                                        </p>
                                        <!--end::Text-->
                                    </div>
                                @endif
                                <!--begin::Toolbar-->
                                <div class="d-flex align-items-center mb-5">
                                    <a href="#"
                                       class="btn btn-sm btn-light btn-light-success px-4 py-2 me-4 show-comments"
                                       data-tweet-id="{{$data->id}}">
                                        <!--begin::Svg Icon | path: icons/duotune/communication/com012.svg-->
                                        <span class="svg-icon svg-icon-3">
																<svg width="24" height="24" viewBox="0 0 24 24"
                                                                     fill="none" xmlns="http://www.w3.org/2000/svg">
																	<path opacity="0.3"
                                                                          d="M20 3H4C2.89543 3 2 3.89543 2 5V16C2 17.1046 2.89543 18 4 18H4.5C5.05228 18 5.5 18.4477 5.5 19V21.5052C5.5 22.1441 6.21212 22.5253 6.74376 22.1708L11.4885 19.0077C12.4741 18.3506 13.6321 18 14.8167 18H20C21.1046 18 22 17.1046 22 16V5C22 3.89543 21.1046 3 20 3Z"
                                                                          fill="currentColor"></path>
																	<rect x="6" y="12" width="7" height="2" rx="1"
                                                                          fill="currentColor"></rect>
																	<rect x="6" y="7" width="12" height="2" rx="1"
                                                                          fill="currentColor"></rect>
																</svg>
															</span>
                                        <!--end::Svg Icon-->{{$data->comments}}</a>
                                    <a href="#"
                                       class="btn btn-sm btn-light btn-light-danger px-4 py-2 show-likes"
                                       data-tweet-id="{{$data->id}}">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen030.svg-->
                                        <span class="svg-icon svg-icon-2">
																<svg width="24" height="24" viewBox="0 0 24 24"
                                                                     fill="none" xmlns="http://www.w3.org/2000/svg">
																	<path
                                                                        d="M18.3721 4.65439C17.6415 4.23815 16.8052 4 15.9142 4C14.3444 4 12.9339 4.73924 12.003 5.89633C11.0657 4.73913 9.66 4 8.08626 4C7.19611 4 6.35789 4.23746 5.62804 4.65439C4.06148 5.54462 3 7.26056 3 9.24232C3 9.81001 3.08941 10.3491 3.25153 10.8593C4.12155 14.9013 9.69287 20 12.0034 20C14.2502 20 19.875 14.9013 20.7488 10.8593C20.9109 10.3491 21 9.81001 21 9.24232C21.0007 7.26056 19.9383 5.54462 18.3721 4.65439Z"
                                                                        fill="currentColor"></path>
																</svg>
															</span>
                                        <!--end::Svg Icon-->{{$data->likes}}</a>
                                </div>
                                <!--end::Toolbar-->


                            </div>
                            <!--end::Post-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Feeds Widget 1-->
                </div>
            @endforeach
        </div>
        <!--end::Row-->
        <!--begin::Load More-->
        @if(count($tweets) >= 1)
            <div class="d-flex justify-content-center">
                <button class="btn btn-primary" id="load-more-button">Load More</button>
            </div>
        @endif
        <!--end::Load More-->
    </div>
    @include('backend.pages.partials.like_modal')
    @include('backend.pages.partials.comment_modal')
    @include('backend.pages.partials.review_modal')
@endsection

@section('custom_js')
    <script>
        $(document).ready(function () {
            @if($errors->any())
            $('#review_model').modal('show');
            @endif


            let currentPage = 1;
            $('#load-more-button').on('click', function () {
                $('#load-more-button').text('Processing').attr('disabled', true).addClass('loading');

                currentPage++;
                $.ajax({
                    url: '{{ route('tweets.loadMore') }}',
                    type: 'GET',
                    data: {
                        page: currentPage
                    },
                    success: function (data) {
                        $('#load-more-button').text('Load More').attr('disabled', false).removeClass('loading');
                        $('#tweets-container').append(data.html);

                        // Scroll to the bottom of the page
                        $('html, body').animate({
                            scrollTop: $(document).height()
                        }, 500);

                        if (!data.hasMorePages) {
                            $('#load-more-button').hide();
                        }
                    }
                });
            });

            let tweetId = null;

            $(document).on('click', '.show-likes', function (e) {
                e.preventDefault();
                tweetId = $(this).data('tweet-id');
                currentPage = 1;
                $('#likeList').empty();
                $('#loadMoreLikes').show();
                loadLikes(tweetId, currentPage);
                $('#likeModal').modal('show');
            });

            $(document).on('click', '.show-review-modal', function (e) {
                e.preventDefault();
                let tweetId = $(this).data('tweet-id');
                $('#tweet-id-display').val(tweetId);
                $('#review_model').modal('show');
            });

            $('#loadMoreLikes').on('click', function () {
                currentPage++;
                loadLikes(tweetId, currentPage);
            });

            function loadLikes(tweetId, page) {
                $.ajax({
                    url: '/likes',
                    method: 'GET',
                    data: {
                        tweet_id: tweetId,
                        page: page
                    },
                    success: function (response) {
                        response.data.forEach(function (like) {
                            const daysAgo = moment(like.created_at).fromNow();
                            $('#likeList').append(`
                        <div class="d-flex mb-5">
                            <div class="symbol symbol-45px me-5">
                                <img src="${like.image}" alt="${like.name}">
                            </div>
                            <div class="d-flex">
                                <div class="d-flex align-items-center flex-wrap mb-1">
                                    <a href="#" class="text-gray-800 text-hover-primary fw-bold me-2">${like.name}</a>
                                    <span class="text-gray-400 fw-semibold fs-7">${daysAgo}</span>
                                </div>
                            </div>
                        </div>
                    `);
                        });

                        if (response.next_page_url) {
                            $('#loadMoreLikes').show();
                        } else {
                            $('#loadMoreLikes').hide();
                        }
                    }
                });
            }

            $(document).on('click', '.show-comments', function (e) {
                e.preventDefault();
                tweetId = $(this).data('tweet-id');
                currentPage = 1;
                $('#comment_list').empty();
                $('#loadMoreComments').show();
                loadComments(tweetId, currentPage);
                $('#commentModal').modal('show');
            });

            $('#loadMoreComments').on('click', function () {
                currentPage++;
                loadComments(tweetId, currentPage);
            });

            function loadComments(tweetId, page) {
                $.ajax({
                    url: '/comments',
                    method: 'GET',
                    data: {
                        tweet_id: tweetId,
                        page: page
                    },
                    success: function (response) {
                        response.data.forEach(function (comment) {
                            const daysAgo = moment(comment.created_at).fromNow();
                            $('#comment_list').append(`
                        <div class="d-flex mb-5">
                            <div class="symbol symbol-45px me-5">
                                <img src="${comment.image}" alt="${comment.name}">
                            </div>
                            <div class="d-flex flex-column flex-row-fluid">
                                <div class="d-flex align-items-center flex-wrap mb-1">
                                    <a href="#" class="text-gray-800 text-hover-primary fw-bold me-2">${comment.name}</a>
                                    <span class="text-gray-400 fw-semibold fs-7">${daysAgo}</span>
                                </div>
                                    <span class="text-gray-800 fs-7 fw-normal pt-1">${comment.comment}</span>
                            </div>
                        </div
                    `);
                        });

                        if (response.next_page_url) {
                            $('#loadMoreComments').show();
                        } else {
                            $('#loadMoreComments').hide();
                        }
                    }
                });
            }
        });
    </script>
@endsection
