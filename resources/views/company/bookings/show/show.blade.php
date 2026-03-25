@extends('company.layout.app')

@section('custom-css')
    <link href="{{asset('metronic/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('metronic/assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />

    <link  href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>


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
                        <li class="breadcrumb-item text-white fw-bold lh-1">
                            <a href="{{route('company.bookings.index')}}" class="text-white text-hover-primary">
                                Bookings List
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i>
                        </li>
                        <li class="breadcrumb-item text-white fw-bold lh-1">Booking Details</li>
                    </ul>
                </div>
                <div class="d-flex flex-stack flex-wrap flex-lg-nowrap gap-4 gap-lg-10 pt-13 pb-6">
                    <div class="page-title me-5">
                        <h1 class="page-heading d-flex text-white fw-bold fs-2 flex-column justify-content-center my-0">Booking Details</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <!--begin::Wrapper container-->
    <div class="app-container container-xxl">
        <!--begin::Main-->
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
            <!--begin::Content wrapper-->
            <div class="d-flex flex-column flex-column-fluid">
                <!--begin::Content-->
                <div id="kt_app_content" class="app-content flex-column-fluid">
                    <!--begin::Layout-->
                    <div class="d-flex flex-column flex-xl-row">
                        <!--begin::Sidebar-->
                        <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
                            <!--begin::Card-->
                            <div class="card mb-5 mb-xl-8">
                                <!--begin::Card body-->
                                <div class="card-body pt-15">
                                    <!--begin::Summary-->
                                    <div class="d-flex flex-center flex-column mb-5">
                                        <!--begin::Image Preview-->
                                        @if($booking->vehicle->images && count($booking->vehicle->images))
                                            <div class="mb-5">
                                                <div id="kt_vehicle_image_carousel" class="carousel slide" data-bs-ride="carousel">

                                                    <div class="position-relative overflow-hidden rounded border" style="height: 300px;">
                                                        <div class="carousel-inner h-100 w-100">
                                                            @foreach($booking->vehicle->images as $index => $image)
                                                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                                    <img src="{{ asset('storage/' . $image->path) }}"
                                                                         class="d-block w-100 h-100"
                                                                         alt="Vehicle Image"
                                                                         style="object-fit: cover;">
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>

                                                    @if(count($booking->vehicle->images) > 1)
                                                        <button class="carousel-control-prev" type="button" data-bs-target="#kt_vehicle_image_carousel" data-bs-slide="prev">
                                                            <span class="carousel-control-prev-icon bg-dark rounded-circle p-1" aria-hidden="true"></span>
                                                            <span class="visually-hidden">Previous</span>
                                                        </button>
                                                        <button class="carousel-control-next" type="button" data-bs-target="#kt_vehicle_image_carousel" data-bs-slide="next">
                                                            <span class="carousel-control-next-icon bg-dark rounded-circle p-1" aria-hidden="true"></span>
                                                            <span class="visually-hidden">Next</span>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif

                                        <!--end::Image Preview-->
                                        <a href="#" class="fs-3 text-success-emphasis text-hover-primary fw-bold mb-1">Vehicle Details # {{$booking->vehicle->id}}</a>
                                        <!--begin::Name-->
                                        <a href="{{ route('company.vehicles.show', $booking->vehicle->id) }}" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-1">{{ $booking->vehicle->title ?? '--' }}</a>
                                        <!--end::Name-->
                                        <!--begin::Position-->
                                        <div class="fs-5 fw-semibold text-muted mb-6">{{ $booking->vehicle->plate ?? '--' }}</div>
                                        <!--end::Position-->
                                    </div>
                                    <!--end::Summary-->
                                    <!--begin::Details toggle-->
                                    <div class="d-flex flex-stack fs-4 py-3">
                                        <div class="fw-bold rotate collapsible" data-bs-toggle="collapse" href="#kt_customer_view_details" role="button" aria-expanded="false" aria-controls="kt_customer_view_details">Details
                                            <span class="ms-2 rotate-180">
                                                <i class="ki-outline ki-down fs-3"></i>
                                            </span></div>
                                    </div>
                                    <!--end::Details toggle-->
                                    <div class="separator separator-dashed my-3"></div>
                                    <!--begin::Details content-->
                                    <div id="kt_customer_view_details" class="collapse hide">
                                        <div class="py-5 fs-6">
                                            <!-- Status + Action Button row -->
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <!-- Vehicle Status Badge -->
                                                <span class="badge fs-7 fw-bold py-2 px-4"
                                                      style="
                                                          color: {{ $booking->vehicle->vehicleStatus->text_color }};
                                                          background-color: {{ $booking->vehicle->vehicleStatus->background_color }};
                                                      ">
                                                    {{ $booking->vehicle->vehicleStatus->title_en ?? '--' }}
                                                </span>

                                                @php
                                                    use App\Models\Admin\BookingStatus;
                                                    use App\Models\Admin\VehicleStatus;
                                                @endphp

                                                <div>
                                                    @if($booking->booking_status_id == BookingStatus::CONFIRMED && $booking->vehicle->vehicle_status_id == VehicleStatus::BOOKED)
                                                        <button type="button"
                                                                class="btn btn-light-success btn-sm btn-hover-scale-up rounded-pill px-5 py-2"
                                                                onclick="pickup({{ $booking->id }})">
                                                            Pickup
                                                        </button>
                                                    @endif

                                                    @if($booking->booking_status_id == BookingStatus::ACTIVE)
                                                        <button type="button"
                                                                class="btn btn-light-facebook btn-sm btn-hover-scale-up rounded-pill px-5 py-2"
                                                                onclick="dropoff({{ $booking->id }})">
                                                            Dropoff
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Vehicle Details -->
                                            <div class="mt-4">
                                                <div class="fw-bold mt-3">Model/Brand</div>
                                                <div class="text-gray-600">{{ $booking->vehicle->vehicleModel->title ?? '--'}} / {{ $booking->vehicle->vehicleModel->brands->title ?? '—' }}</div>

                                                <div class="fw-bold mt-3">VIN</div>
                                                <div class="text-gray-600">
                                                    <a href="#" class="text-gray-600 text-hover-primary">{{ $booking->vehicle->vin ?? '--' }}</a>
                                                </div>

                                                <div class="fw-bold mt-3">Year</div>
                                                <div class="text-gray-600">{{ $booking->vehicle->year ?? '--' }}</div>

                                                <div class="fw-bold mt-3">Category</div>
                                                <div class="text-gray-600">{{ $booking->vehicle->vehicleCategory->title_en ?? '--' }}</div>

                                                <div class="fw-bold mt-3">Fuel Type</div>
                                                <div class="text-gray-600">{{ $booking->vehicle->fuelType->title_en ?? '--' }}</div>

                                                <div class="fw-bold mt-3">Transmission Type</div>
                                                <div class="text-gray-600">{{ $booking->vehicle->transmissionType->title_en ?? '--' }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--end::Details content-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card-->
                        </div>
                        <!--end::Sidebar-->
                        <!--begin::Content-->
                        <div class="flex-lg-row-fluid ms-lg-15">
                            <!--begin:::Tab content-->
                            <div class="tab-content" id="myTabContent">
                                <!--begin:::Tab pane-->
                                <div class="tab-pane fade show active" id="kt_customer_view_overview_tab" role="tabpanel">
                                    <!--begin::Card-->
                                    <div class="card pt-4 mb-6 mb-xl-9">
                                        <!--begin::Card header-->
                                        <div class="card-header border-0">
                                            <!--begin::Card title-->
                                            <div class="card-title">
                                                <h2>Booking Details #{{ $booking->id ?? '--' }}</h2>
                                            </div>
                                            <!--end::Card title-->
                                            <div class="card-toolbar">
                                                <!--begin::Filter-->
                                                <span style="
                                                       color: {{ $booking->bookingStatus->text_color }};
                                                       background-color: {{ $booking->bookingStatus->background_color }};
                                                       padding: 0.25em 0.5em;
                                                       border-radius: 0.25rem;
                                                       font-weight: 600;
                                                       display: inline-block;
                                                       "class="badge">
                                                    {{ $booking->bookingStatus->{"title_en"} ?? '--' }}
                                                </span>
                                                <!--end::Filter-->
                                            </div>

                                           {{-- <div class="card-toolbar">
                                                <!--begin::Filter-->
                                                <span style="
                                                       color: {{ $booking->paymentStatus->text_color }};
                                                       background-color: {{ $booking->paymentStatus->background_color }};
                                                       padding: 0.25em 0.5em;
                                                       border-radius: 0.25rem;
                                                       font-weight: 600;
                                                       display: inline-block;
                                                       "class="badge">
                                                    {{ $booking->paymentStatus->{"title_en"} ?? '--' }}
                                                </span>
                                                <!--end::Filter-->
                                            </div>--}}
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body pt-0 pb-5">
                                            <div  class="fs-6 ps-10">
                                                <!--begin::Details-->
                                                <div class="d-flex flex-wrap py-5">
                                                    <!--begin::Col-->
                                                    <div class="flex-equal me-5">
                                                        <table class="table table-flush fw-semibold gy-1">
                                                            <tbody><tr>
                                                                <td class="text-muted min-w-125px w-125px">Full Name</td>
                                                                <td class="text-gray-800">{{ $booking->first_name ?? '--' }} {{ $booking->last_name ?? '--' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-muted min-w-125px w-125px">Email</td>
                                                                <td class="text-gray-800">{{ $booking->email ?? '--' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-muted min-w-125px w-125px">Phone</td>
                                                                <td class="text-gray-800">{{ $booking->phone ?? '--' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-muted min-w-125px w-125px">Additional Phone</td>
                                                                <td class="text-gray-800">{{ $booking->additional_phone ?? '--' }}</td>
                                                            </tr>

                                                            <tr>
                                                                <td class="text-muted min-w-125px w-125px">Birthday</td>
                                                                <td class="text-gray-800">
                                                                  {{ \Carbon\Carbon::parse($booking->birthday)->format('d-m-Y') ?? '--' }}
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="flex-equal">
                                                        <table class="table table-flush fw-semibold gy-1">
                                                            <tbody>
                                                            <tr>
                                                                <td class="text-muted min-w-125px w-125px">Booking Code</td>
                                                                <td class="text-gray-800">{{ $booking->booking_code ?? '--' }} </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-muted min-w-125px w-125px">Deposit</td>
                                                                <td class="text-gray-800">{{ $booking->insurance->deposit_price ?? '--' }} </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-muted min-w-125px w-125px">Daily Rate</td>
                                                                <td class="text-gray-800">{{ $booking->daily_rate ?? '--' }} €</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-muted min-w-125px w-125px">Addons Total</td>
                                                                <td class="text-gray-800">{{ $booking->addons_total ?? '--' }} €</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-muted min-w-125px w-125px">Total Price</td>
                                                                <td class="text-gray-800">{{ $booking->total_price ?? '--' }} €</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-muted min-w-125px w-125px">Commission</td>
                                                                <td class="text-gray-800">{{ $commissionAmount ?? '--' }} €</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-muted min-w-125px w-125px align-middle">Ways Of Contact</td>
                                                                <td class="text-gray-800 align-middle">
                                                                    @php
                                                                        $contactOptions = [
                                                                            1 => ['label' => 'WhatsApp', 'color' => 'success', 'icon' => 'fab fa-whatsapp'],
                                                                            2 => ['label' => 'Telegram', 'color' => 'info', 'icon' => 'fab fa-telegram'],
                                                                            3 => ['label' => 'Viber', 'color' => 'primary', 'icon' => 'fab fa-viber']
                                                                        ];

                                                                        $selected = $contactOptions[$booking->ways_of_contact ?? 1];
                                                                    @endphp

                                                                    <span class="badge badge-light-{{ $selected['color'] }} fw-semibold d-inline-flex align-items-center gap-2">
                                                                        <i class="{{ $selected['icon'] }}"></i>
                                                                        {{ $selected['label'] }}
                                                                    </span>
                                                                </td>
                                                            </tr>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!--end::Col-->
                                                </div>
                                                <!--end::Details-->
                                            </div>
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::Card-->
                                </div>
                                <!--end:::Tab pane-->
                                <!--begin:::Tab pane-->
                                <div class="tab-pane fade show active" id="kt_customer_view_overview_tab" role="tabpanel">
                                    <!--begin::Card-->
                                    <div class="card pt-4 mb-6 mb-xl-9">
                                        <!--begin::Card header-->
                                        <div class="card-header border-0">
                                            <!--begin::Card title-->
                                            <div class="card-title">
                                                <h2>Insurance & Addons</h2>
                                            </div>
                                            <!--end::Card title-->
                                        </div>
                                        <!--end::Card header-->

                                        <!--begin::Card body-->
                                        <div class="card-body pt-0 pb-5">
                                            <div class="fs-6 ps-10">
                                                <!--begin::Details-->
                                                <div class="d-flex flex-wrap py-5">
                                                    <!--begin::Col (Insurance)-->
                                                    <div class="flex-equal me-5">
                                                        <h5 class="mb-3">Insurance</h5>
                                                        <table class="table table-flush fw-semibold gy-1">
                                                            <tbody>
                                                            @if($booking->insurance)
                                                                <tr>
                                                                    <td class="text-muted min-w-125px w-125px">Type</td>
                                                                    <td class="text-gray-800">{{ $booking->insurance->title_en }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-muted">Price</td>
                                                                    <td class="text-gray-800">{{ number_format($booking->insurance->price_per_day, 2) }} € / Per Day</td>
                                                                </tr>
                                                            @else
                                                                <tr>
                                                                    <td colspan="2" class="text-gray-500">No insurance selected</td>
                                                                </tr>
                                                            @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col (Addons)-->
                                                    <div class="flex-equal">
                                                        <h5 class="mb-3">Additional Services</h5>
                                                        <table class="table table-flush fw-semibold gy-1">
                                                            <tbody>
                                                            @forelse($booking->additionalServices as $service)
                                                                <tr>
                                                                    <td class="text-muted min-w-125px w-125px">{{ $service->title_en }}</td>
                                                                    <td class="text-gray-800">
                                                                        x{{ $service->pivot->quantity }} –
                                                                        {{ number_format($service->pivot->price, 2) }} €
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="2" class="text-gray-500">No additional services</td>
                                                                </tr>
                                                            @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!--end::Col-->
                                                </div>
                                                <!--end::Details-->
                                            </div>
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::Card-->
                                </div>
                                <!--end:::Tab pane-->

                                <!--begin:::Tab pane-->
                                <div class="tab-pane fade show active" id="kt_customer_view_overview_tab" role="tabpanel">
                                    <!--begin::Card-->
                                    <div class="card pt-4 mb-6 mb-xl-9">
                                        <!--begin::Card header-->
                                        <div class="card-header border-0">
                                            <!--begin::Card title-->
                                            <div class="card-title">
                                                <h2>Delivery </h2>
                                            </div>
                                            <div class="card-toolbar">
                                                <a class="badge badge-warning">{{ $booking->days }} days in total </a>
                                            </div>
                                            <!--end::Card title-->
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body pt-0 pb-5">
                                            <div  class="fs-6 ps-10">
                                                <!--begin::Details-->
                                                <div class="d-flex flex-wrap py-5">
                                                    <!--begin::Col-->
                                                    <div class="flex-equal me-5">
                                                        <table class="table table-flush fw-semibold gy-1">
                                                            <tbody><tr>
                                                                <td class="text-muted min-w-125px w-125px">Pick Up Location</td>
                                                                <td class="text-gray-800">{{ $booking->pickUpLocation->place ?? '--' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-muted min-w-125px w-125px">Drop Off Location</td>
                                                                <td class="text-gray-800">{{ $booking->dropOffLocation->place ?? '--' }}</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="flex-equal">
                                                        <table class="table table-flush fw-semibold gy-1">
                                                            <tbody>
                                                            <tr>
                                                                <td class="text-muted min-w-125px w-125px">Pick Up </td>
                                                                <td class="text-gray-800">{{ $booking->pickup_date ?? '--' }}/{{ $booking->pickup_time ?? '--' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-muted min-w-125px w-125px">Drop Off </td>
                                                                <td class="text-gray-800">{{ $booking->dropoff_date ?? '--' }}/{{ $booking->dropoff_time ?? '--' }}</td>
                                                            </tr>
                                                            <tr>
                                                            <td class="text-muted min-w-125px w-125px">Deliveries Total</td>
                                                            <td class="text-gray-800">{{ $booking->deliveries_total ?? '--' }} €</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!--end::Col-->
                                                </div>
                                                <!--end::Details-->
                                            </div>
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::Card-->
                                </div>
                                <!--end:::Tab pane-->
                            </div>
                            <!--end:::Tab content-->
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Layout-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Content wrapper-->
        </div>
        <!--end:::Main-->
    </div>
    <!--end::Wrapper container-->
@endsection
@section('custom-js')
    <script>
        function pickup(bookingId) {
            $.ajax({
                url: "{{ route('company.bookings.pickup') }}",
                type: 'POST',
                data: { booking_id: bookingId },
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                success: function(res) {
                    if (res.success) location.reload();
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('An error occurred.');
                }
            });
        }

        function dropoff(bookingId) {
            $.ajax({
                url: "{{ route('company.bookings.dropoff') }}",
                type: 'POST',
                data: { booking_id: bookingId },
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                success: function(res) {
                    if (res.success) location.reload();
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('An error occurred.');
                }
            });
        }
    </script>

@endsection
