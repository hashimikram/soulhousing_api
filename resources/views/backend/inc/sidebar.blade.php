<div class="app-sidebar flex-column" data-kt-drawer="true"
     data-kt-drawer-activate="{default: true, lg: false}"
     data-kt-drawer-direction="start" data-kt-drawer-name="app-sidebar"
     data-kt-drawer-overlay="true" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle"
     data-kt-drawer-width="225px"
     id="kt_app_sidebar" style="background-color: #14457b;">
    <!--begin::Logo-->
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <!--begin::Logo image-->
        <a href="{{route('dashboard')}}">
            <img alt="Logo" class="h-45px app-sidebar-logo-default"
                 src="{{asset('backend/assets/media/auth/logo-center-white.png')}}"/>
            <img alt="Logo" class="h-20px app-sidebar-logo-minimize"
                 src="{{asset('backend/assets/media/auth/logo-center-white.png')}}"/>
        </a>
        <!--end::Logo image-->
        <!--begin::Sidebar toggle-->
        <div
            class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
            data-kt-toggle="true"
            data-kt-toggle-name="app-sidebar-minimize" data-kt-toggle-state="active"
            data-kt-toggle-target="body"
            id="kt_app_sidebar_toggle">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr079.svg-->
            <span class="svg-icon svg-icon-2 rotate-180">
									<svg fill="none" height="24" viewBox="0 0 24 24" width="24"
                                         xmlns="http://www.w3.org/2000/svg">
										<path
                                            d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                                            fill="currentColor"
                                            opacity="0.5"/>
										<path
                                            d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                                            fill="currentColor"/>
									</svg>
								</span>
            <!--end::Svg Icon-->
        </div>
        <!--end::Sidebar toggle-->
    </div>
    <!--end::Logo-->
    <!--begin::sidebar menu-->
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <!--begin::Menu wrapper-->
        <div class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true"
             data-kt-scroll-activate="true"
             data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
             data-kt-scroll-height="auto"
             data-kt-scroll-offset="5px"
             data-kt-scroll-save-state="true" data-kt-scroll-wrappers="#kt_app_sidebar_menu"
             id="kt_app_sidebar_menu_wrapper">
            <!--begin::Menu-->
            <div class="menu menu-column menu-rounded menu-sub-indention px-3" data-kt-menu="true"
                 data-kt-menu-expand="false" id="#kt_app_sidebar_menu">
                <!--begin:Menu item-->
                <div class="menu-item @yield('dashboard_li') menu-accordion" data-kt-menu-trigger="click">
                    <!--begin:Menu link-->
                    <span class="menu-link">
											<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
												<span class="svg-icon svg-icon-2">
													<svg fill="none" height="24" viewBox="0 0 24 24" width="24"
                                                         xmlns="http://www.w3.org/2000/svg">
														<rect fill="currentColor" height="9" rx="2" width="9" x="2"
                                                              y="2"/>
														<rect fill="currentColor" height="9" opacity="0.3" rx="2"
                                                              width="9" x="13"
                                                              y="2"/>
														<rect fill="currentColor" height="9" opacity="0.3" rx="2"
                                                              width="9" x="13"
                                                              y="13"/>
														<rect fill="currentColor" height="9" opacity="0.3" rx="2"
                                                              width="9" x="2"
                                                              y="13"/>
													</svg>
												</span>
                                                <!--end::Svg Icon-->
											</span>
											<span class="menu-title">Dashboards</span>
											<span class="menu-arrow"></span>
										</span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link  @yield('dashboard_a')" href="{{route("dashboard")}}">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                                <span class="menu-title">Default</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->
                <!--begin:Menu item-->
                <div class="menu-item pt-5">
                    <!--begin:Menu content-->
                    <div class="menu-content">
                        <span class="menu-heading fw-bold text-uppercase fs-7">Apps</span>
                    </div>
                    <!--end:Menu content-->
                </div>
                <!--end:Menu item-->
                @php
                    $user=\App\Models\RoleUser::where('user_id',auth()->user()->id)->first();
                    $permission = [];
                    if(isset($user)){
                        $role=\App\Models\Role::where('id',$user->role_id)->first();
                        $permission=\App\Models\Permission::where('role_id',$role->id)->first();
                    }
                @endphp
                    <!--begin:Menu item-->
                @if(Auth::user()->user_type == 'super_admin' || in_array('1', json_decode($permission->permissions)))
                    <div class="menu-item @yield('user_management_li') menu-accordion" data-kt-menu-trigger="click">
                        <!--begin:Menu link-->
                        <span class="menu-link">
											<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/abstract/abs029.svg-->
												<span class="svg-icon svg-icon-2">
													<svg fill="none" height="24" viewBox="0 0 24 24" width="24"
                                                         xmlns="http://www.w3.org/2000/svg">
														<path
                                                            d="M6.5 11C8.98528 11 11 8.98528 11 6.5C11 4.01472 8.98528 2 6.5 2C4.01472 2 2 4.01472 2 6.5C2 8.98528 4.01472 11 6.5 11Z"
                                                            fill="currentColor"/>
														<path
                                                            d="M13 6.5C13 4 15 2 17.5 2C20 2 22 4 22 6.5C22 9 20 11 17.5 11C15 11 13 9 13 6.5ZM6.5 22C9 22 11 20 11 17.5C11 15 9 13 6.5 13C4 13 2 15 2 17.5C2 20 4 22 6.5 22ZM17.5 22C20 22 22 20 22 17.5C22 15 20 13 17.5 13C15 13 13 15 13 17.5C13 20 15 22 17.5 22Z"
                                                            fill="currentColor"
                                                            opacity="0.3"/>
													</svg>
												</span>
                                                <!--end::Svg Icon-->
											</span>
											<span class="menu-title">User Management</span>
											<span class="menu-arrow"></span>
										</span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link  @yield('users_a')" href="{{route('user.index')}}">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                                    <span class="menu-title">Users</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->
                        </div>
                        <!--end:Menu sub-->
                    </div>
                @endif
                <!--end:Menu item-->
                <!--begin:Menu item-->
                @if(Auth::user()->user_type == 'super_admin' || in_array('5', json_decode($permission->permissions)))
                    <div class="menu-item @yield('patients_management_li') menu-accordion" data-kt-menu-trigger="click">
                        <!--begin:Menu link-->
                        <span class="menu-link">
											<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/abstract/abs029.svg-->
												<span class="svg-icon svg-icon-2">
													<svg fill="none" height="24" viewBox="0 0 24 24" width="24"
                                                         xmlns="http://www.w3.org/2000/svg">
														<path
                                                            d="M6.5 11C8.98528 11 11 8.98528 11 6.5C11 4.01472 8.98528 2 6.5 2C4.01472 2 2 4.01472 2 6.5C2 8.98528 4.01472 11 6.5 11Z"
                                                            fill="currentColor"/>
														<path
                                                            d="M13 6.5C13 4 15 2 17.5 2C20 2 22 4 22 6.5C22 9 20 11 17.5 11C15 11 13 9 13 6.5ZM6.5 22C9 22 11 20 11 17.5C11 15 9 13 6.5 13C4 13 2 15 2 17.5C2 20 4 22 6.5 22ZM17.5 22C20 22 22 20 22 17.5C22 15 20 13 17.5 13C15 13 13 15 13 17.5C13 20 15 22 17.5 22Z"
                                                            fill="currentColor"
                                                            opacity="0.3"/>
													</svg>
												</span>
                                                <!--end::Svg Icon-->
											</span>
											<span class="menu-title">Patient Management</span>
											<span class="menu-arrow"></span>
										</span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link  @yield('patients_a')" href="{{route('patients.index')}}">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                                    <span class="menu-title">Patients</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->
                        </div>
                        <!--end:Menu sub-->
                    </div>
                @endif
                <!--end:Menu item-->
                <!--begin:Menu item-->
                @if(Auth::user()->user_type == 'super_admin' || in_array('2', json_decode($permission->permissions)))
                    <div class="menu-item @yield('facility_management_li') menu-accordion" data-kt-menu-trigger="click">
                        <!--begin:Menu link-->
                        <span class="menu-link">
											<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/abstract/abs029.svg-->
												<span class="svg-icon svg-icon-2">
													<svg fill="none" height="24" viewBox="0 0 24 24" width="24"
                                                         xmlns="http://www.w3.org/2000/svg">
														<path
                                                            d="M6.5 11C8.98528 11 11 8.98528 11 6.5C11 4.01472 8.98528 2 6.5 2C4.01472 2 2 4.01472 2 6.5C2 8.98528 4.01472 11 6.5 11Z"
                                                            fill="currentColor"/>
														<path
                                                            d="M13 6.5C13 4 15 2 17.5 2C20 2 22 4 22 6.5C22 9 20 11 17.5 11C15 11 13 9 13 6.5ZM6.5 22C9 22 11 20 11 17.5C11 15 9 13 6.5 13C4 13 2 15 2 17.5C2 20 4 22 6.5 22ZM17.5 22C20 22 22 20 22 17.5C22 15 20 13 17.5 13C15 13 13 15 13 17.5C13 20 15 22 17.5 22Z"
                                                            fill="currentColor"
                                                            opacity="0.3"/>
													</svg>
												</span>
                                                <!--end::Svg Icon-->
											</span>
											<span class="menu-title">Facility</span>
											<span class="menu-arrow"></span>
										</span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link  @yield('facility_a')" href="{{route('facility.index')}}">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                                    <span class="menu-title">Manage</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->
                        </div>
                        <!--end:Menu sub-->
                    </div>
                @endif
                <!--end:Menu item-->
                <!--begin:Menu item-->
                @if(Auth::user()->user_type == 'super_admin' || in_array('3', json_decode($permission->permissions)))
                    <div class="menu-item @yield('floors_management_li') menu-accordion" data-kt-menu-trigger="click">
                        <!--begin:Menu link-->
                        <span class="menu-link">
											<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/abstract/abs029.svg-->
												<span class="svg-icon svg-icon-2">
													<svg fill="none" height="24" viewBox="0 0 24 24" width="24"
                                                         xmlns="http://www.w3.org/2000/svg">
														<path
                                                            d="M6.5 11C8.98528 11 11 8.98528 11 6.5C11 4.01472 8.98528 2 6.5 2C4.01472 2 2 4.01472 2 6.5C2 8.98528 4.01472 11 6.5 11Z"
                                                            fill="currentColor"/>
														<path
                                                            d="M13 6.5C13 4 15 2 17.5 2C20 2 22 4 22 6.5C22 9 20 11 17.5 11C15 11 13 9 13 6.5ZM6.5 22C9 22 11 20 11 17.5C11 15 9 13 6.5 13C4 13 2 15 2 17.5C2 20 4 22 6.5 22ZM17.5 22C20 22 22 20 22 17.5C22 15 20 13 17.5 13C15 13 13 15 13 17.5C13 20 15 22 17.5 22Z"
                                                            fill="currentColor"
                                                            opacity="0.3"/>
													</svg>
												</span>
                                                <!--end::Svg Icon-->
											</span>
											<span class="menu-title">Floors Management</span>
											<span class="menu-arrow"></span>
										</span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link  @yield('floors_a')" href="{{route('floors.index')}}">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                                    <span class="menu-title">Manage</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->
                        </div>
                        <!--end:Menu sub-->
                    </div>
                @endif
                <!--end:Menu item-->
                <!--begin:Menu item-->
                @if(Auth::user()->user_type == 'super_admin')
                    <div class="menu-item @yield('roles_management_li') menu-accordion" data-kt-menu-trigger="click">
                        <!--begin:Menu link-->
                        <span class="menu-link">
											<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/abstract/abs029.svg-->
												<span class="svg-icon svg-icon-2">
													<svg fill="none" height="24" viewBox="0 0 24 24" width="24"
                                                         xmlns="http://www.w3.org/2000/svg">
														<path
                                                            d="M6.5 11C8.98528 11 11 8.98528 11 6.5C11 4.01472 8.98528 2 6.5 2C4.01472 2 2 4.01472 2 6.5C2 8.98528 4.01472 11 6.5 11Z"
                                                            fill="currentColor"/>
														<path
                                                            d="M13 6.5C13 4 15 2 17.5 2C20 2 22 4 22 6.5C22 9 20 11 17.5 11C15 11 13 9 13 6.5ZM6.5 22C9 22 11 20 11 17.5C11 15 9 13 6.5 13C4 13 2 15 2 17.5C2 20 4 22 6.5 22ZM17.5 22C20 22 22 20 22 17.5C22 15 20 13 17.5 13C15 13 13 15 13 17.5C13 20 15 22 17.5 22Z"
                                                            fill="currentColor"
                                                            opacity="0.3"/>
													</svg>
												</span>
                                                <!--end::Svg Icon-->
											</span>
											<span class="menu-title">Roles</span>
											<span class="menu-arrow"></span>
										</span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link  @yield('roles_a')" href="{{route('roles.index')}}">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                                    <span class="menu-title">Manage</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->
                            <!--begin:Menu item-->
                            {{--                            <div class="menu-item">--}}
                            {{--                                <!--begin:Menu link-->--}}
                            {{--                                <a class="menu-link  @yield('staff_a')" href="{{route('staff.index')}}">--}}
                            {{--													<span class="menu-bullet">--}}
                            {{--														<span class="bullet bullet-dot"></span>--}}
                            {{--													</span>--}}
                            {{--                                    <span class="menu-title">Sub Admins</span>--}}
                            {{--                                </a>--}}
                            {{--                                <!--end:Menu link-->--}}
                            {{--                            </div>--}}
                            <!--end:Menu item-->
                        </div>
                        <!--end:Menu sub-->
                    </div>
                @endif
                <!--end:Menu item-->
                <!--begin:Menu item-->
                @if(Auth::user()->user_type == 'super_admin' || in_array('4', json_decode($permission->permissions)))
                    <div class="menu-item @yield('additional_management_li') menu-accordion"
                         data-kt-menu-trigger="click">
                        <!--begin:Menu link-->
                        <span class="menu-link">
											<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/abstract/abs029.svg-->
												<span class="svg-icon svg-icon-2">
													<svg fill="none" height="24" viewBox="0 0 24 24" width="24"
                                                         xmlns="http://www.w3.org/2000/svg">
														<path
                                                            d="M6.5 11C8.98528 11 11 8.98528 11 6.5C11 4.01472 8.98528 2 6.5 2C4.01472 2 2 4.01472 2 6.5C2 8.98528 4.01472 11 6.5 11Z"
                                                            fill="currentColor"/>
														<path
                                                            d="M13 6.5C13 4 15 2 17.5 2C20 2 22 4 22 6.5C22 9 20 11 17.5 11C15 11 13 9 13 6.5ZM6.5 22C9 22 11 20 11 17.5C11 15 9 13 6.5 13C4 13 2 15 2 17.5C2 20 4 22 6.5 22ZM17.5 22C20 22 22 20 22 17.5C22 15 20 13 17.5 13C15 13 13 15 13 17.5C13 20 15 22 17.5 22Z"
                                                            fill="currentColor"
                                                            opacity="0.3"/>
													</svg>
												</span>
                                                <!--end::Svg Icon-->
											</span>
											<span class="menu-title">Maintenance</span>
											<span class="menu-arrow"></span>
										</span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link  @yield('maintenance_a')"
                                   href="{{route('maintenance.admin_index')}}">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                                    <span class="menu-title">Manage</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->
                        </div>
                        <!--end:Menu sub-->
                    </div>
                @endif
                <!--end:Menu item-->
                <!--begin:Menu item-->
                @if(Auth::user()->user_type == 'super_admin' || in_array('7', json_decode($permission->permissions)))
                    <div class="menu-item @yield('operation_management_li') menu-accordion"
                         data-kt-menu-trigger="click">
                        <!--begin:Menu link-->
                        <span class="menu-link">
											<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/abstract/abs029.svg-->
												<span class="svg-icon svg-icon-2">
													<svg fill="none" height="24" viewBox="0 0 24 24" width="24"
                                                         xmlns="http://www.w3.org/2000/svg">
														<path
                                                            d="M6.5 11C8.98528 11 11 8.98528 11 6.5C11 4.01472 8.98528 2 6.5 2C4.01472 2 2 4.01472 2 6.5C2 8.98528 4.01472 11 6.5 11Z"
                                                            fill="currentColor"/>
														<path
                                                            d="M13 6.5C13 4 15 2 17.5 2C20 2 22 4 22 6.5C22 9 20 11 17.5 11C15 11 13 9 13 6.5ZM6.5 22C9 22 11 20 11 17.5C11 15 9 13 6.5 13C4 13 2 15 2 17.5C2 20 4 22 6.5 22ZM17.5 22C20 22 22 20 22 17.5C22 15 20 13 17.5 13C15 13 13 15 13 17.5C13 20 15 22 17.5 22Z"
                                                            fill="currentColor"
                                                            opacity="0.3"/>
													</svg>
												</span>
                                                <!--end::Svg Icon-->
											</span>
											<span class="menu-title">Operations</span>
											<span class="menu-arrow"></span>
										</span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link  @yield('operation_a')"
                                   href="{{route('operations.index')}}">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                                    <span class="menu-title">Manage</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->
                        </div>
                        <!--end:Menu sub-->
                    </div>
                @endif
                <!--end:Menu item-->
                <!--begin:Menu item-->
                @if(Auth::user()->user_type == 'super_admin' || in_array('6', json_decode($permission->permissions)))
                    <div class="menu-item @yield('sub_admin_management_li') menu-accordion"
                         data-kt-menu-trigger="click">
                        <!--begin:Menu link-->
                        <span class="menu-link">
											<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/abstract/abs029.svg-->
												<span class="svg-icon svg-icon-2">
													<svg fill="none" height="24" viewBox="0 0 24 24" width="24"
                                                         xmlns="http://www.w3.org/2000/svg">
														<path
                                                            d="M6.5 11C8.98528 11 11 8.98528 11 6.5C11 4.01472 8.98528 2 6.5 2C4.01472 2 2 4.01472 2 6.5C2 8.98528 4.01472 11 6.5 11Z"
                                                            fill="currentColor"/>
														<path
                                                            d="M13 6.5C13 4 15 2 17.5 2C20 2 22 4 22 6.5C22 9 20 11 17.5 11C15 11 13 9 13 6.5ZM6.5 22C9 22 11 20 11 17.5C11 15 9 13 6.5 13C4 13 2 15 2 17.5C2 20 4 22 6.5 22ZM17.5 22C20 22 22 20 22 17.5C22 15 20 13 17.5 13C15 13 13 15 13 17.5C13 20 15 22 17.5 22Z"
                                                            fill="currentColor"
                                                            opacity="0.3"/>
													</svg>
												</span>
                                                <!--end::Svg Icon-->
											</span>
											<span class="menu-title">Sub Admin</span>
											<span class="menu-arrow"></span>
										</span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link  @yield('sub_admin_a')" href="{{route('sub-admin.index')}}">
                          												<span class="menu-bullet">
                          														<span class="bullet bullet-dot"></span>
                           													</span>
                                    <span class="menu-title">Sub Admins</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->
                        </div>
                        <!--end:Menu sub-->
                    </div>
                @endif
                <!--end:Menu item-->
                <!--begin:Menu item-->
                @if(Auth::user()->user_type == 'super_admin' || in_array('8', json_decode($permission->permissions)))
                    <div class="menu-item @yield('encounter_management_li') menu-accordion"
                         data-kt-menu-trigger="click">
                        <!--begin:Menu link-->
                        <span class="menu-link">
											<span class="menu-icon">
												<!--begin::Svg Icon | path: icons/duotune/abstract/abs029.svg-->
												<span class="svg-icon svg-icon-2">
													<svg fill="none" height="24" viewBox="0 0 24 24" width="24"
                                                         xmlns="http://www.w3.org/2000/svg">
														<path
                                                            d="M6.5 11C8.98528 11 11 8.98528 11 6.5C11 4.01472 8.98528 2 6.5 2C4.01472 2 2 4.01472 2 6.5C2 8.98528 4.01472 11 6.5 11Z"
                                                            fill="currentColor"/>
														<path
                                                            d="M13 6.5C13 4 15 2 17.5 2C20 2 22 4 22 6.5C22 9 20 11 17.5 11C15 11 13 9 13 6.5ZM6.5 22C9 22 11 20 11 17.5C11 15 9 13 6.5 13C4 13 2 15 2 17.5C2 20 4 22 6.5 22ZM17.5 22C20 22 22 20 22 17.5C22 15 20 13 17.5 13C15 13 13 15 13 17.5C13 20 15 22 17.5 22Z"
                                                            fill="currentColor"
                                                            opacity="0.3"/>
													</svg>
												</span>
                                                <!--end::Svg Icon-->
											</span>
											<span class="menu-title">Encounters</span>
											<span class="menu-arrow"></span>
										</span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link  @yield('encounter_a')"
                                   href="{{route('encounters.index')}}">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                                    <span class="menu-title">Manage</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->
                        </div>
                        <!--end:Menu sub-->
                    </div>
                @endif
                <!--end:Menu item-->
            </div>
            <!--end::Menu-->
        </div>
        <!--end::Menu wrapper-->
    </div>
    <!--end::sidebar menu-->
</div>
