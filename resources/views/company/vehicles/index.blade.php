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
                        <li class="breadcrumb-item text-white fw-bold lh-1">Vehicles List</li>
                    </ul>
                </div>
                <div class="d-flex flex-stack flex-wrap flex-lg-nowrap gap-4 gap-lg-10 pt-13 pb-6">
                    <div class="page-title me-5">
                        <h1 class="page-heading d-flex text-white fw-bold fs-2 flex-column justify-content-center my-0">Vehicles List</h1>
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
                            <h4 class="card-title">Vehicles List</h4>
                            <div class="btn-group" role="group" aria-label="">
                                @if(auth()->user()->hasPermission('vehicles.store'))
                                    <a href="{{route('company.vehicles.create')}}" id="new_content" class="btn btn-primary mr-1" title="Clear Filter">
                                        <i class="fa fa-plus"></i>New Vehicle
                                    </a>
                                @endif
                                <a href="javascript:void(0);" id="datatable-reset-filter" class="btn btn-warning mr-1" title="Clear Filter">
                                    <i class="fa fa-broom"></i>Clear Filter
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
                                                        <span>Title</span>
                                                    </label>
                                                    <input type="search" class="form-control form-control-solid search-input"
                                                           name="title" id="title" placeholder="Title" aria-label="Title"/>
                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                                </div>
                                                <div class="fv-row mb-7 col-4 fv-plugins-icon-container">
                                                    <label class="fs-6 fw-semibold form-label mt-3">
                                                        <span>Plate</span>
                                                    </label>
                                                    <input type="search" class="form-control form-control-solid search-input"
                                                           name="plate" id="plate" placeholder="Plate" aria-label="Plate"/>
                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                                </div>
                                                <div class="fv-row mb-7 col-4 fv-plugins-icon-container">
                                                    <label class="fs-6 fw-semibold form-label mt-3">
                                                        <span>Vin</span>
                                                    </label>
                                                    <input type="search" class="form-control form-control-solid search-input"
                                                           name="vin" id="vin" placeholder="Vin" aria-label="Vin"/>
                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                                </div>
                                                <div class="fv-row mb-7 col-12 col-lg-4 fv-plugins-icon-container">
                                                    <label class="fs-6 fw-semibold form-label mt-3">
                                                        <span>Vehicle Category</span>
                                                    </label>
                                                    <select name="vehicle_category_id" id="vehicle_category_id" aria-label="Select a Vehicle Category"
                                                            data-control="select2" data-placeholder="Select a Vehicle Category..."
                                                            class="form-select form-select-solid form-select-lg fw-semibold search-input">

                                                    </select>
                                                </div>
                                                <div class="fv-row mb-7 col-12 col-lg-4 fv-plugins-icon-container">
                                                    <label class="fs-6 fw-semibold form-label mt-3">
                                                        <span>Fuel Type</span>
                                                    </label>
                                                    <select name="fuel_type_id" id="fuel_type_id" aria-label="Select a Fuel Type"
                                                            data-control="select2" data-placeholder="Select a Fuel Type..."
                                                            class="form-select form-select-solid form-select-lg fw-semibold search-input">

                                                    </select>
                                                </div>
                                                <div class="fv-row mb-7 col-12 col-lg-4 fv-plugins-icon-container">
                                                    <label class="fs-6 fw-semibold form-label mt-3">
                                                        <span>Transmission Type</span>
                                                    </label>
                                                    <select name="transmission_type_id" id="transmission_type_id" aria-label="Select a Vehicle Category"
                                                            data-control="select2" data-placeholder="Select a Transmission Type..."
                                                            class="form-select form-select-solid form-select-lg fw-semibold search-input">

                                                    </select>
                                                </div>
                                                <div class="fv-row mb-7 col-12 col-lg-4 fv-plugins-icon-container">
                                                    <label class="fs-6 fw-semibold form-label mt-3">
                                                        <span>Vehicle Status</span>
                                                    </label>
                                                    <select name="vehicle_status_id" id="vehicle_status_id" aria-label="Select a Vehicle Status"
                                                            data-control="select2" data-placeholder="Select a Vehicle Status..."
                                                            class="form-select form-select-solid form-select-lg fw-semibold search-input">

                                                    </select>
                                                </div>
                                                <div class="fv-row mb-7 col-12 col-lg-4 fv-plugins-icon-container">
                                                    <label class="fs-6 fw-semibold form-label mt-3">
                                                        <span>Model</span>
                                                    </label>
                                                    <select name="vehicle_model_id" id="vehicle_model_id" aria-label="Select a Vehicle Model"
                                                            data-control="select2" data-placeholder="Select a Vehicle Model..."
                                                            class="form-select form-select-solid form-select-lg fw-semibold search-input">

                                                    </select>
                                                </div>
                                                <div class="fv-row mb-7 col-12 col-lg-4 fv-plugins-icon-container">
                                                    <label class="fs-6 fw-semibold form-label mt-3">
                                                        <span>Registration Expiry</span>
                                                    </label>
                                                    <input type="search" class="form-control form-control-solid search-input date-range" name="registration_expiry" id="registration_expiry"  placeholder="Select Registration Expiry"
                                                           aria-label="Registration Expiry"/>
                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                                </div>

                                                <div class="fv-row mb-7 col-12 col-lg-4 fv-plugins-icon-container">
                                                    <label class="fs-6 fw-semibold form-label mt-3">
                                                        <span>Insurance Expiry</span>
                                                    </label>
                                                    <input type="search" class="form-control form-control-solid search-input date-range" name="insurance_expiry" id="insurance_expiry" placeholder="Select Insurance Expiry"
                                                           aria-label="Insurance Expiry"/>
                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
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
                                        <th class="min-w-150px">Vehicle</th>                 <!-- title, model, category -->
                                        <th class="min-w-150px">Identifiers</th>             <!-- plate, VIN -->
                                        <th class="min-w-150px">Specifications</th>          <!-- year, color, mileage -->
                                        <th class="min-w-150px">Mechanics</th>               <!-- fuel, transmission -->
                                        <th class="min-w-150px">Requirements</th>              <!-- min drive age -->
                                        <th class="min-w-150px">Status</th>                  <!-- status name -->
                                        <th class="min-w-150px">Daily Rate</th>              <!-- base daily rate -->
                                        <th class="min-w-150px">Expiry Dates</th>            <!-- registration & insurance -->
                                        <th class="min-w-150px">Notes</th>                   <!-- notes -->
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
                    If you click continue data can be permanently lost
                </div>
                <input type="hidden" id="hidden_delete_id">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="delete_button" class="btn btn-danger" onclick="confirmDeleteAction()">Continue</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="{{ asset('metronic/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{asset('metronic/assets/plugins/datatables/dataTables.bootstrap5.min.js')}}"></script>

    @include('company.vehicles.custom_js')
    <script>
        function showDeleteModal(data_id) {
            $('#hidden_delete_id').val(data_id);
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }

        function confirmDeleteAction() {
            const deleteId = document.getElementById('hidden_delete_id').value;
            const deleteButton = document.getElementById("delete_button");
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
                url: '{{ route("company.vehicles.destroy") }}',
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
                    url: '{{ route('company.vehicles.index') }}',
                    data: function (d) {
                        d.title                     = $('#title').val();
                        d.plate                     = $('#plate').val();
                        d.vin                       = $('#vin').val();
                        d.vehicle_category_id       = $('#vehicle_category_id').val();
                        d.fuel_type_id              = $('#fuel_type_id').val();
                        d.transmission_type_id      = $('#transmission_type_id').val();
                        d.vehicle_status_id         = $('#vehicle_status_id').val();
                        d.vehicle_model_id          = $('#vehicle_model_id').val();
                        d.registration_expiry       = $('#registration_expiry').val();
                        d.insurance_expiry          = $('#insurance_expiry').val();
                    }
                },
                deferRender: true,
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false},
                    {data: 'vehicle', name: 'vehicle'},
                    {data: 'identifiers', name: 'identifiers'},
                    {data: 'specifications', name: 'specifications'},
                    {data: 'mechanics', name: 'mechanics'},
                    {data: 'requirements', name: 'requirements'},
                    {data: 'vehicle_status', name: 'vehicle_status'},
                    {data: 'daily_rate', name: 'daily_rate'},
                    {data: 'expiry_dates', name: 'expiry_dates'},
                    {data: 'notes', name: 'notes'}

                ],
            });

            $('.date-range').daterangepicker({
                locale: {
                    format: 'DD-MM-YYYY'
                },
                ranges: {
                    'Today': [moment().startOf('day'), moment().endOf('day')],
                    'Yesterday': [moment().subtract(1, 'days').startOf('day'), moment().subtract(1, 'days').endOf('day')],
                    'Last 7 Days': [moment().subtract(6, 'days').startOf('day'), moment().endOf('day')],
                    'Last 15 Days': [moment().subtract(14, 'days').startOf('day'), moment().endOf('day')],
                    'Last 30 Days': [moment().subtract(29, 'days').startOf('day'), moment().endOf('day')],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'From the start': [new Date("July 25, 2022 00:00:00"), moment().endOf('month')]
                },
                autoUpdateInput: false
            });

            $('.date-range').daterangepicker({
                locale: {
                    format: 'DD-MM-YYYY'
                },
                ranges: {
                    'Today': [moment().startOf('day'), moment().endOf('day')],
                    'Yesterday': [moment().subtract(1, 'days').startOf('day'), moment().subtract(1, 'days').endOf('day')],
                    'Last 7 Days': [moment().subtract(6, 'days').startOf('day'), moment().endOf('day')],
                    'Last 15 Days': [moment().subtract(14, 'days').startOf('day'), moment().endOf('day')],
                    'Last 30 Days': [moment().subtract(29, 'days').startOf('day'), moment().endOf('day')],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'From the start': [new Date("July 25, 2022 00:00:00"), moment().endOf('month')]
                },
                autoUpdateInput: false
            });

            $('.date-range').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
                dt.draw();
            });

            $('.date-range').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                dt.draw();
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
    </script>
@endsection
