<div class="app-header" id="kt_app_header" style="background-color: #14457b;">
    <!--begin::Header container-->
    <div class="app-container container-fluid d-flex align-items-stretch justify-content-between"
         id="kt_app_header_container">
        <!--begin::sidebar mobile toggle-->
        <div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Show sidebar menu">
            <div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
                <!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
                <span class="svg-icon svg-icon-1">
									<svg fill="none" height="24" viewBox="0 0 24 24" width="24"
                                         xmlns="http://www.w3.org/2000/svg">
										<path
                                            d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z"
                                            fill="currentColor"/>
										<path
                                            d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z"
                                            fill="currentColor"
                                            opacity="0.3"/>
									</svg>
								</span>
                <!--end::Svg Icon-->
            </div>
        </div>
        <!--end::sidebar mobile toggle-->
        <!--begin::Mobile logo-->
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <a class="d-lg-none" href="../../demo1/dist/index.html">
                <img alt="Logo" class="h-30px" src="assets/media/logos/default-small.svg"/>
            </a>
        </div>
        <!--end::Mobile logo-->
        <!--begin::Header wrapper-->
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1"
             id="kt_app_header_wrapper">
            <!--begin::Menu wrapper-->
            <div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true"
                 data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-direction="end"
                 data-kt-drawer-name="app-header-menu" data-kt-drawer-overlay="true"
                 data-kt-drawer-toggle="#kt_app_header_menu_toggle"
                 data-kt-drawer-width="250px" data-kt-swapper="true"
                 data-kt-swapper-mode="{default: 'append', lg: 'prepend'}"
                 data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
                <!--begin::Menu-->
                <div
                    class="menu menu-rounded menu-column menu-lg-row my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0"
                    data-kt-menu="true" id="kt_app_header_menu">
                    <!--begin:Menu item-->
                    <div class="menu-item here show menu-here-bg menu-lg-down-accordion me-0 me-lg-2"
                         data-kt-menu-placement="bottom-start"
                         data-kt-menu-trigger="{default: 'click', lg: 'hover'}">
                        <!--begin:Menu link-->
                        <div class="d-flex justify-content-around align-items-center align-items-stretch">
                            <div class="d-flex justify-content-around align-items-center align-items-stretch">
                                <div class="aiz-topbar-item">
                                    <div class="d-flex align-items-center">
                                        <a class="btn btn-icon btn-circle btn-light"
                                           href="https://championautoengineering.com" target="_blank"
                                           title="Browse Website">
                                            <i class="las la-globe"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <span class="menu-link">
											  <a class="btn btn-danger btn-sm d-flex align-items-center"
                                                 href="https://championautoengineering.com/admin/clear-cache">
                                            <i class="las la-hdd fs-20"></i>
                                            <span class="fw-500 ml-1 mr-0 d-none d-md-block">Clear Cache</span>
                                        </a>
										</span>

                        </div>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                </div>
                <!--end::Menu-->
            </div>
            <!--end::Menu wrapper-->
            <!--begin::Navbar-->
            <div class="app-navbar flex-shrink-0">
                <!--begin::Notifications-->
                <div class="app-navbar-item ms-1 ms-lg-3">
                    <!--begin::Menu- wrapper-->
                    <div
                        class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px w-md-40px h-md-40px"
                        data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end"
                        data-kt-menu-trigger="{default: 'click', lg: 'hover'}">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen022.svg-->
                        <span class="svg-icon svg-icon-1">
											<svg fill="none" height="24" viewBox="0 0 24 24" width="24"
                                                 xmlns="http://www.w3.org/2000/svg">
												<path
                                                    d="M11.2929 2.70711C11.6834 2.31658 12.3166 2.31658 12.7071 2.70711L15.2929 5.29289C15.6834 5.68342 15.6834 6.31658 15.2929 6.70711L12.7071 9.29289C12.3166 9.68342 11.6834 9.68342 11.2929 9.29289L8.70711 6.70711C8.31658 6.31658 8.31658 5.68342 8.70711 5.29289L11.2929 2.70711Z"
                                                    fill="currentColor"/>
												<path
                                                    d="M11.2929 14.7071C11.6834 14.3166 12.3166 14.3166 12.7071 14.7071L15.2929 17.2929C15.6834 17.6834 15.6834 18.3166 15.2929 18.7071L12.7071 21.2929C12.3166 21.6834 11.6834 21.6834 11.2929 21.2929L8.70711 18.7071C8.31658 18.3166 8.31658 17.6834 8.70711 17.2929L11.2929 14.7071Z"
                                                    fill="currentColor"/>
												<path
                                                    d="M5.29289 8.70711C5.68342 8.31658 6.31658 8.31658 6.70711 8.70711L9.29289 11.2929C9.68342 11.6834 9.68342 12.3166 9.29289 12.7071L6.70711 15.2929C6.31658 15.6834 5.68342 15.6834 5.29289 15.2929L2.70711 12.7071C2.31658 12.3166 2.31658 11.6834 2.70711 11.2929L5.29289 8.70711Z"
                                                    fill="currentColor"
                                                    opacity="0.3"/>
												<path
                                                    d="M17.2929 8.70711C17.6834 8.31658 18.3166 8.31658 18.7071 8.70711L21.2929 11.2929C21.6834 11.6834 21.6834 12.3166 21.2929 12.7071L18.7071 15.2929C18.3166 15.6834 17.6834 15.6834 17.2929 15.2929L14.7071 12.7071C14.3166 12.3166 14.3166 11.6834 14.7071 11.2929L17.2929 8.70711Z"
                                                    fill="currentColor"
                                                    opacity="0.3"/>
											</svg>
										</span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px"
                         data-kt-menu="true">
                        <!--begin::Heading-->
                        <div class="d-flex flex-column bgi-no-repeat rounded-top"
                             style="background-image:url('assets/media/misc/menu-header-bg.jpg')">
                            <!--begin::Title-->
                            <h3 class="text-dark fw-semibold px-9 mt-10 mb-6">Notifications
                                <span class="fs-8 opacity-75 ps-3">24 reports</span></h3>
                            <!--end::Title-->
                        </div>
                        <!--end::Heading-->
                        <!--begin::Tab content-->
                        <div class="tab-content">
                            <!--begin::Tab panel-->
                            <div class="tab-pane fade show active" id="kt_topbar_notifications_3" role="tabpanel">
                                <!--begin::Items-->
                                <div class="scroll-y mh-325px my-5 px-8">
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack py-4">
                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center me-2">
                                            <!--begin::Code-->
                                            <span class="w-70px badge badge-light-success me-4">200 OK</span>
                                            <!--end::Code-->
                                            <!--begin::Title-->
                                            <a class="text-gray-800 text-hover-primary fw-semibold" href="#">New
                                                order</a>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Section-->
                                        <!--begin::Label-->
                                        <span class="badge badge-light fs-8">Just now</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack py-4">
                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center me-2">
                                            <!--begin::Code-->
                                            <span class="w-70px badge badge-light-danger me-4">500 ERR</span>
                                            <!--end::Code-->
                                            <!--begin::Title-->
                                            <a class="text-gray-800 text-hover-primary fw-semibold" href="#">New
                                                customer</a>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Section-->
                                        <!--begin::Label-->
                                        <span class="badge badge-light fs-8">2 hrs</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack py-4">
                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center me-2">
                                            <!--begin::Code-->
                                            <span class="w-70px badge badge-light-success me-4">200 OK</span>
                                            <!--end::Code-->
                                            <!--begin::Title-->
                                            <a class="text-gray-800 text-hover-primary fw-semibold" href="#">Payment
                                                process</a>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Section-->
                                        <!--begin::Label-->
                                        <span class="badge badge-light fs-8">5 hrs</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack py-4">
                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center me-2">
                                            <!--begin::Code-->
                                            <span class="w-70px badge badge-light-warning me-4">300 WRN</span>
                                            <!--end::Code-->
                                            <!--begin::Title-->
                                            <a class="text-gray-800 text-hover-primary fw-semibold" href="#">Search
                                                query</a>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Section-->
                                        <!--begin::Label-->
                                        <span class="badge badge-light fs-8">2 days</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack py-4">
                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center me-2">
                                            <!--begin::Code-->
                                            <span class="w-70px badge badge-light-success me-4">200 OK</span>
                                            <!--end::Code-->
                                            <!--begin::Title-->
                                            <a class="text-gray-800 text-hover-primary fw-semibold" href="#">API
                                                connection</a>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Section-->
                                        <!--begin::Label-->
                                        <span class="badge badge-light fs-8">1 week</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack py-4">
                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center me-2">
                                            <!--begin::Code-->
                                            <span class="w-70px badge badge-light-success me-4">200 OK</span>
                                            <!--end::Code-->
                                            <!--begin::Title-->
                                            <a class="text-gray-800 text-hover-primary fw-semibold" href="#">Database
                                                restore</a>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Section-->
                                        <!--begin::Label-->
                                        <span class="badge badge-light fs-8">Mar 5</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack py-4">
                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center me-2">
                                            <!--begin::Code-->
                                            <span class="w-70px badge badge-light-warning me-4">300 WRN</span>
                                            <!--end::Code-->
                                            <!--begin::Title-->
                                            <a class="text-gray-800 text-hover-primary fw-semibold" href="#">System
                                                update</a>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Section-->
                                        <!--begin::Label-->
                                        <span class="badge badge-light fs-8">May 15</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack py-4">
                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center me-2">
                                            <!--begin::Code-->
                                            <span class="w-70px badge badge-light-warning me-4">300 WRN</span>
                                            <!--end::Code-->
                                            <!--begin::Title-->
                                            <a class="text-gray-800 text-hover-primary fw-semibold" href="#">Server
                                                OS update</a>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Section-->
                                        <!--begin::Label-->
                                        <span class="badge badge-light fs-8">Apr 3</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack py-4">
                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center me-2">
                                            <!--begin::Code-->
                                            <span class="w-70px badge badge-light-warning me-4">300 WRN</span>
                                            <!--end::Code-->
                                            <!--begin::Title-->
                                            <a class="text-gray-800 text-hover-primary fw-semibold" href="#">API
                                                rollback</a>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Section-->
                                        <!--begin::Label-->
                                        <span class="badge badge-light fs-8">Jun 30</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack py-4">
                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center me-2">
                                            <!--begin::Code-->
                                            <span class="w-70px badge badge-light-danger me-4">500 ERR</span>
                                            <!--end::Code-->
                                            <!--begin::Title-->
                                            <a class="text-gray-800 text-hover-primary fw-semibold" href="#">Refund
                                                process</a>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Section-->
                                        <!--begin::Label-->
                                        <span class="badge badge-light fs-8">Jul 10</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack py-4">
                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center me-2">
                                            <!--begin::Code-->
                                            <span class="w-70px badge badge-light-danger me-4">500 ERR</span>
                                            <!--end::Code-->
                                            <!--begin::Title-->
                                            <a class="text-gray-800 text-hover-primary fw-semibold" href="#">Withdrawal
                                                process</a>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Section-->
                                        <!--begin::Label-->
                                        <span class="badge badge-light fs-8">Sep 10</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack py-4">
                                        <!--begin::Section-->
                                        <div class="d-flex align-items-center me-2">
                                            <!--begin::Code-->
                                            <span class="w-70px badge badge-light-danger me-4">500 ERR</span>
                                            <!--end::Code-->
                                            <!--begin::Title-->
                                            <a class="text-gray-800 text-hover-primary fw-semibold" href="#">Mail
                                                tasks</a>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Section-->
                                        <!--begin::Label-->
                                        <span class="badge badge-light fs-8">Dec 10</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->
                                </div>
                                <!--end::Items-->
                                <!--begin::View more-->
                                <div class="py-3 text-center border-top">
                                    <a class="btn btn-color-gray-600 btn-active-color-primary"
                                       href="../../demo1/dist/pages/user-profile/activity.html">View All
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                        <span class="svg-icon svg-icon-5">
														<svg fill="none" height="24" viewBox="0 0 24 24" width="24"
                                                             xmlns="http://www.w3.org/2000/svg">
															<rect fill="currentColor" height="2" opacity="0.5" rx="1"
                                                                  transform="rotate(-180 18 13)"
                                                                  width="13" x="18"
                                                                  y="13"/>
															<path
                                                                d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                                fill="currentColor"/>
														</svg>
													</span>
                                        <!--end::Svg Icon--></a>
                                </div>
                                <!--end::View more-->
                            </div>
                            <!--end::Tab panel-->
                        </div>
                        <!--end::Tab content-->
                    </div>
                    <!--end::Menu-->
                    <!--end::Menu wrapper-->
                </div>
                <!--end::Notifications-->
                <!--begin::User menu-->
                <div class="app-navbar-item ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
                    <!--begin::Menu wrapper-->
                    <div class="cursor-pointer symbol symbol-35px symbol-md-40px"
                         data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end"
                         data-kt-menu-trigger="{default: 'click', lg: 'hover'}">
                        <img alt="user" src="{{asset('backend/assets/media/auth/logo-center.png')}}"/>
                    </div>
                    <!--begin::User account menu-->
                    <div
                        class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                        data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <div class="menu-content d-flex align-items-center px-3">
                                <!--begin::Avatar-->
                                <div class="symbol symbol-50px me-5">
                                    <img alt="Logo" src="{{asset('backend/assets/media/auth/logo-center.png')}}"/>
                                </div>
                                <!--end::Avatar-->
                                <!--begin::Username-->
                                <div class="d-flex flex-column">
                                    <div class="fw-bold d-flex align-items-center fs-5">{{auth()->user()->name}}
                                        <span
                                            class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Pro</span>
                                    </div>
                                    <a class="fw-semibold text-muted text-hover-primary fs-7"
                                       href="#">{{auth()->user()->email}}</a>
                                </div>
                                <!--end::Username-->
                            </div>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator my-2"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <a class="menu-link px-5" href="../../demo1/dist/account/overview.html">My
                                Profile</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5 my-1">
                            <a class="menu-link px-5" href="../../demo1/dist/account/settings.html">Account
                                Settings</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="menu-link px-5 btn btn-transparent"> Sign
                                    Out
                                </button>
                            </form>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::User account menu-->
                    <!--end::Menu wrapper-->
                </div>
                <!--end::User menu-->
                <!--begin::Header menu toggle-->
                <div class="app-navbar-item d-lg-none ms-2 me-n3" title="Show header menu">
                    <div class="btn btn-icon btn-active-color-primary w-35px h-35px"
                         id="kt_app_header_menu_toggle">
                        <!--begin::Svg Icon | path: icons/duotune/text/txt001.svg-->
                        <span class="svg-icon svg-icon-1">
											<svg fill="none" height="24" viewBox="0 0 24 24" width="24"
                                                 xmlns="http://www.w3.org/2000/svg">
												<path
                                                    d="M13 11H3C2.4 11 2 10.6 2 10V9C2 8.4 2.4 8 3 8H13C13.6 8 14 8.4 14 9V10C14 10.6 13.6 11 13 11ZM22 5V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4V5C2 5.6 2.4 6 3 6H21C21.6 6 22 5.6 22 5Z"
                                                    fill="currentColor"/>
												<path
                                                    d="M21 16H3C2.4 16 2 15.6 2 15V14C2 13.4 2.4 13 3 13H21C21.6 13 22 13.4 22 14V15C22 15.6 21.6 16 21 16ZM14 20V19C14 18.4 13.6 18 13 18H3C2.4 18 2 18.4 2 19V20C2 20.6 2.4 21 3 21H13C13.6 21 14 20.6 14 20Z"
                                                    fill="currentColor"
                                                    opacity="0.3"/>
											</svg>
										</span>
                        <!--end::Svg Icon-->
                    </div>
                </div>
                <!--end::Header menu toggle-->
            </div>
            <!--end::Navbar-->
        </div>
        <!--end::Header wrapper-->
    </div>
    <!--end::Header container-->
</div>
