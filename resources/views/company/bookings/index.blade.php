@extends('company.layout.app')

@section('custom-css')
    <link href="{{asset('metronic/assets/plugins/datatables/dataTables.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('metronic/assets/plugins/datatables/buttons.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('toolbar')
    <div id="kt_app_toolbar" class="app-toolbar py-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex align-items-start">
            <div class="d-flex flex-column flex-row-fluid">
                <div class="d-flex align-items-center pt-1">
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold">
                        <li class="breadcrumb-item text-white fw-bold lh-1">
                            <a href="{{route('company.dashboard')}}" class="text-white text-hover-primary">
                                <i class="ki-outline ki-home text-white fs-6"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i>
                        </li>
                        <li class="breadcrumb-item text-white fw-bold lh-1">Bookings</li>
                    </ul>
                </div>
                <div class="d-flex flex-stack flex-wrap flex-lg-nowrap gap-4 gap-lg-10 pt-13 pb-6">
                    <div class="page-title me-5">
                        <h1 class="page-heading d-flex text-white fw-bold fs-2 flex-column justify-content-center my-0">Booking List</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="app-container container-xxl">
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
            <div class="d-flex flex-column flex-column-fluid">
                <div id="kt_app_content" class="app-content flex-column-fluid">
                    <div class="card">
                        <div class="card-header border-info border-3 d-inline-flex flex-column flex-md-row align-items-center justify-content-between">
                            <h4 class="card-title">Booking List</h4>
                            <div class="btn-group" role="group" aria-label="">
                                <a href="{{ route('company.bookings.create') }}" class="btn btn-primary mr-1" title="New Booking">
                                    <i class="fa fa-plus"></i> New Booking
                                </a>
                                <a href="javascript:void(0);" id="datatable-reset-filter" class="btn btn-warning" title="Clear Filter">
                                    <i class="fa fa-broom"></i> Clear Filter
                                </a>
                            </div>
                        </div>
                        <div class="mt-3 p-3">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button type="button" class="accordion-button btn btn-light-primary me-3" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                            <i class="ki-outline ki-filter fs-2"></i>Custom Filter
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="row">
                                                <div class="fv-row mb-7 col-4 fv-plugins-icon-container">
                                                    <label class="fs-6 fw-semibold form-label mt-3">
                                                        <span>Booking Code</span>
                                                    </label>
                                                    <input type="number" class="form-control form-control-solid search-input"
                                                           name="booking_code" id="booking_code" placeholder="Booking Code" aria-label="Booking Code"/>
                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                                </div>
                                                <div class="fv-row mb-7 col-4 fv-plugins-icon-container">
                                                    <label class="fs-6 fw-semibold form-label mt-3">
                                                        <span>Vehicle Title</span>
                                                    </label>
                                                    <input type="search" class="form-control form-control-solid search-input"
                                                           name="vehicle_title" id="vehicle_title" placeholder="Vehicle Title" aria-label="Vehicle Title"/>
                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                                </div>
                                                <div class="fv-row mb-7 col-12 col-lg-4 fv-plugins-icon-container">
                                                    <label class="fs-6 fw-semibold form-label mt-3">
                                                        <span>Booking Status</span>
                                                    </label>
                                                    <select name="booking_status_id" id="booking_status_id" aria-label="Select a Booking Status"
                                                            data-control="select2" data-placeholder="Select a Booking Status..."
                                                            class="form-select form-select-solid form-select-lg fw-semibold search-input">

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body py-4">
                            <!--begin::Table-->
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="ajax-datatable">
                                    <thead>
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                        <th class="min-w-50px">Id</th>
                                        <th class="min-w-100px">Actions</th>
                                        <th class="min-w-150px">Booking Code</th>
                                        <th class="min-w-150px">Vehicle</th>
                                        <th class="min-w-150px">Full Name</th>
                                        <th class="min-w-150px">Details</th>
                                        <th class="min-w-150px">Status</th>
                                        <th class="min-w-150px">Locations</th>
                                        <th class="min-w-150px">Rental Period</th>
                                        <th class="min-w-150px">Finance</th>
                                        <th class="min-w-150px">Notes</th>
                                    </tr>
                                    </thead>
                                    <tbody class="text-gray-600 fw-semibold">
                                    </tbody>
                                </table>
                            </div>
                            <!--end::Table-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Confirm Action ?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Continuing will cancel the booking. Do you want to proceed?
                </div>
                <input type="hidden" id="hidden_cancel_id">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="cancel_button" class="btn btn-danger" onclick="confirmDeleteAction()">Continue</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('custom-js')
    <script src="{{ asset('metronic/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{asset('metronic/assets/plugins/datatables/dataTables.bootstrap5.min.js')}}"></script>

    <!--begin::Vendors Javascript(used for this page only) kjo e ben qe te mbyllen-->
    {{--    <script src="{{asset('metronic/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>--}}
    <!--end::Vendors Javascript-->

    <script>
        $(document).ready(function () {
            let $datatable = $('#ajax-datatable');
            let $resetFilterBtn = $('#datatable-reset-filter');

            let hasFilters = false;

            let dt = $datatable.DataTable({
                responsive: true,
                searchDelay: 500,
                processing: true,
                serverSide: true,
                orderCellsTop: true,
                stateSave: true,
                order: [[1, 'asc']],
                ajax: {
                    url: '{{ route('company.bookings.index') }}',
                    data: function (d) {
                        d.vehicle_title           = $('#vehicle_title').val();
                        d.booking_status_id       = $('#booking_status_id').val();
                    }
                },
                deferRender: true,
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false},
                    {data: 'booking_code', name: 'booking_code'},
                    {data: 'vehicle', name: 'vehicle'},
                    {data: 'full_name', name: 'full_name'},
                    {data: 'details', name: 'details'},
                    {data: 'status', name: 'status'},
                    {data: 'locations', name: 'locations'},
                    {data: 'date_and_time', name: 'date_and_time'},
                    {data: 'finance', name: 'finance'},
                    {data: 'notes', name: 'notes'}
                ],
            });

            $('.search-input', this).on('keyup change', function () {
                if (dt.column(`${this.name}:name`).search() !== this.value) {
                    dt.column(`${this.name}:name`).search(this.value).draw();
                }
            });

            $('.search-input', this).on('keyup change', function () {
                if (dt.column(`${this.name}:name`).search() !== this.value) {
                    dt.column(`${this.name}:name`).search(this.value).draw();
                }
            });

            $resetFilterBtn.click(function () {
                dt.state.clear();
                location.reload();
            });

            if (dt.state.loaded()) {
                let state = dt.state.loaded();
                let columns = dt.settings().init().columns;

                dt.columns().every(function (index) {
                    let columnName = columns[index].name,
                        columnSearch = state.columns[index].search,
                        columnSearchValue = columnSearch ? columnSearch.search : null;

                    if (columnSearchValue) {
                        let $field = $(`.search-input[name="${columnName}"]`);

                        if ($field.hasClass('select2-hidden-accessible')) {
                            $field.val(columnSearchValue).trigger('change.select2');
                        } else {
                            $field.val(columnSearchValue);
                        }
                        hasFilters = true;
                    }
                });
            }

            if (hasFilters) {
                $('.dt-filter-search').show();
            }
        });

        $(document).ready(function () {
            var $booking_status_id = $('#booking_status_id');
            $booking_status_id.select2({
                placeholder: "User",
                allowClear: true,
                ajax: {
                    url: "{{ route('company.booking_statuses.search') }}",
                    dataType: 'json',
                    cache: false,
                    data: function (params) {
                        return {
                            keyword: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (source) {
                                return {
                                    id: source.id,
                                    text: source.label
                                };
                            })
                        };
                    }
                }
            });
        });
    </script>


    <script>
        function showDeleteModal(data_id) {
            $('#hidden_cancel_id').val(data_id);
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }

        function confirmDeleteAction() {
            const deleteId = document.getElementById('hidden_cancel_id').value;
            const deleteButton = document.getElementById("cancel_button");
            deleteButton.disabled = true;

            const payload = {
                data: {
                    delete_id: deleteId
                }
            };

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '{{ route("company.bookings.cancel") }}',
                method: 'POST',
                data: payload,
            }).done(function (response) {
                $('#deleteModal').modal('hide');
                deleteButton.disabled = false;

                if (response.status === 1) {
                    toastr.success(response.message, 'Success');
                    const table = $('#ajax-datatable').DataTable();
                    const row = $('button[data-id="' + deleteId + '"]').closest('tr');
                    table.row(row).remove().draw();
                } else if (response.status === 2) {
                    toastr.error(response.message, 'Permission Denied');
                } else {
                    toastr.error('Something went wrong. Please try again later.');
                }
            }).fail(function () {
                $('#deleteModal').modal('hide');
                deleteButton.disabled = false;
                toastr.error('Server error occurred. Try again.');
            });
        }
    </script>


@endsection
