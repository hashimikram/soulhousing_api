<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
    <thead>
    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
        <th class="min-w-125px">MRN No</th>
        <th class="min-w-125px">Full Name</th>
        <th class="min-w-125px">Age</th>
        <th class="min-w-125px">Gender</th>
        <th class="min-w-125px">Martial Status</th>
        <th class="min-w-125px">Contact No</th>
        <th class="text-end min-w-100px">Actions</th>
    </tr>
    </thead>
    <tbody class="text-gray-600 fw-semibold">
    @foreach ($patients as $data)
        <tr>
            <td>{{ $data->mrn_no }}</td>
            <td class="d-flex align-items-center">
                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                    <a href="{{ route('user.show', $data->id) }}">
                        <div class="symbol-label">
                            <img src="{{ image_url($data->profile_pic) }}" alt="{{ $data->first_name }}" class="w-100"/>
                        </div>
                    </a>
                </div>
                <div class="d-flex flex-column">
                    <a href="{{ route('user.show', $data->id) }}" class="text-gray-800 text-hover-primary mb-1">
                        {{ $data->first_name }} {{ $data->middle_name }} {{ $data->last_name }}
                    </a>
                    <span>{{ $data->email }}</span>
                </div>
            </td>
            <td>{{ formatDate($data->date_of_birth) }}
                <div class="badge badge-success fw-bold">
                    ({{ \Carbon\Carbon::parse($data->date_of_birth)->age }})
                </div>
            </td>
            <td>{{ $data->gender }}</td>
            <td>{{ $data->marital_status }}</td>
            <td>{{ $data->phone_no }}</td>
            <td class="text-end">
                <div class="ms-2">
                    <button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary"
                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            <span class="svg-icon svg-icon-5 m-0">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <rect x="10" y="10" width="4" height="4" rx="2" fill="currentColor"></rect>
                                    <rect x="17" y="10" width="4" height="4" rx="2" fill="currentColor"></rect>
                                    <rect x="3" y="10" width="4" height="4" rx="2" fill="currentColor"></rect>
                                </svg>
                            </span>
                    </button>
                    <div
                        class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-150px py-4"
                        data-kt-menu="true">
                        <div class="menu-item px-3">
                            <a href="{{ route('user.edit', $data->id) }}" class="menu-link px-3">Edit</a>
                        </div>
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link text-danger px-3 delete-button" data-id="{{ $data->id }}"
                               data-kt-filemanager-table-filter="delete_row">Delete</a>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
