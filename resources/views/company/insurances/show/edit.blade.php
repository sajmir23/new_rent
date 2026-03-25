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
                        <li class="breadcrumb-item text-white fw-bold lh-1">Insurences</li>
                    </ul>
                </div>
                <div class="d-flex flex-stack flex-wrap flex-lg-nowrap gap-4 gap-lg-10 pt-13 pb-6">
                    <div class="page-title me-5">
                        <h1 class="page-heading d-flex text-white fw-bold fs-2 flex-column justify-content-center my-0">Update Insurance</h1>
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
                    @include('company.insurances.show.partials.navbar')

                    <div class="row gx-6 gx-xl-9 mt-5">
                        <div class="col-lg-12">
                            <div class="card card-flush h-lg-100">
                                <div class="card-header mt-6">
                                    <div class="card-title flex-column">
                                        <h3 class="fw-bold mb-1">Update Insurance #{{ $insurance->id }}</h3>
                                    </div>
                                </div>

                                <form action="{{ route('company.insurances.update', $insurance->id) }}" method="POST" class="ajax-form" id="insurance_store_form">
                                    @csrf
                                    @method('PUT')

                                    <div class="card-body d-flex flex-column p-9 pt-3 mb-9">
                                        <div class="row">
                                            {{-- Titles --}}
                                            <div class="col-md-4">
                                                <h4 class="mb-4 text-success">Titles</h4>
                                                @foreach(['en', 'it', 'al', 'es', 'de', 'fr'] as $lang)
                                                    <div class="mb-3">
                                                        <label for="title_{{ $lang }}" class="fw-semibold">Title {{ $lang }}</label>
                                                        <input type="search" name="title_{{ $lang }}" id="title_{{ $lang }}"
                                                               class="form-control form-control-lg form-control-solid"
                                                               value="{{ $insurance->{'title_'.$lang} }}"
                                                               placeholder="company.insurances.edit">
                                                        <span class="invalid-feedback"><strong></strong></span>
                                                    </div>
                                                @endforeach
                                            </div>

                                            {{-- Descriptions --}}
                                            <div class="col-md-4">
                                                <h4 class="mb-4 text-success">Descriptions</h4>
                                                @foreach(['en', 'it', 'al', 'es', 'de', 'fr'] as $lang)
                                                    <div class="mb-3">
                                                        <label for="description_{{ $lang }}" class="fw-semibold">"Description {{ $lang }}"</label>
                                                        <input type="search" name="description_{{ $lang }}" id="description_{{ $lang }}"
                                                               class="form-control form-control-lg form-control-solid"
                                                               value="{{ $insurance->{'description_'.$lang} }}"
                                                               placeholder="Description_{{ $lang }}">
                                                        <span class="invalid-feedback"><strong></strong></span>
                                                    </div>
                                                @endforeach
                                            </div>

                                            {{-- Prices and Toggles --}}
                                            <div class="col-md-4">
                                                <h4 class="mb-4 text-success">Other</h4>

                                                <div class="mb-3">
                                                    <label for="price_per_day" class="fw-semibold">Price Per Day (€)</label>
                                                    <input type="number" name="price_per_day" id="price_per_day"
                                                           class="form-control form-control-lg form-control-solid"
                                                           value="{{ $insurance->price_per_day }}"
                                                           placeholder="Price Per Day">
                                                    <span class="invalid-feedback"><strong></strong></span>
                                                </div>

                                                <div class="mb-4 mt-7">
                                                    <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack mb-3">
                                                        <span class="form-check-label fw-bold fs-6 text-gray-700">Has Deposit</span>
                                                        <input class="form-check-input" type="checkbox" name="has_deposit" id="has_deposit"
                                                                {{ $insurance->has_deposit ? 'checked' : '' }}>
                                                    </label>
                                                </div>

                                                <div class="mb-3" id="deposit_container" style="display: {{ $insurance->has_deposit ? 'block' : 'none' }};">
                                                    <label for="deposit_price" class="fw-semibold">Deposit Price</label>
                                                    <input type="number" name="deposit_price" id="deposit_price"
                                                           class="form-control form-control-lg form-control-solid"
                                                           value="{{ $insurance->deposit_price }}"
                                                           placeholder="Deposit Price">
                                                    <span class="invalid-feedback"><strong></strong></span>
                                                </div>

                                                <div class="mb-4 mt-7">
                                                    <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
                                                        <span class="form-check-label fw-bold fs-6 text-gray-700">Has Theft Protection</span>
                                                        <input class="form-check-input" type="checkbox" name="has_theft_protection" id="has_theft_protection"
                                                                {{ $insurance->has_theft_protection ? 'checked' : '' }}>
                                                    </label>
                                                </div>

                                                <div class="mb-3" id="theft_protection_container" style="display: {{ $insurance->has_theft_protection ? 'block' : 'none' }};">
                                                    <label for="theft_protection_price" class="fw-semibold">Theft Protection Price</label>
                                                    <input type="number" name="theft_protection_price" id="theft_protection_price"
                                                           class="form-control form-control-lg form-control-solid"
                                                           value="{{ $insurance->theft_protection_price }}"
                                                           placeholder="Theft Protection Price">
                                                    <span class="invalid-feedback"><strong></strong></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                                        <button type="submit" class="submit-btn-2 btn btn-primary">
                                            <i class="ki-outline ki-triangle fs-3"></i>
                                            <i class="fa fa-spinner fa-spin d-none"></i>
                                            Update
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script>
        const depositCheckbox = document.getElementById('has_deposit');
        const depositContainer = document.getElementById('deposit_container');

        const theftCheckbox = document.getElementById('has_theft_protection');
        const theftContainer = document.getElementById('theft_protection_container');

        depositCheckbox.addEventListener('change', () => {
            depositContainer.style.display = depositCheckbox.checked ? 'block' : 'none';
        });

        theftCheckbox.addEventListener('change', () => {
            theftContainer.style.display = theftCheckbox.checked ? 'block' : 'none';
        });
    </script>
@endsection
