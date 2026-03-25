@extends('admin.layout.app')

@section('custom-css')
    <link href="{{asset('metronic/assets/plugins/datatables/dataTables.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('metronic/assets/plugins/datatables/buttons.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />

    <style>
        .table td, .table th {
            vertical-align: middle;
        }
        .table tbody tr:hover {
            background-color: #f9f9f9 !important;
        }
        .card-title {
            letter-spacing: -0.3px;
        }
    </style>

@endsection

@section('toolbar')

        <div id="kt_app_toolbar" class="app-toolbar py-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex align-items-start">
                <div class="d-flex flex-column flex-row-fluid">
                    <div class="d-flex align-items-center pt-1">
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold">
                            <li class="breadcrumb-item text-white fw-bold lh-1">
                                <a href="{{route('admin.dashboard')}}" class="text-white text-hover-primary">
                                    <i class="ki-outline ki-home text-white fs-6"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i>
                            </li>
                            <li class="breadcrumb-item text-white fw-bold lh-1">Contacts Form</li>
                        </ul>
                    </div>
                    <div class="d-flex flex-stack flex-wrap flex-lg-nowrap gap-4 gap-lg-10 pt-13 pb-6">
                        <div class="page-title me-5">
                            <h1 class="page-heading d-flex text-white fw-bold fs-2 flex-column justify-content-center my-0">Contacts Form List</h1>
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
                    <div class="card shadow-sm">
                        <div class="card-header border-0 pt-6 pb-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                            <div class="d-flex flex-column">
                                <h3 class="card-title fw-bold fs-2 mb-0">Contacts Form List</h3>
                                <span class="text-muted mt-1">A list of contact form submissions</span>
                            </div>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary mt-4 mt-md-0 px-6">
                                <i class="ki-outline ki-arrow-left fs-3"></i> Back
                            </a>
                        </div>
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5">
                                    <thead>
                                    <tr class="text-start text-gray-600 fw-bold fs-7 text-uppercase">
                                        <th class="w-25px">
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox"
                                                       data-kt-check="true" data-kt-check-target=".row-check" />
                                            </div>
                                        </th>
                                        <th>ID</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Phone Number</th>
                                        <th>Email Address</th>
                                        <th>Message</th>
                                    </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-800">
                                    @foreach($contacts as $contact)
                                        <tr>
                                            <td>
                                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input row-check" type="checkbox" value="{{ $contact->id }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-bold fs-6">{{ $contact->id }}</span>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-bold fs-6">{{ $contact->first_name }}</span>

                                                </div>
                                            </td>

                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-bold fs-6">{{ $contact->last_name }}</span>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-bold fs-6">{{ $contact->phone_number }}</span>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-bold fs-6">{{ $contact->email }}</span>
                                                </div>
                                            </td>

                                            <td style="max-width: 260px;">
                                                <div class="d-flex flex-column">
                                                   <span class="fw-bold fs-6 text-truncate" title="{{ $contact->message }}">{{ Str::limit($contact->message, 60, '...') }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


