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
                        <li class="breadcrumb-item text-white fw-bold lh-1">Notifications</li>
                    </ul>
                </div>
                <div class="d-flex flex-stack flex-wrap flex-lg-nowrap gap-4 gap-lg-10 pt-13 pb-6">
                    <div class="page-title me-5">
                        <h1 class="page-heading d-flex text-white fw-bold fs-2 flex-column justify-content-center my-0">Notifications List</h1>
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
                            <h4 class="card-title">Notifications List</h4>
                            <div class="btn-group" role="group" aria-label="Actions">
                                <a href="{{ route('company.dashboard') }}" class="btn btn-primary" title="All Notifications">
                                    <i class="fa fa-list"></i> Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body py-4">
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="notifications-table">
                                    <thead>
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                        <th>Action</th>
                                        <th>Message</th>
                                        <th>Status</th>
                                        <th>Time</th>
                                        <th>Read</th>
                                    </tr>
                                    </thead>
                                    <tbody class="text-gray-600 fw-semibold">
                                    @foreach($notifications as $notification)
                                        <tr
                                        @if(is_null($notification->read_at))  @endif>
                                            <td>
                                                @if(is_null($notification->read_at))
                                                    <form method="POST" action="{{ route('company.notifications.markAsRead', $notification->id) }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-primary px-2 py-1">
                                                            <i class="fa fa-check"></i> Mark as Read
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>

                                            <td>{{ $notification->data['message'] ?? 'No message' }}</td>

                                            <td>
                                                @if($notification->read_at)
                                                    <span class="badge bg-success">Read</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Unread</span>
                                                @endif
                                            </td>

                                            <td>{{ $notification->created_at->diffForHumans() }}</td>

                                            <td>{{$notification->read_at?->diffForHumans() ?? '__'}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                {{ $notifications->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

