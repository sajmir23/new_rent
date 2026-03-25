@extends('admin.layout.app')

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
                            <a href="{{route('admin.dashboard')}}" class="text-white text-hover-primary">
                                <i class="ki-outline ki-home text-gray-700 fs-6"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i>
                        </li>
                        <li class="breadcrumb-item text-white fw-bold lh-1">Cancellation Reasons List</li>
                    </ul>
                </div>
                <div class="d-flex flex-stack flex-wrap flex-lg-nowrap gap-4 gap-lg-10 pt-13 pb-6">
                    <div class="page-title me-5">
                        <h1 class="page-heading d-flex text-white fw-bold fs-2 flex-column justify-content-center my-0">Cancellation Reasons List</h1>
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
                            <h4 class="card-title">Cancellation Reasons List</h4>
                            <div class="btn-group" role="group" aria-label="">
                                @if(auth()->user()->hasPermission('cancellation_reasons.store'))
                                    <a href="{{route('admin.cancellation_reasons.create')}}" id="new_content" class="btn btn-primary mr-1" title="Clear Filter">
                                        <i class="fa fa-plus"></i>New Cancellation Reason
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

                                                <div class="fv-row mb-7 col-12 col-lg-4 fv-plugins-icon-container">
                                                    <label class="fs-6 fw-semibold form-label mt-3">
                                                        <span>Status</span>
                                                    </label>
                                                    <select name="status" id="status" aria-label="Select a Status"
                                                            data-control="select2" data-placeholder="Select a status..."
                                                            class="form-select form-select-solid form-select-lg fw-semibold search-input">
                                                        <option value="1">Active</option>
                                                        <option value="0">Inactive</option>
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
                                        <th class="min-w-125px">Title</th>
                                        <th class="min-w-125px">Status</th>
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

    <!--begin::Vendors Javascript(used for this page only) kjo e ben qe te mbyllen-->
    {{--    <script src="{{asset('metronic/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>--}}
    <!--end::Vendors Javascript-->


    <script>
        function showDeleteModal(data_id){
            $('#hidden_delete_id').val(data_id);
            var myModal = new bootstrap.Modal(document.getElementById('deleteModal'))
            myModal.show()
        }

        function confirmDeleteAction(){

            var delete_id   = document.getElementById('hidden_delete_id').value;

            document.getElementById("delete_button").disabled = true;
            var data = {
                delete_id: delete_id,
            };

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                data: {
                    data: data
                },
                url: '{{route("admin.cancellation_reasons.destroy")}}',
            }).done(function (data) {
                $('#deleteModal').modal('hide');
                document.getElementById("delete_button").disabled = false;
                if (data['status'] === 1) {
                    toastr.success(data['message'], 'Success')
                    var table = $('#ajax-datatable').DataTable();
                    table.row($('button[data-id="'+ delete_id +'"]').parents('tr')).remove().draw();
                } else if (data['status'] === 2) {
                    toastr.error(data['message'], 'Error')
                } else {
                    toastr.error('Something went wrong , Please try again later')
                }
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
                    url: '{{ route('admin.cancellation_reasons.index') }}',
                    data: function (d) {
                        d.title     = $('#title').val();
                    }
                },
                deferRender: true,
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false},
                    {data: 'title', name: 'title_en'},
                    {data: 'status', name: 'status'}
                ],
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
