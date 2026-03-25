@extends('admin.layout.app')

@section('custom-css')
    <link href="{{ asset('metronic/assets/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metronic/assets/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        /* Add custom CSS here */
        .breadcrumb-item .ki-right {
            margin-left: 5px;
            margin-right: 5px;
        }
        .accordion-button {
            width: 100%;
        }
        @media (max-width: 768px) {
            .page-title {
                text-align: center;
            }
        }
    </style>
@endsection

@section('toolbar')
    <div id="kt_app_toolbar" class="app-toolbar py-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-start">
            <div class="d-flex flex-column flex-row-fluid">
                <div class="d-flex align-items-center pt-1">
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold">
                        <li class="breadcrumb-item text-white fw-bold lh-1">
                            <a href="{{ route('admin.dashboard') }}" class="text-white text-hover-primary">
                                <i class="ki-outline ki-home text-gray-700 fs-6"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i>
                        </li>
                        <li class="breadcrumb-item text-white fw-bold lh-1">Activity Logs</li>
                    </ul>
                </div>
                <div class="d-flex flex-stack flex-wrap flex-lg-nowrap gap-4 gap-lg-10 pt-13 pb-6">
                    <div class="page-title me-5">
                        <h1 class="page-heading d-flex text-white fw-bold fs-2 flex-column justify-content-center my-0">Activity Logs
                            <span class="page-desc text-gray-600 fw-semibold fs-6 pt-3">Activity Logs Desc</span>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="app-container container-fluid">
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
            <div class="d-flex flex-column flex-column-fluid">
                <div id="kt_app_content" class="app-content flex-column-fluid">
                    <div class="card">
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
                                            <form action="#" method="GET">
                                                <div class="row">
                                                    <div class="fv-row mb-7 col-12 col-lg-4 fv-plugins-icon-container">
                                                        <label class="fs-6 fw-semibold form-label mt-3">
                                                            <span>Daterange</span>
                                                        </label>
                                                        <div id="reportrange" class="form-control form-control-solid">
                                                            <i class="fa fa-calendar"></i>&nbsp;
                                                            <span></span> <i class="fa fa-caret-down"></i>
                                                        </div>
                                                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                            <input type="text" style="display: none" name="start_date" id="start_date" value="{{ request()->get('start_date') ?: \Carbon\Carbon::now()->startOfDay()->toDateTimeString() }}">
                                                            <input type="text" style="display: none" name="end_date" id="end_date" value="{{ request()->get('end_date') ?: \Carbon\Carbon::now()->endOfDay()->toDateTimeString() }}">
                                                        </div>
                                                    </div>
                                                    <div class="fv-row mb-7 col-12 col-lg-4 fv-plugins-icon-container">
                                                        <label class="fs-6 fw-semibold form-label mt-3">
                                                            <span>User</span>
                                                        </label>
                                                        <select name="user_id" id="user_id" aria-label="Select a User" data-control="select2" data-placeholder="Select a user..." class="form-select form-select-solid form-select-lg fw-semibold">
                                                            @if(request('user_id'))
                                                                <option value="{{ $user->id }}">{{ $user->fullName() }}</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="fv-row mb-7 col-12 col-lg-4 fv-plugins-icon-container">
                                                        <label class="fs-6 fw-semibold form-label mt-3">
                                                            <span>Show Number</span>
                                                        </label>
                                                        <input type="number" class="form-control form-control-solid" name="show_number" value="{{ request('show_number') ?: 20 }}">
                                                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                                    </div>
                                                </div>
                                                <strong>Click the </strong> <code>filter</code> button to apply new filters.
                                                <div class="d-flex justify-content-start mt-3" data-kt-user-table-toolbar="base">
                                                    <button type="submit" class="btn btn-bg-secondary btn-active-success">Filter</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body py-4">
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="ajax-datatable">
                                    <thead>
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                        <th class="min-w-125px">Id</th>
                                        <th class="min-w-125px">System User</th>
                                        <th class="min-w-125px">Priority</th>
                                        <th class="min-w-125px">Method</th>
                                        <th class="min-w-125px">Description</th>
                                        <th class="min-w-125px">Action</th>
                                        <th class="min-w-125px">DateTime</th>
                                    </tr>
                                    </thead>
                                    <tbody class="text-gray-600 fw-semibold">
                                    @foreach($activityLogs as $log)
                                        <tr>
                                            <td>{{ $log->id }}</td>
                                            <td>{{ $log->user->fullName() }}</td>
                                            @if($log->priority == 1 || $log->priority == 2)
                                                <td class="text-center">
                                                    <div class="label text-danger d-flex">
                                                        <div class="dot-label bg-danger me-1"></div>
                                                        @if($log->priority == 1) Critical ({{ $log->priority }}) @else High ({{ $log->priority }}) @endif
                                                    </div>
                                                </td>
                                            @elseif($log->priority == 3 || $log->priority == 4)
                                                <td class="text-center">
                                                    <div class="label text-warning d-flex">
                                                        <div class="dot-label bg-warning me-1"></div>
                                                        @if($log->priority == 3) Medium ({{ $log->priority }}) @else Low ({{ $log->priority }}) @endif
                                                    </div>
                                                </td>
                                            @else
                                                <td class="text-center">
                                                    <div class="label text-success d-flex">
                                                        <div class="dot-label bg-success me-1"></div>
                                                        Trivial ({{ $log->priority }})
                                                    </div>
                                                </td>
                                            @endif
                                            <td>{{ $log->method }}</td>
                                            <td>{{ $log->description }}</td>
                                            <td>{{ $log->action_type }}</td>
                                            <td>{{ $log->created_at }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $activityLogs->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="{{ asset('metronic/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('metronic/assets/plugins/datatables/dataTables.bootstrap5.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            var $user_id = $('#user_id');
            $user_id.select2({
                placeholder: "User",
                allowClear: true,
                ajax: {
                    url: "{{ route('admin.users.search') }}",
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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script type="text/javascript">
        $(function() {
            var start = moment("{{ request()->get('start_date') ?: \Carbon\Carbon::now()->startOfDay()->toDateTimeString() }}");
            var end = moment("{{ request()->get('end_date') ?: \Carbon\Carbon::now()->endOfDay()->toDateTimeString() }}");
            function cb(start, end) {
                document.getElementById('start_date').value = start.format('YYYY-MM-DD HH:mm:ss');
                document.getElementById('end_date').value = end.format('YYYY-MM-DD HH:mm:ss');
                $('#reportrange span').html(start.format('MMMM D, YYYY HH:mm') + ' - ' + end.format('MMMM D, YYYY HH:mm'));
            }
            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                timePicker: true,
                timePicker24Hour: true,
                timePickerIncrement: 30,
                ranges: {
                    'Today': [moment().startOf('day'), moment().endOf('day')],
                    'Yesterday': [moment().subtract(1, 'days').startOf('day'), moment().subtract(1, 'days').endOf('day')],
                    'Last 7 Days': [moment().subtract(6, 'days').startOf('day'), moment().endOf('day')],
                    'Last 30 Days': [moment().subtract(29, 'days').startOf('day'), moment().endOf('day')],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'From the start': [new Date("July 25, 2022 00:00:00"), moment().endOf('month')]
                }
            }, cb);
            cb(start, end);
        });
    </script>
@endsection
