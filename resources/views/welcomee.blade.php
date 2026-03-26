{{--<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RentalBania - Car Rental Albania</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" type="image/png" href="{{ asset('logo_rent.png') }}">
    @vite('resources/js/app.js')

    <style>
        body { font-family: 'Montserrat', sans-serif; }
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), url("{{asset('peterfazekas.jpg')}}");
            background-size: cover;
            background-position: center;
            height: 550px;
        }
        .search-box {
            margin-top: -60px;
        }
        .nav-link-active {
            border-bottom: 3px solid #f97316;
        }
    </style>
</head>

<body class="bg-gray-50">

<nav class="absolute top-0 left-0 right-0 z-50 flex items-center justify-between px-12 py-5 text-white bg-transparent">

    <a href="/" class="flex items-center">
        <img src="{{ asset('logo_rent.png') }}" alt="RENTALBANIA Logo" class="h-24 w-auto object-contain drop-shadow-md">
    </a>

    <div class="hidden md:flex items-center gap-8 text-xs font-bold uppercase tracking-widest">
        <a href="#" class="hover:text-orange-500 transition">ABOUT US</a>
        <a href="#" class="hover:text-orange-500 transition">FAQs</a>
        <a href="#" class="hover:text-orange-500 transition">CONTACT</a>
        <a href="#" class="bg-orange-600 px-6 py-2 rounded text-white hover:bg-orange-700 shadow-lg transition">BEGIN NOW</a>
    </div>
</nav>

<div class="hero-section flex flex-col items-center justify-center text-center text-white px-4">
    <h1 class="text-5xl font-extrabold mb-4 drop-shadow-md uppercase tracking-tight leading-tight">
        DISCOVER ALBANIA WITH FREEDOM:<br>BOOK YOUR CAR TODAY!
    </h1>
    <p class="text-lg font-medium opacity-90 drop-shadow-sm">Reliable Car Rental, Transparent Prices & Quick Booking</p>
</div>


<div class="max-w-6xl mx-auto px-4 search-box relative z-10">
    <div class="bg-white rounded-xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] p-8">

        <form action="{{ route('search.cars') }}" method="GET" id="searchForm">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            --}}{{--<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 items-end">

                <div class="lg:col-span-1">
                    <label class="flex items-center text-[10px] font-bold text-gray-400 uppercase mb-2">
                        <i class="fas fa-car text-gray-500 mr-2"></i> Category
                    </label>
                    <select name="vehicleCategories" class="w-full border border-gray-100 rounded-md p-3 text-sm font-medium bg-gray-50 focus:ring-2 focus:ring-orange-500 outline-none">
                        <option value="">All Categories</option>
                        @if(isset($categories))
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->title_en }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="lg:col-span-1">
                    <label class="flex items-center text-[10px] font-bold text-gray-400 uppercase mb-2">
                        <i class="fas fa-map-marker-alt text-gray-500 mr-2"></i> Pick-up Location
                    </label>
                    <select name="city" class="w-full border border-gray-100 rounded-md p-3 text-sm font-medium bg-gray-50 focus:ring-2 focus:ring-orange-500 outline-none">
                        <option value="">Select Location</option>
                        @if(isset($cities))
                            @foreach($cities as $city)
                                <option value="{{ $city->name }}">{{ ucwords($city->name) }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="lg:col-span-1">
                    <label class="flex items-center text-[10px] font-bold text-gray-400 uppercase mb-2">
                        <i class="fas fa-calendar-alt text-gray-500 mr-2"></i> Pick-up Date
                    </label>
                    <div class="flex border border-gray-100 rounded-md bg-gray-50 focus-within:ring-2 focus-within:ring-orange-500">
                        <input type="date" name="pickupDate" required class="w-3/5 p-2 text-xs font-medium bg-transparent outline-none border-r border-gray-200">
                        <input type="time" name="pickupTime" value="10:00" class="w-2/5 p-2 text-xs font-medium bg-transparent outline-none">
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <label class="flex items-center text-[10px] font-bold text-gray-400 uppercase mb-2">
                        <i class="fas fa-calendar-check text-gray-500 mr-2"></i> Drop-off Date
                    </label>
                    <div class="flex border border-gray-100 rounded-md bg-gray-50 focus-within:ring-2 focus-within:ring-orange-500">
                        <input type="date" name="dropoffDate" required class="w-3/5 p-2 text-xs font-medium bg-transparent outline-none border-r border-gray-200">
                        <input type="time" name="dropoffTime" value="10:00" class="w-2/5 p-2 text-xs font-medium bg-transparent outline-none">
                    </div>
                </div>

                <div class="lg:col-span-1 flex flex-col justify-end relative">
                    <div id="duration-display" class="absolute -top-6 left-0 right-0 text-center text-[10px] font-extrabold text-orange-600 uppercase tracking-widest opacity-0 transition-opacity duration-300 bg-orange-50 py-1 rounded-t-md border border-orange-100 border-b-0">
                        <i class="fas fa-clock mr-1"></i> <span id="days-count">0</span> Days
                    </div>

                    <button type="submit" class="w-full h-[46px] bg-orange-600 text-white font-black rounded-lg hover:bg-orange-700 transition uppercase tracking-tighter text-sm shadow-md flex items-center justify-center relative z-10">
                        SEARCH
                    </button>
                </div>

            </div>--}}{{--

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-6 items-end">

                <div class="lg:col-span-1">
                    <label class="flex items-center text-[10px] font-bold text-gray-400 uppercase mb-2">
                        <i class="fas fa-car text-gray-500 mr-2"></i> Category
                    </label>
                    <select name="vehicleCategories" class="w-full border border-gray-100 rounded-md p-3 text-sm font-medium bg-gray-50 focus:ring-2 focus:ring-orange-500 outline-none">
                        <option value="">All Categories</option>
                        @if(isset($categories))
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->title_en }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="lg:col-span-1">
                    <label class="flex items-center text-[10px] font-bold text-gray-400 uppercase mb-2">
                        <i class="fas fa-map-marker-alt text-gray-500 mr-2"></i> Pick-up Location
                    </label>
                    <select name="pickupLocation" class="w-full border border-gray-100 rounded-md p-3 text-sm font-medium bg-gray-50 focus:ring-2 focus:ring-orange-500 outline-none">
                        <option value="">Select Location</option>
                        @if(isset($deliveries))
                            @foreach($deliveries as $delivery)
                                @php
                                    $cityName = $delivery->city_id == 1 ? 'Tirana' : ($delivery->city_id == 11 ? 'Saranda' : 'City '.$delivery->city_id);
                                    $placeName = $delivery->place;

                                    if ($placeName == 'Airport') $displayName = $cityName . ' International Airport';
                                    elseif ($placeName == 'Center') $displayName = $cityName . ' Center';
                                    else $displayName = $cityName . ' ' . $placeName; // psh. Tirana Train Station
                                @endphp
                                <option value="{{ $delivery->id }}" data-price="{{ $delivery->price }}">
                                    {{ $displayName }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="lg:col-span-1">
                    <label class="flex items-center text-[10px] font-bold text-gray-400 uppercase mb-2">
                        <i class="fas fa-map-pin text-gray-500 mr-2"></i> Drop-off Location
                    </label>
                    <select name="dropoffLocation" class="w-full border border-gray-100 rounded-md p-3 text-sm font-medium bg-gray-50 focus:ring-2 focus:ring-orange-500 outline-none">
                        <option value="">Select Location</option>
                        @if(isset($deliveries))
                            @foreach($deliveries as $delivery)
                                @php
                                    $cityName = $delivery->city_id == 1 ? 'Tirana' : ($delivery->city_id == 11 ? 'Saranda' : 'City '.$delivery->city_id);
                                    $placeName = $delivery->place;

                                    if ($placeName == 'Airport') $displayName = $cityName . ' International Airport';
                                    elseif ($placeName == 'Center') $displayName = $cityName . ' Center';
                                    else $displayName = $cityName . ' ' . $placeName;
                                @endphp
                                <option value="{{ $delivery->id }}" data-price="{{ $delivery->price }}">
                                    {{ $displayName }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="lg:col-span-1">
                    <label class="flex items-center text-[10px] font-bold text-gray-400 uppercase mb-2">
                        <i class="fas fa-calendar-alt text-gray-500 mr-2"></i> Pick-up Date
                    </label>
                    <div class="flex border border-gray-100 rounded-md bg-gray-50 focus-within:ring-2 focus-within:ring-orange-500">
                        <input type="date" name="pickupDate" required class="w-3/5 p-2 text-xs font-medium bg-transparent outline-none border-r border-gray-200">
                        <input type="time" name="pickupTime" value="10:00" class="w-2/5 p-2 text-xs font-medium bg-transparent outline-none">
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <label class="flex items-center text-[10px] font-bold text-gray-400 uppercase mb-2">
                        <i class="fas fa-calendar-check text-gray-500 mr-2"></i> Drop-off Date
                    </label>
                    <div class="flex border border-gray-100 rounded-md bg-gray-50 focus-within:ring-2 focus-within:ring-orange-500">
                        <input type="date" name="dropoffDate" required class="w-3/5 p-2 text-xs font-medium bg-transparent outline-none border-r border-gray-200">
                        <input type="time" name="dropoffTime" value="10:00" class="w-2/5 p-2 text-xs font-medium bg-transparent outline-none">
                    </div>
                </div>

                <div class="lg:col-span-1 flex flex-col justify-end relative">
                    <div id="duration-display" class="absolute -top-6 left-0 right-0 text-center text-[10px] font-extrabold text-orange-600 uppercase tracking-widest opacity-0 transition-opacity duration-300 bg-orange-50 py-1 rounded-t-md border border-orange-100 border-b-0">
                        <i class="fas fa-clock mr-1"></i> <span id="days-count">0</span> Days
                    </div>

                    <button type="submit" class="w-full h-[46px] bg-orange-600 text-white font-black rounded-lg hover:bg-orange-700 transition uppercase tracking-tighter text-sm shadow-md flex items-center justify-center relative z-10">
                        SEARCH
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

--}}{{--<div class="max-w-6xl mx-auto px-4 py-20">
    <h2 class="text-3xl font-black text-center text-gray-800 mb-16 uppercase tracking-tight">SELECT YOUR IDEAL CAR</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @forelse($vehicles as $vehicle)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-xl transition-all duration-300 flex flex-col">

                <div class="relative overflow-hidden h-52 shrink-0 bg-gray-50">
                    @if($vehicle->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $vehicle->images->first()->path) }}" alt="{{ $vehicle->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    @else
                        <img src="https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?auto=format&fit=crop&w=600&q=80" alt="Default Car" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 opacity-80">
                    @endif

                    <div class="absolute top-4 right-4 bg-white/90 p-2 rounded-full text-orange-600 cursor-pointer shadow-sm hover:bg-orange-600 hover:text-white transition">
                        <i class="fas fa-heart text-sm"></i>
                    </div>
                </div>

                <div class="p-6 flex flex-col flex-grow">

                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h3 class="font-extrabold text-xl text-gray-800 uppercase">{{ $vehicle->title }}</h3>
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mt-1">
                                {{ $vehicle->vehicleCategory->title_en ?? 'Standard Category' }}
                            </span>
                        </div>
                        <div class="flex items-center gap-1 text-[10px] font-bold text-gray-600 bg-gray-50 px-2 py-1.5 rounded-md border border-gray-100">
                            <span class="bg-green-500 text-white px-1 py-0.5 rounded text-[10px]">8.5</span> Excellent
                        </div>
                    </div>

                    <div class="mb-5 border-b border-gray-50 pb-4">
                        <span class="bg-blue-50 text-blue-800 text-[10px] font-bold px-2 py-1 rounded uppercase tracking-widest border border-blue-100">
                            <i class="fas fa-building mr-1"></i> {{ $vehicle->company->name ?? 'Partner Agency' }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-y-3 gap-x-2 text-[10px] font-bold text-gray-500 mb-4 uppercase">
                        <div class="flex items-center" title="Seats"><i class="fas fa-users mr-2 text-gray-300 text-sm"></i> {{ $vehicle->seats ?? 5 }} Seats</div>
                        <div class="flex items-center" title="Luggage"><i class="fas fa-suitcase mr-2 text-gray-300 text-sm"></i> 2 Bags</div>
                        <div class="flex items-center" title="Doors"><i class="fas fa-door-open mr-2 text-gray-300 text-sm"></i> 4 Doors</div>
                        <div class="flex items-center" title="Transmission"><i class="fas fa-cog mr-2 text-gray-300 text-sm"></i> {{ $vehicle->transmissionType->title_en ?? 'Auto' }}</div>
                        <div class="flex items-center col-span-2" title="Fuel Type"><i class="fas fa-gas-pump mr-2 text-gray-300 text-sm"></i> {{ $vehicle->fuelType->title_en ?? 'N/A' }}</div>
                    </div>

                    <div class="flex items-center text-[10px] font-bold text-green-600 uppercase mb-6">
                        <i class="fas fa-check-circle mr-2 text-sm"></i>
                        {{ $vehicle->international_licence_required ? 'Intl. License Required' : 'Free Cancellation' }}
                    </div>

                    <div class="mt-auto pt-4 border-t border-gray-50">
                        <div class="flex justify-between items-end mb-4">
                            <div>
                                @php
                                    $days = $totalDays ?? 1;
                                    $totalPrice = $vehicle->base_daily_rate * $days;
                                @endphp
                                <span class="block text-[10px] text-gray-400 font-bold uppercase tracking-widest">Total for {{ $days }} Days</span>
                                <span class="text-gray-800 font-black text-lg">€{{ number_format($totalPrice, 2) }}</span>
                            </div>
                            <div class="text-right leading-none">
                                <span class="text-orange-600 font-black text-2xl">€{{ number_format($vehicle->base_daily_rate, 0) }}</span>
                                <span class="text-[10px] text-gray-400 font-bold uppercase block mt-1">/day</span>
                            </div>
                        </div>

                        <a href="{{ route('api.show_vehicle', $vehicle->id) }}" class="block text-center w-full bg-orange-600 text-white font-black py-3 rounded-lg hover:bg-orange-700 transition-all uppercase text-xs tracking-widest shadow-md">
                            BOOK NOW
                        </a>
                    </div>
                </div>

            </div>
        @empty
            <div class="col-span-1 md:col-span-3 bg-white p-12 text-center rounded-2xl border border-gray-100 shadow-sm">
                <i class="fas fa-car-side text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-700">No cars found</h3>
                <p class="text-sm text-gray-400 mt-2">Agencies are currently updating their fleets. Please try adjusting your search dates or filters.</p>
            </div>
        @endforelse
    </div>
</div>--}}{{--

<div class="max-w-6xl mx-auto px-4 py-20">
    <div class="flex flex-col md:flex-row justify-between items-center mb-12">
        <div class="text-center md:text-left mb-4 md:mb-0">
            <h2 class="text-3xl font-black text-gray-800 uppercase tracking-tight">SELECT YOUR IDEAL CAR</h2>
            <p class="text-[11px] font-bold text-orange-600 uppercase tracking-widest mt-2">
                <i class="fas fa-th-list mr-1"></i>
                Total:<span id="total-cars-count">{{ $vehicles->total() }}</span> Vehicles Available
            </p>
        </div>
    </div>

    <div id="vehicles-container" class="grid grid-cols-1 md:grid-cols-3 gap-8 transition-all duration-500">
        @include('partials.vehicle_list', ['vehicles' => $vehicles])
    </div>

    <div id="load-more-container" class="mt-16 text-center {{ $vehicles->hasMorePages() ? '' : 'hidden' }}">
        <button id="btn-load-more"
                data-url="{{ $vehicles->nextPageUrl() }}"
                class="px-10 py-4 border-2 border-orange-600 text-orange-600 font-black rounded-xl hover:bg-orange-600 hover:text-white transition-all uppercase text-xs tracking-widest shadow-sm">
            Show More Vehicles <i class="fas fa-chevron-down ml-2"></i>
        </button>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 pb-24">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach(['All-Inclusive Prices' => 'No Hidden Fees', '24/7 Support' => 'Roadside Assistance', 'Free Cancellation' => 'Up to 48h before', 'No Deposit (optional)' => 'No Deposit'] as $title => $desc)
            <div class="bg-white p-6 rounded-xl border border-gray-50 shadow-sm text-center flex flex-col items-center group hover:shadow-md transition">
                <div class="w-12 h-12 bg-orange-50 rounded-lg flex items-center justify-center text-orange-600 mb-4 group-hover:bg-orange-600 group-hover:text-white transition">
                    <i class="fas fa-shield-alt text-xl"></i>
                </div>
                <h4 class="font-black text-[11px] text-gray-800 uppercase mb-1">{{ $title }}</h4>
                <p class="text-[10px] text-gray-400 font-medium">{{ $desc }}</p>
            </div>
        @endforeach
    </div>
</div>
@include('partials.booking_modal')

<footer class="bg-white border-t border-gray-100 py-16">
    <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-12">
        <div class="col-span-1">
            <div class="flex items-center gap-2 mb-6">
                <i class="fas fa-car-side text-orange-600"></i>
                <span class="font-black text-gray-800 tracking-tighter">RENTALBANIA</span>
            </div>
            <p class="text-[11px] text-gray-400 leading-relaxed font-medium">
                The best car rental service in Albania. Providing tourists with safe and modern vehicles to explore our beautiful country.
            </p>
        </div>
    </div>
    <div class="text-center text-[10px] font-bold text-gray-300 mt-16 tracking-widest uppercase">
        © 2026 RENTALBANIA. ALL RIGHTS RESERVED.
    </div>
</footer>

--}}{{--<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pickupDateInput = document.querySelector('input[name="pickupDate"]');
        const pickupTimeInput = document.querySelector('input[name="pickupTime"]');
        const dropoffDateInput = document.querySelector('input[name="dropoffDate"]');
        const dropoffTimeInput = document.querySelector('input[name="dropoffTime"]');

        const durationDisplay = document.getElementById('duration-display');
        const daysCountSpan = document.getElementById('days-count');

        function calculateDays() {
            const pickupDate = pickupDateInput.value;
            const pickupTime = pickupTimeInput.value;
            const dropoffDate = dropoffDateInput.value;
            const dropoffTime = dropoffTimeInput.value;

            if (pickupDate && dropoffDate && pickupTime && dropoffTime) {
                const start = new Date(`${pickupDate}T${pickupTime}`);
                const end = new Date(`${dropoffDate}T${dropoffTime}`);

                const diffTime = end - start;

                if (diffTime >= 0) {

                    const diffMinutes = Math.floor(diffTime / (1000 * 60));

                    let diffDays = Math.floor(diffMinutes / (24 * 60));

                    const remainderMinutes = diffMinutes % (24 * 60);

                    if (remainderMinutes >= 15) {
                        diffDays += 1;
                    }

                    const totalDays = diffDays + 1;

                    daysCountSpan.textContent = totalDays;
                    durationDisplay.classList.remove('opacity-0');
                    durationDisplay.classList.add('opacity-100');
                } else {
                    durationDisplay.classList.remove('opacity-100');
                    durationDisplay.classList.add('opacity-0');
                }
            }
        }

        const inputs = [pickupDateInput, pickupTimeInput, dropoffDateInput, dropoffTimeInput];
        inputs.forEach(input => {
            input.addEventListener('input', calculateDays);
            input.addEventListener('change', calculateDays);
        });
    });
</script>

<script>
    document.getElementById('searchForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const container = document.getElementById('vehicles-container');

        container.style.opacity = '0.3';

        // 🔥 KJO ËSHTË PIKA KYÇE
        const params = new URLSearchParams(formData);

        fetch(this.action + '?' + params.toString(), {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.text())
            .then(html => {
                container.innerHTML = html;
                container.style.opacity = '1';

                container.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            })
            .catch(error => {
                console.error('Error:', error);
                container.style.opacity = '1';
            });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnLoadMore = document.getElementById('btn-load-more');
        const container = document.getElementById('vehicles-container');
        const countDisplay = document.getElementById('active-cars-count');

        function updateCarCount() {
            const currentCount = container.querySelectorAll('.group').length;
            countDisplay.textContent = currentCount;

            if (currentCount === 0) {
                btnLoadMore.style.display = 'none';
            } else {
                btnLoadMore.style.display = 'inline-block';
            }
        }

        btnLoadMore.addEventListener('click', function() {
            this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> LOADING...';
            this.disabled = true;

            setTimeout(() => {

                this.innerHTML = 'Show More Vehicles <i class="fas fa-chevron-down ml-2"></i>';
                this.disabled = false;

                alert("All available vehicles for these dates are shown.");
                this.style.display = 'none';
            }, 800);
        });

    });
</script>--}}{{--

--}}{{--<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- ELEMENTET ---
        const searchForm = document.getElementById('searchForm');
        const container = document.getElementById('vehicles-container');
        const btnLoadMore = document.getElementById('btn-load-more');
        const loadMoreContainer = document.getElementById('load-more-container');
        const activeCount = document.getElementById('active-cars-count');
        const totalCount = document.getElementById('total-cars-count');

        const pickupDateInput = document.querySelector('input[name="pickupDate"]');
        const pickupTimeInput = document.querySelector('input[name="pickupTime"]');
        const dropoffDateInput = document.querySelector('input[name="dropoffDate"]');
        const dropoffTimeInput = document.querySelector('input[name="dropoffTime"]');
        const durationDisplay = document.getElementById('duration-display');
        const daysCountSpan = document.getElementById('days-count');

        // --- 1. LLOGARITJA E DITËVE ---
        function calculateDays() {
            if (pickupDateInput.value && dropoffDateInput.value) {
                const start = new Date(`${pickupDateInput.value}T${pickupTimeInput.value}`);
                const end = new Date(`${dropoffDateInput.value}T${dropoffTimeInput.value}`);
                const diffTime = end - start;

                if (diffTime >= 0) {
                    const diffMinutes = Math.floor(diffTime / (1000 * 60));
                    let diffDays = Math.floor(diffMinutes / (24 * 60));
                    if ((diffMinutes % (24 * 60)) >= 15) diffDays++;

                    const totalDays = diffDays + 1;
                    daysCountSpan.textContent = totalDays;
                    durationDisplay.classList.replace('opacity-0', 'opacity-100');
                } else {
                    durationDisplay.classList.replace('opacity-100', 'opacity-0');
                }
            }
        }
        [pickupDateInput, pickupTimeInput, dropoffDateInput, dropoffTimeInput].forEach(i => i.addEventListener('change', calculateDays));

        // --- 2. LOGJIKA E SEARCH (AJAX) ---
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const params = new URLSearchParams(new FormData(this));
            container.style.opacity = '0.3';

            fetch(this.action + '?' + params.toString(), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(res => res.json())
                .then(data => {
                    container.innerHTML = data.html;
                    container.style.opacity = '1';
                    activeCount.textContent = data.current_count;
                    totalCount.textContent = data.total;

                    if (data.has_more) {
                        loadMoreContainer.classList.remove('hidden');
                        btnLoadMore.setAttribute('data-url', data.next_page);
                    } else {
                        loadMoreContainer.classList.add('hidden');
                    }
                });
        });

        // --- 3. LOGJIKA E SHOW MORE (AJAX) ---
        btnLoadMore.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> LOADING...';

            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(res => res.json())
                .then(data => {
                    container.insertAdjacentHTML('beforeend', data.html);
                    activeCount.textContent = container.querySelectorAll('.group').length;
                    this.innerHTML = 'Show More Vehicles <i class="fas fa-chevron-down ml-2"></i>';
                    if (data.has_more) this.setAttribute('data-url', data.next_page);
                    else loadMoreContainer.classList.add('hidden');
                });
        });

        // --- 4. LOGJIKA E MODALIT (EVENT DELEGATION) ---
        const modal = document.getElementById('booking-modal');
        const leftContent = document.getElementById('modal-left-content');
        const rightContent = document.getElementById('modal-right-content');

        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-book-now');
            if (btn) {
                const vehicleId = btn.getAttribute('data-vehicle-id');
                let days = daysCountSpan.textContent.trim();
                if (days === "0" || !days) days = 1;

                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');

                fetch(`/vehicle/${vehicleId}/booking-details?days=${days}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                    .then(res => res.text())
                    .then(html => {
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = html;
                        leftContent.innerHTML = tempDiv.querySelector('#ajax-left-content').innerHTML;
                        rightContent.innerHTML = tempDiv.querySelector('#ajax-right-content').innerHTML;
                    });
            }

            // Mbyllja e modalit
            if (e.target.id === 'modal-overlay' || e.target.closest('#close-modal')) {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
                leftContent.innerHTML = '<div class="flex items-center justify-center h-full text-orange-600"><i class="fas fa-spinner fa-spin fa-3x"></i></div>';
            }
        });
    });
</script>--}}{{--

--}}{{--<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- ELEMENTET ---
        const searchForm = document.getElementById('searchForm');
        const container = document.getElementById('vehicles-container');
        const btnLoadMore = document.getElementById('btn-load-more');
        const loadMoreContainer = document.getElementById('load-more-container');
        const activeCount = document.getElementById('active-cars-count');
        const totalCount = document.getElementById('total-cars-count');

        const pickupDateInput = document.querySelector('input[name="pickupDate"]');
        const pickupTimeInput = document.querySelector('input[name="pickupTime"]');
        const dropoffDateInput = document.querySelector('input[name="dropoffDate"]');
        const dropoffTimeInput = document.querySelector('input[name="dropoffTime"]');
        const durationDisplay = document.getElementById('duration-display');
        const daysCountSpan = document.getElementById('days-count');

        const modal = document.getElementById('booking-modal');
        const leftContent = document.getElementById('modal-left-content');
        const rightContent = document.getElementById('modal-right-content');

        // --- FUNKSIONI KRYESOR PËR NDËRRIMIN E TABS (I deklaruar lart) ---
        function showTab(type) {
            const tabCar = document.getElementById('tab-car-content');
            const tabBooking = document.getElementById('tab-booking-content');
            const btnCar = document.getElementById('step-car-btn');
            const btnBooking = document.getElementById('step-booking-btn');
            const mainBtn = document.getElementById('modal-main-btn');

            if (!tabCar || !tabBooking || !mainBtn) return;

            if (type === 'car') {
                tabCar.classList.remove('hidden');
                tabBooking.classList.add('hidden');

                // Stilimi i hapit 1 aktiv
                if(btnCar) {
                    btnCar.querySelector('span').className = "w-6 h-6 rounded-full bg-orange-600 text-white flex items-center justify-center text-[9px]";
                    btnCar.className = "flex items-center gap-2 text-orange-600 transition hover:opacity-80";
                }

                // Stilimi i hapit 2 jo-aktiv
                if(btnBooking) {
                    btnBooking.querySelector('span').className = "w-6 h-6 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center text-[9px]";
                    btnBooking.className = "flex items-center gap-2 text-gray-400 transition hover:text-orange-600";
                }

                mainBtn.innerHTML = '<span>Continue</span> <i class="fas fa-arrow-right text-[10px]"></i>';
                mainBtn.className = "w-full bg-orange-600 text-white font-black py-5 rounded-[1.5rem] hover:bg-orange-700 transition shadow-lg shadow-orange-100 uppercase text-xs tracking-widest flex items-center justify-center gap-2";
            } else {
                tabCar.classList.add('hidden');
                tabBooking.classList.remove('hidden');

                // Stilimi i hapit 2 aktiv
                if(btnBooking) {
                    btnBooking.querySelector('span').className = "w-6 h-6 rounded-full bg-orange-600 text-white flex items-center justify-center text-[9px]";
                    btnBooking.className = "flex items-center gap-2 text-orange-600 transition hover:opacity-80";
                }

                // Stilimi i hapit 1 jo-aktiv
                if(btnCar) {
                    btnCar.querySelector('span').className = "w-6 h-6 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center text-[9px]";
                    btnCar.className = "flex items-center gap-2 text-gray-400 transition hover:text-orange-600";
                }

                mainBtn.innerHTML = '<span>Confirm Reservation</span> <i class="fas fa-check text-[10px]"></i>';
                mainBtn.className = "w-full bg-green-600 text-white font-black py-5 rounded-[1.5rem] hover:bg-green-700 transition shadow-lg shadow-green-100 uppercase text-xs tracking-widest flex items-center justify-center gap-2";
            }
            leftContent.scrollTop = 0;
        }

        // --- 1. LLOGARITJA E DITËVE ---
        function calculateDays() {
            if (pickupDateInput && pickupDateInput.value && dropoffDateInput.value) {
                const start = new Date(`${pickupDateInput.value}T${pickupTimeInput.value}`);
                const end = new Date(`${dropoffDateInput.value}T${dropoffTimeInput.value}`);
                const diffTime = end - start;

                if (diffTime >= 0) {
                    const diffMinutes = Math.floor(diffTime / (1000 * 60));
                    let diffDays = Math.floor(diffMinutes / (24 * 60));
                    if ((diffMinutes % (24 * 60)) >= 15) diffDays++;

                    const totalDays = diffDays + 1;
                    if(daysCountSpan) daysCountSpan.textContent = totalDays;
                    if (durationDisplay) durationDisplay.classList.replace('opacity-0', 'opacity-100');
                } else {
                    if (durationDisplay) durationDisplay.classList.replace('opacity-100', 'opacity-0');
                }
            }
        }
        [pickupDateInput, pickupTimeInput, dropoffDateInput, dropoffTimeInput].forEach(i => {
            if(i) i.addEventListener('change', calculateDays);
        });

        // --- 2. LOGJIKA E SEARCH (AJAX) ---
        if (searchForm) {
            searchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const params = new URLSearchParams(new FormData(this));
                container.style.opacity = '0.3';

                fetch(this.action + '?' + params.toString(), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                    .then(res => res.json())
                    .then(data => {
                        container.innerHTML = data.html;
                        container.style.opacity = '1';
                        if(activeCount) activeCount.textContent = data.current_count;
                        if(totalCount) totalCount.textContent = data.total;

                        if (data.has_more) {
                            loadMoreContainer.classList.remove('hidden');
                            btnLoadMore.setAttribute('data-url', data.next_page);
                        } else {
                            loadMoreContainer.classList.add('hidden');
                        }
                    });
            });
        }

        // --- 3. LOGJIKA E SHOW MORE (AJAX) ---
        if (btnLoadMore) {
            btnLoadMore.addEventListener('click', function() {
                const url = this.getAttribute('data-url');
                this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> LOADING...';

                fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(res => res.json())
                    .then(data => {
                        container.insertAdjacentHTML('beforeend', data.html);
                        if(activeCount) activeCount.textContent = container.querySelectorAll('.group').length;
                        this.innerHTML = 'Show More Vehicles <i class="fas fa-chevron-down ml-2"></i>';
                        if (data.has_more) this.setAttribute('data-url', data.next_page);
                        else loadMoreContainer.classList.add('hidden');
                    });
            });
        }

        // --- 4. LOGJIKA E MODALIT DHE NAVIGIMIT (EVENT DELEGATION) ---
        document.addEventListener('click', function(e) {
            // A. HAPJA E MODALIT
            const bookBtn = e.target.closest('.btn-book-now');
            if (bookBtn) {
                const vehicleId = bookBtn.getAttribute('data-vehicle-id');
                let days = (daysCountSpan) ? daysCountSpan.textContent.trim() : 1;
                if (days === "0" || !days) days = 1;

                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');

                leftContent.innerHTML = '<div class="flex items-center justify-center h-full text-orange-600"><i class="fas fa-spinner fa-spin fa-3x"></i></div>';
                rightContent.innerHTML = '<div class="flex items-center justify-center h-full text-orange-600"><i class="fas fa-spinner fa-spin fa-2x"></i></div>';

                fetch(`/vehicle/${vehicleId}/booking-details?days=${days}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                    .then(res => res.text())
                    .then(html => {
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = html;

                        const newLeftTabCar = tempDiv.querySelector('#tab-car-content');
                        const newLeftTabBooking = tempDiv.querySelector('#tab-booking-content');
                        const newRightSummary = tempDiv.querySelector('#summary-content');

                        if(newLeftTabCar && newLeftTabBooking && newRightSummary) {
                            leftContent.innerHTML = '';
                            leftContent.appendChild(newLeftTabCar);
                            leftContent.appendChild(newLeftTabBooking);
                            rightContent.innerHTML = newRightSummary.innerHTML;

                            showTab('car');
                        }
                    })
                    .catch(err => {
                        console.error("Error loading modal:", err);
                        leftContent.innerHTML = '<div class="text-red-500 p-10">Gabim gjatë ngarkimit.</div>';
                    });
            }

            // B. NAVIGIMI TE STEPS
            const btnNext = e.target.closest('#modal-main-btn');
            const stepCar = e.target.closest('#step-car-btn');
            const stepBooking = e.target.closest('#step-booking-btn');

            if (stepCar) showTab('car');

            // Verifikojmë butonin Continue duke parë nëse ka fjalën Continue brenda
            if (stepBooking || (btnNext && btnNext.textContent.trim().includes('Continue'))) {
                showTab('booking');
            }

            // C. MBYLLJA
            if (e.target.id === 'modal-overlay' || e.target.closest('#close-modal')) {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        });
    });
</script>--}}{{--

<script>

    window.updateInsuranceUI = function(selectedRadio) {
        document.querySelectorAll('.insurance-label').forEach(label => {
            label.classList.remove('border-orange-500', 'bg-orange-50/30');
            label.classList.add('border-gray-100');
        });
        const parentLabel = selectedRadio.closest('label');
        parentLabel.classList.remove('border-gray-100');
        parentLabel.classList.add('border-orange-500', 'bg-orange-50/30');
    };

    document.addEventListener('DOMContentLoaded', function() {

        const searchForm = document.getElementById('searchForm');
        const container = document.getElementById('vehicles-container');
        const btnLoadMore = document.getElementById('btn-load-more');
        const loadMoreContainer = document.getElementById('load-more-container');
        const activeCount = document.getElementById('active-cars-count');
        const totalCount = document.getElementById('total-cars-count');

        const pickupDateInput = document.querySelector('input[name="pickupDate"]');
        const pickupTimeInput = document.querySelector('input[name="pickupTime"]');
        const dropoffDateInput = document.querySelector('input[name="dropoffDate"]');
        const dropoffTimeInput = document.querySelector('input[name="dropoffTime"]');
        const durationDisplay = document.getElementById('duration-display');
        const daysCountSpan = document.getElementById('days-count');

        const modal = document.getElementById('booking-modal');
        const leftContent = document.getElementById('modal-left-content');
        const rightContent = document.getElementById('modal-right-content');

        function showTab(type) {
            const tabCar = document.getElementById('tab-car-content');
            const tabBooking = document.getElementById('tab-booking-content');
            const btnCar = document.getElementById('step-car-btn');
            const btnBooking = document.getElementById('step-booking-btn');
            const mainBtn = document.getElementById('modal-main-btn');

            if (!tabCar || !tabBooking || !mainBtn) return;

            if (type === 'car') {
                tabCar.classList.remove('hidden');
                tabBooking.classList.add('hidden');

                if(btnCar) {
                    btnCar.querySelector('span').className = "w-6 h-6 rounded-full bg-orange-600 text-white flex items-center justify-center text-[9px]";
                    btnCar.className = "flex items-center gap-2 text-orange-600 transition hover:opacity-80";
                }
                if(btnBooking) {
                    btnBooking.querySelector('span').className = "w-6 h-6 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center text-[9px]";
                    btnBooking.className = "flex items-center gap-2 text-gray-400 transition hover:text-orange-600";
                }

                mainBtn.innerHTML = '<span>Continue</span> <i class="fas fa-arrow-right text-[10px]"></i>';
                mainBtn.className = "w-full bg-orange-600 text-white font-black py-5 rounded-[1.5rem] hover:bg-orange-700 transition shadow-lg shadow-orange-100 uppercase text-xs tracking-widest flex items-center justify-center gap-2";
            } else {
                tabCar.classList.add('hidden');
                tabBooking.classList.remove('hidden');

                if(btnBooking) {
                    btnBooking.querySelector('span').className = "w-6 h-6 rounded-full bg-orange-600 text-white flex items-center justify-center text-[9px]";
                    btnBooking.className = "flex items-center gap-2 text-orange-600 transition hover:opacity-80";
                }
                if(btnCar) {
                    btnCar.querySelector('span').className = "w-6 h-6 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center text-[9px]";
                    btnCar.className = "flex items-center gap-2 text-gray-400 transition hover:text-orange-600";
                }

                mainBtn.innerHTML = '<span>Confirm Reservation</span> <i class="fas fa-check text-[10px]"></i>';
                mainBtn.className = "w-full bg-green-600 text-white font-black py-5 rounded-[1.5rem] hover:bg-green-700 transition shadow-lg shadow-green-100 uppercase text-xs tracking-widest flex items-center justify-center gap-2";
            }
            leftContent.scrollTop = 0;
        }

        function calculateDays() {
            if (pickupDateInput && pickupDateInput.value && dropoffDateInput.value) {
                const start = new Date(`${pickupDateInput.value}T${pickupTimeInput.value}`);
                const end = new Date(`${dropoffDateInput.value}T${dropoffTimeInput.value}`);
                const diffTime = end - start;

                if (diffTime >= 0) {
                    const diffMinutes = Math.floor(diffTime / (1000 * 60));
                    let diffDays = Math.floor(diffMinutes / (24 * 60));
                    if ((diffMinutes % (24 * 60)) >= 15) diffDays++;

                    const totalDays = diffDays + 1;
                    if(daysCountSpan) daysCountSpan.textContent = totalDays;
                    if (durationDisplay) durationDisplay.classList.replace('opacity-0', 'opacity-100');
                } else {
                    if (durationDisplay) durationDisplay.classList.replace('opacity-100', 'opacity-0');
                }
            }
        }
        [pickupDateInput, pickupTimeInput, dropoffDateInput, dropoffTimeInput].forEach(i => {
            if(i) i.addEventListener('change', calculateDays);
        });


        if (searchForm) {
            searchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const params = new URLSearchParams(new FormData(this));
                container.style.opacity = '0.3';
                fetch(this.action + '?' + params.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(res => res.json())
                    .then(data => {
                        container.innerHTML = data.html;
                        container.style.opacity = '1';
                        if(activeCount) activeCount.textContent = data.current_count;
                        if(totalCount) totalCount.textContent = data.total;
                        if (data.has_more) { loadMoreContainer.classList.remove('hidden'); btnLoadMore.setAttribute('data-url', data.next_page); }
                        else { loadMoreContainer.classList.add('hidden'); }
                    });
            });
        }

        if (btnLoadMore) {
            btnLoadMore.addEventListener('click', function() {
                const url = this.getAttribute('data-url');
                this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> LOADING...';
                fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(res => res.json())
                    .then(data => {
                        container.insertAdjacentHTML('beforeend', data.html);
                        if(activeCount) activeCount.textContent = container.querySelectorAll('.group').length;
                        this.innerHTML = 'Show More Vehicles <i class="fas fa-chevron-down ml-2"></i>';
                        if (data.has_more) this.setAttribute('data-url', data.next_page);
                        else loadMoreContainer.classList.add('hidden');
                    });
            });
        }

        document.addEventListener('click', function(e) {


            const bookBtn = e.target.closest('.btn-book-now');
            if (bookBtn) {
                const vehicleId = bookBtn.getAttribute('data-vehicle-id');
                let days = (daysCountSpan) ? daysCountSpan.textContent.trim() : 1;
                if (days === "0" || !days) days = 1;

                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');

                leftContent.innerHTML = '<div class="flex items-center justify-center h-full text-orange-600"><i class="fas fa-spinner fa-spin fa-3x"></i></div>';
                rightContent.innerHTML = '<div class="flex items-center justify-center h-full text-orange-600"><i class="fas fa-spinner fa-spin fa-2x"></i></div>';

                fetch(`/vehicle/${vehicleId}/booking-details?days=${days}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                    .then(res => res.text())
                    .then(html => {
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = html;

                        const newLeftTabCar = tempDiv.querySelector('#tab-car-content');
                        const newLeftTabBooking = tempDiv.querySelector('#tab-booking-content');
                        const newRightSummary = tempDiv.querySelector('#summary-content');

                        if(newLeftTabCar && newLeftTabBooking && newRightSummary) {
                            leftContent.innerHTML = '';
                            leftContent.appendChild(newLeftTabCar);
                            leftContent.appendChild(newLeftTabBooking);
                            rightContent.innerHTML = newRightSummary.innerHTML;
                            showTab('car');
                            updateModalBookingDetails();
                            calculateTotal();
                        }
                    })
                    .catch(err => {
                        console.error("Error loading modal:", err);
                        leftContent.innerHTML = '<div class="text-red-500 p-10">Gabim gjatë ngarkimit.</div>';
                    });
            }


            const stepCar = e.target.closest('#step-car-btn');
            const stepBooking = e.target.closest('#step-booking-btn');
            const btnNext = e.target.closest('#modal-main-btn');

            if (stepCar) showTab('car');
            if (stepBooking) showTab('booking');

            if (btnNext) {
                e.preventDefault();
                const buttonText = btnNext.textContent.trim();

                if (buttonText.includes('Continue')) {
                    showTab('booking');
                } else if (buttonText.includes('Confirm Reservation')) {

                    const originalBtnHtml = btnNext.innerHTML;
                    btnNext.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
                    btnNext.disabled = true;

                    const formatDate = (dateStr) => {
                        if (!dateStr) return null;
                        const [y, m, d] = dateStr.split('-');
                        return `${d}-${m}-${y}`;
                    };

                    const csrfToken = document.querySelector('input[name="_token"]')?.value || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');


                    const serviceInputs = document.querySelectorAll('.service-qty-input');
                    const formattedAdditionalServices = [];

                    serviceInputs.forEach(input => {
                        const qty = parseInt(input.value) || 0;
                        if (qty > 0) {
                            formattedAdditionalServices.push({
                                id: input.getAttribute('data-id'),
                                quantity: qty
                            });
                        }
                    });

                    const payload = {
                        first_name: document.getElementById('first_name')?.value,
                        last_name: document.getElementById('last_name')?.value,
                        birthday: formatDate(document.getElementById('birthday')?.value),
                        email: document.getElementById('email')?.value,
                        phone: document.getElementById('phone')?.value,
                        notes: document.getElementById('notes')?.value,

                        pickup_date: formatDate(document.querySelector('input[name="pickupDate"]')?.value),
                        dropoff_date: formatDate(document.querySelector('input[name="dropoffDate"]')?.value),
                        pickup_time: document.querySelector('input[name="pickupTime"]')?.value,
                        dropoff_time: document.querySelector('input[name="dropoffTime"]')?.value,

                        vehicle_id: document.getElementById('modal_vehicle_id')?.value,
                        insurance_id: document.querySelector('input[name="insurance"]:checked')?.value,

                        additional_services: formattedAdditionalServices,

                        payment_gateway: document.querySelector('input[name="payment_gateway"]:checked')?.value,

                        pickup_location: document.querySelector('select[name="pickupLocation"]')?.value || document.querySelector('input[name="pickupLocation"]')?.value || 1,
                        dropoff_location: document.querySelector('select[name="dropoffLocation"]')?.value || document.querySelector('input[name="dropoffLocation"]')?.value || 1,

                        booking_status_id: 1
                    };


                    fetch('{{ route('api.bookings.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify(payload)
                    })
                        .then(async response => {
                            const data = await response.json();
                            if (!response.ok) {
                                console.error("Detajet e Gabimit nga Laravel:", data);

                                let errorMsg = 'An error occurred during booking.';
                                if (data.errors) {
                                    errorMsg = Object.values(data.errors).flat().join('\n');
                                } else if (data.error) {
                                    errorMsg = data.error;
                                } else if (data.message) {
                                    errorMsg = data.message;
                                }
                                throw new Error(errorMsg);
                            }
                            return data;
                        })
                        .then(data => {
                            if (data.success && data.checkout_url) {
                                window.location.href = data.checkout_url;
                            } else {
                                throw new Error("Stripe checkout session was not returned.");
                            }
                        })
                        .catch(error => {
                            console.error('Booking Error:', error);
                            alert('Could not complete booking:\n' + error.message);
                            btnNext.innerHTML = originalBtnHtml;
                            btnNext.disabled = false;
                        });
                }
            }


            if (e.target.id === 'modal-overlay' || e.target.closest('#close-modal')) {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        });
    });
</script>

<script>

    function changeImage(element) {
        const mainImage = document.getElementById('mainImage');
        const newSrc = element.src;

        document.querySelectorAll('.thumbnail-img').forEach(img => {
            img.classList.remove('border-orange-500');
            img.classList.add('border-gray-100');
        });
        element.classList.remove('border-gray-100');
        element.classList.add('border-orange-500');

        mainImage.style.opacity = '0.3';
        setTimeout(() => {
            mainImage.src = newSrc;
            mainImage.style.opacity = '1';
        }, 100);
    }

    function openModal(src) {
        const modal = document.getElementById('imageModal');
        const fullImg = document.getElementById('fullImage');

        fullImg.src = src;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    window.onclick = function(event) {
        const modal = document.getElementById('imageModal');
        if (event.target == modal) {
            closeModal();
        }
    }
</script>

<script>
    function updateServiceQty(button, change) {
        const input = button.parentElement.querySelector('.service-qty-input');
        let currentQty = parseInt(input.value) || 0;

        let newQty = currentQty + change;
        if (newQty < 0) newQty = 0;
        if (newQty > 10) newQty = 10;

        input.value = newQty;

        calculateTotal();
    }

    function calculateTotal() {
        const daysElement = document.getElementById('calc-total-days');
        const rentElement = document.getElementById('calc-base-rent');

        if (!daysElement || !rentElement) return;

        const totalDays = parseInt(daysElement.value) || 1;
        const baseRentCost = parseFloat(rentElement.value) || 0;

        let totalInsuranceCost = 0;
        let totalServicesCost = 0;
        let totalDeliveryFee = 0;


        const selectedInsurance = document.querySelector('input[name="insurance"]:checked');
        if (selectedInsurance) {
            const insurancePricePerDay = parseFloat(selectedInsurance.dataset.price) || 0;
            totalInsuranceCost = insurancePricePerDay * totalDays;
        }


        const serviceInputs = document.querySelectorAll('.service-qty-input');
        serviceInputs.forEach(input => {
            const qty = parseInt(input.value) || 0;
            const price = parseFloat(input.dataset.price) || 0;
            totalServicesCost += (qty * price);
        });


        const pickupSelect = document.querySelector('select[name="pickupLocation"]');
        const dropoffSelect = document.querySelector('select[name="dropoffLocation"]');

        if (pickupSelect && pickupSelect.options[pickupSelect.selectedIndex]) {
            totalDeliveryFee += parseFloat(pickupSelect.options[pickupSelect.selectedIndex].getAttribute('data-price')) || 0;
        }

        if (dropoffSelect && dropoffSelect.options[dropoffSelect.selectedIndex]) {
            totalDeliveryFee += parseFloat(dropoffSelect.options[dropoffSelect.selectedIndex].getAttribute('data-price')) || 0;
        }


        const insuranceUI = document.getElementById('summary-insurance');
        const servicesUI = document.getElementById('summary-services');
        const deliveryUI = document.getElementById('summary-delivery'); // Kjo lidhet me HTML-në e re
        const totalUI = document.getElementById('summary-total');

        if (insuranceUI) insuranceUI.innerText = totalInsuranceCost > 0 ? '€' + totalInsuranceCost.toFixed(2) : 'Included';
        if (servicesUI) servicesUI.innerText = totalServicesCost > 0 ? '€' + totalServicesCost.toFixed(2) : '€0.00';
        if (deliveryUI) deliveryUI.innerText = totalDeliveryFee > 0 ? '€' + totalDeliveryFee.toFixed(2) : 'Free';


        const grandTotal = baseRentCost + totalInsuranceCost + totalServicesCost + totalDeliveryFee;
        if (totalUI) totalUI.innerText = '€' + grandTotal.toFixed(2);
    }
    document.addEventListener("DOMContentLoaded", function() {

        calculateTotal();
    });
</script>

<script>

    function updateModalBookingDetails() {

        const formatTimeAMPM = (timeStr) => {
            if (!timeStr) return '';
            let [hours, minutes] = timeStr.split(':');
            hours = parseInt(hours);
            const ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12;
            return `${hours}:${minutes} ${ampm}`;
        };

        const formatBeautifulDate = (dateStr) => {
            if (!dateStr) return '';
            const date = new Date(dateStr);
            if (isNaN(date)) return dateStr;
            return date.toLocaleDateString('en-US', { month: 'long', day: 'numeric' });
        };

        const pDateVal = document.querySelector('input[name="pickupDate"]')?.value || '';
        const pTimeVal = document.querySelector('input[name="pickupTime"]')?.value || '';
        const dDateVal = document.querySelector('input[name="dropoffDate"]')?.value || '';
        const dTimeVal = document.querySelector('input[name="dropoffTime"]')?.value || '';

        const pDateDisplay = document.getElementById('display-pickup-datetime');
        const dDateDisplay = document.getElementById('display-dropoff-datetime');


        if (pDateDisplay) {
            pDateDisplay.innerText = `${formatBeautifulDate(pDateVal)}, ${formatTimeAMPM(pTimeVal)}`;
        }

        if (dDateDisplay) {
            dDateDisplay.innerText = `${formatBeautifulDate(dDateVal)}, ${formatTimeAMPM(dTimeVal)}`;
        }


        const pSelect = document.querySelector('select[name="pickupLocation"]');
        const dSelect = document.querySelector('select[name="dropoffLocation"]');
        const pLocText = (pSelect && pSelect.selectedIndex !== -1) ? pSelect.options[pSelect.selectedIndex].text : 'Tirana Airport (TIA)';
        const dLocText = (dSelect && dSelect.selectedIndex !== -1) ? dSelect.options[dSelect.selectedIndex].text : 'Tirana Airport (TIA)';

        document.getElementById('display-pickup-loc').innerText = pLocText;
        document.getElementById('display-dropoff-loc').innerText = dLocText;
    }
</script>

</body>
<!--end::Body-->
</html>--}}
        <!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RentalBania - Car Rental Albania</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" type="image/png" href="{{ asset('logo_rent.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    @vite('resources/js/app.js')

    <style>
        body { font-family: 'Montserrat', sans-serif; }
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), url("{{asset('peterfazekas.jpg')}}");
            background-size: cover;
            background-position: center;
            height: 550px;
        }
        @media (max-width: 768px) {
            .hero-section {
                height: 450px;
            }
        }
        .search-box {
            margin-top: -60px;
        }
        .nav-link-active {
            border-bottom: 3px solid #f97316;
        }
    </style>

    <style>

        .flatpickr-calendar {
            border: none !important;
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1) !important;
            border-radius: 1.5rem !important;
            padding: 5px !important;
            font-family: 'Montserrat', sans-serif !important;
        }
        .flatpickr-innerContainer {
            overflow: hidden !important;
        }


        .flatpickr-day.selected,
        .flatpickr-day.startRange,
        .flatpickr-day.endRange,
        .flatpickr-day.selected.inRange,
        .flatpickr-day.startRange.inRange,
        .flatpickr-day.endRange.inRange,
        .flatpickr-day.selected:focus,
        .flatpickr-day.startRange:focus,
        .flatpickr-day.endRange:focus,
        .flatpickr-day.selected:hover,
        .flatpickr-day.startRange:hover,
        .flatpickr-day.endRange:hover,
        .flatpickr-day.selected.prevMonthDay,
        .flatpickr-day.startRange.prevMonthDay,
        .flatpickr-day.endRange.prevMonthDay,
        .flatpickr-day.selected.nextMonthDay,
        .flatpickr-day.startRange.nextMonthDay,
        .flatpickr-day.endRange.nextMonthDay {
            background: #ea580c !important; /* bg-orange-600 */
            border-color: #ea580c !important;
            color: #fff !important;
            font-weight: bold !important;
        }

        /* Stili per daten e sotme (rrethi portokalli kur nuk eshte klikuar) */
        .flatpickr-day.today {
            border-color: #ea580c !important;
        }

        /* Hover mbi daten e sotme */
        .flatpickr-day.today:hover,
        .flatpickr-day.today:focus {
            border-color: #ea580c !important;
            background: #ea580c !important;
            color: #fff !important;
        }

        /* Hover mbi datat e tjera te lira (sfond i lehte portokalli) */
        .flatpickr-day:hover,
        .flatpickr-day.prevMonthDay:hover,
        .flatpickr-day.nextMonthDay:hover,
        .flatpickr-day:focus,
        .flatpickr-day.prevMonthDay:focus,
        .flatpickr-day.nextMonthDay:focus {
            background: #ffedd5 !important; /* bg-orange-50 */
            border-color: #ffedd5 !important;
            color: #ea580c !important;
            font-weight: bold !important;
        }

        /* Stilizimi i pjeses se muajit lart */
        .flatpickr-months .flatpickr-month {
            background: transparent !important;
            color: #1f2937 !important; /* text-gray-800 */
            fill: #1f2937 !important;
        }

        /* Font i theksuar per emrin e muajit */
        .flatpickr-current-month .flatpickr-monthDropdown-months {
            font-weight: 900 !important; /* font-black */
            appearance: none; /* Heq shigjeten default te select */
        }

        /* Shigjetat para/mbrapa portokalli kur u ben hover */
        .flatpickr-months .flatpickr-prev-month:hover svg,
        .flatpickr-months .flatpickr-next-month:hover svg {
            fill: #ea580c !important;
        }

        /* Stilizimi i diteve te javes (Hën, Mar, etj.) */
        .flatpickr-weekdays {
            background: transparent !important;
        }
        span.flatpickr-weekday {
            color: #9ca3af !important; /* text-gray-400 */
            font-weight: 800 !important;
            font-size: 11px !important;
            text-transform: uppercase !important;
        }

        /* Bllokimi vizual i datave te zena (gri e zbehte me vize) */
        .flatpickr-day.flatpickr-disabled,
        .flatpickr-day.flatpickr-disabled:hover {
            color: #d1d5db !important; /* text-gray-300 */
            background: transparent !important;
            text-decoration: line-through;
        }
    </style>
</head>

<body class="bg-gray-50">

<nav class="absolute top-0 left-0 right-0 z-50 flex items-center justify-center md:justify-between px-4 md:px-12 py-3 md:py-5 text-white bg-transparent">

    <a href="/" class="flex items-center">
        <img src="{{ asset('logo_rent.png') }}" alt="RENTALBANIA Logo" class="h-16 md:h-24 w-auto object-contain drop-shadow-md">
    </a>

    <div class="hidden md:flex items-center gap-8 text-xs font-bold uppercase tracking-widest">
        <a href="#" class="hover:text-orange-500 transition">ABOUT US</a>
        <a href="#" class="hover:text-orange-500 transition">FAQs</a>
        <a href="#" class="hover:text-orange-500 transition">CONTACT</a>
        <a href="#" class="bg-orange-600 px-6 py-2 rounded text-white hover:bg-orange-700 shadow-lg transition">BEGIN NOW</a>
    </div>
</nav>

<div class="hero-section flex flex-col items-center justify-center text-center text-white px-4">
    <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold mb-3 md:mb-4 drop-shadow-md uppercase tracking-tight leading-tight mt-10 md:mt-0">
        DISCOVER ALBANIA WITH FREEDOM:<br>BOOK YOUR CAR TODAY!
    </h1>
    <p class="text-sm md:text-lg font-medium opacity-90 drop-shadow-sm px-2">Reliable Car Rental, Transparent Prices & Quick Booking</p>
</div>


<div class="max-w-7xl mx-auto px-4 search-box relative z-10">
    <div class="bg-white rounded-xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] p-5 sm:p-8">

        <form action="{{ route('search.cars') }}" method="GET" id="searchForm">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-2 items-end">

                <div class="lg:col-span-1">
                    <label class="flex items-center text-[10px] font-bold text-gray-400 uppercase mb-2">
                        <i class="fas fa-car text-gray-500 mr-2"></i> Category
                    </label>
                    <select name="vehicleCategories" class="w-full border border-gray-100 rounded-md p-3 text-sm font-medium bg-gray-50 focus:ring-2 focus:ring-orange-500 outline-none">
                        <option value="">All Categories</option>
                        @if(isset($categories))
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->title_en }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="lg:col-span-1">
                    <label class="flex items-center text-[10px] font-bold text-gray-400 uppercase mb-2">
                        <i class="fas fa-map-marker-alt text-gray-500 mr-2"></i> Pick-up Location
                    </label>
                    <select name="pickupLocation" class="w-full border border-gray-100 rounded-md p-3 text-sm font-medium bg-gray-50 focus:ring-2 focus:ring-orange-500 outline-none">
                        <option value="">Select Location</option>
                        @if(isset($deliveries))
                            @foreach($deliveries->where('company_id', 1) as $delivery)
                                @php
                                    $cityName = $delivery->city_id == 1 ? 'Tirana' : ($delivery->city_id == 11 ? 'Saranda' : 'City '.$delivery->city_id);
                                    $placeName = $delivery->place;

                                    $displayName = $cityName . ' - ' . $placeName;
                                @endphp
                                <option value="{{ $delivery->id }}" data-price="{{ $delivery->price }}">
                                    {{ $displayName }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="lg:col-span-1">
                    <label class="flex items-center text-[10px] font-bold text-gray-400 uppercase mb-2">
                        <i class="fas fa-map-pin text-gray-500 mr-2"></i> Drop-off Location
                    </label>
                    <select name="dropoffLocation" class="w-full border border-gray-100 rounded-md p-3 text-sm font-medium bg-gray-50 focus:ring-2 focus:ring-orange-500 outline-none">
                        <option value="">Select Location</option>
                        @if(isset($deliveries))
                            @foreach($deliveries->where('company_id', 1) as $delivery)
                                @php
                                    $cityName = $delivery->city_id == 1 ? 'Tirana' : ($delivery->city_id == 11 ? 'Saranda' : 'City '.$delivery->city_id);
                                    $placeName = $delivery->place;

                                    $displayName = $cityName . ' - ' . $placeName;
                                @endphp
                                <option value="{{ $delivery->id }}" data-price="{{ $delivery->price }}">
                                    {{ $displayName }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="lg:col-span-1">
                    <label class="flex items-center text-[10px] font-bold text-gray-400 uppercase mb-2">
                        <i class="fas fa-calendar-alt text-gray-500 mr-2"></i> Pick-up Date
                    </label>
                    <div class="flex border border-gray-100 rounded-md bg-gray-50 focus-within:ring-2 focus-within:ring-orange-500">
                        <input type="date" name="pickupDate" required class="w-[55%] px-1 py-2 text-[11px] font-medium bg-transparent outline-none border-r border-gray-200">
                        <input type="time" name="pickupTime" value="10:00" class="w-[47%] px-1 py-2 text-[11px] font-medium bg-transparent outline-none">
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <label class="flex items-center text-[10px] font-bold text-gray-400 uppercase mb-2">
                        <i class="fas fa-calendar-check text-gray-500 mr-2"></i> Drop-off Date
                    </label>
                    <div class="flex border border-gray-100 rounded-md bg-gray-50 focus-within:ring-2 focus-within:ring-orange-500">
                        <input type="date" name="dropoffDate" required class="w-[55%] px-1 py-2 text-[11px] font-medium bg-transparent outline-none border-r border-gray-200">
                        <input type="time" name="dropoffTime" value="10:00" class="w-[47%] px-1 py-2 text-[11px] font-medium bg-transparent outline-none">
                    </div>
                </div>

                <div class="lg:col-span-1 flex flex-col justify-end relative mt-6 lg:mt-0">
                    <div id="duration-display" class="absolute -top-6 left-0 right-0 text-center text-[10px] font-extrabold text-orange-600 uppercase tracking-widest opacity-0 transition-opacity duration-300 bg-orange-50 py-1 rounded-t-md border border-orange-100 border-b-0">
                        <i class="fas fa-clock mr-1"></i> <span id="days-count">0</span> Days
                    </div>

                    <button type="submit" class="w-full h-[46px] bg-orange-600 text-white font-black rounded-lg hover:bg-orange-700 transition uppercase tracking-tighter text-sm shadow-md flex items-center justify-center relative z-10">
                        SEARCH
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 py-12 md:py-20">
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 md:mb-12">
        <div class="text-center md:text-left mb-4 md:mb-0">
            <h2 class="text-2xl md:text-3xl font-black text-gray-800 uppercase tracking-tight">SELECT YOUR IDEAL CAR</h2>
            <p class="text-[11px] font-bold text-orange-600 uppercase tracking-widest mt-2">
                <i class="fas fa-th-list mr-1"></i>
                Total:<span id="total-cars-count">{{ $vehicles->total() }}</span> Vehicles Available
            </p>
        </div>
    </div>

    <div id="vehicles-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 transition-all duration-500">
        @include('partials.vehicle_list', ['vehicles' => $vehicles])
    </div>

    <div id="load-more-container" class="mt-12 md:mt-16 text-center {{ $vehicles->hasMorePages() ? '' : 'hidden' }}">
        <button id="btn-load-more"
                data-url="{{ $vehicles->nextPageUrl() }}"
                class="w-full sm:w-auto px-8 md:px-10 py-4 border-2 border-orange-600 text-orange-600 font-black rounded-xl hover:bg-orange-600 hover:text-white transition-all uppercase text-xs tracking-widest shadow-sm">
            Show More Vehicles <i class="fas fa-chevron-down ml-2"></i>
        </button>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 pb-16 md:pb-24">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4">
        @foreach(['All-Inclusive Prices' => 'No Hidden Fees', '24/7 Support' => 'Roadside Assistance', 'Free Cancellation' => 'Up to 48h before', 'No Deposit (optional)' => 'No Deposit'] as $title => $desc)
            <div class="bg-white p-4 md:p-6 rounded-xl border border-gray-50 shadow-sm text-center flex flex-col items-center group hover:shadow-md transition">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-orange-50 rounded-lg flex items-center justify-center text-orange-600 mb-3 md:mb-4 group-hover:bg-orange-600 group-hover:text-white transition">
                    <i class="fas fa-shield-alt text-lg md:text-xl"></i>
                </div>
                <h4 class="font-black text-[10px] md:text-[11px] text-gray-800 uppercase mb-1">{{ $title }}</h4>
                <p class="text-[9px] md:text-[10px] text-gray-400 font-medium">{{ $desc }}</p>
            </div>
        @endforeach
    </div>
</div>

@include('partials.booking_modal')

<footer class="bg-white border-t border-gray-100 py-10 md:py-16">
    <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-8 md:gap-12">
        <div class="col-span-1 text-center md:text-left">
            <div class="flex items-center justify-center md:justify-start gap-2 mb-4 md:mb-6">
                <i class="fas fa-car-side text-orange-600"></i>
                <span class="font-black text-gray-800 tracking-tighter">RENTALBANIA</span>
            </div>
            <p class="text-[11px] text-gray-400 leading-relaxed font-medium px-4 md:px-0">
                The best car rental service in Albania. Providing tourists with safe and modern vehicles to explore our beautiful country.
            </p>
        </div>
    </div>
    <div class="text-center text-[9px] md:text-[10px] font-bold text-gray-300 mt-10 md:mt-16 tracking-widest uppercase px-4">
        © {{ date('Y') }} RENTALBANIA. ALL RIGHTS RESERVED.
    </div>
</footer>


<div id="cookie-consent-banner" class="fixed bottom-0 left-0 z-50 w-full bg-[#2d3748] text-white p-4 sm:p-6 shadow-2xl transition-transform duration-500 translate-y-full flex flex-col sm:flex-row items-center justify-between gap-4">
    <div class="text-sm text-gray-300 max-w-4xl">
        Our website uses cookies so we can improve user experience and to determine where visitors come from. By continuing to use our site, you agree to our use of cookies and with the
        <a href="{{ route('privacy.policy') }}" class="text-[#20c997] hover:text-[#1aa179] underline font-semibold transition-colors">privacy policy</a>.
    </div>
    <button id="btn-accept-cookies" class="whitespace-nowrap bg-[#20c997] hover:bg-[#1aa179] text-white font-bold py-2.5 px-6 rounded-md transition-colors shadow-md">
        Yes, I agree
    </button>
</div>

<script>

    window.updateInsuranceUI = function(selectedRadio) {
        document.querySelectorAll('.insurance-label').forEach(label => {
            label.classList.remove('border-orange-500', 'bg-orange-50/30');
            label.classList.add('border-gray-100');
        });
        const parentLabel = selectedRadio.closest('label');
        parentLabel.classList.remove('border-gray-100');
        parentLabel.classList.add('border-orange-500', 'bg-orange-50/30');
    };

    document.addEventListener('DOMContentLoaded', function() {

        const searchForm = document.getElementById('searchForm');
        const container = document.getElementById('vehicles-container');
        const btnLoadMore = document.getElementById('btn-load-more');
        const loadMoreContainer = document.getElementById('load-more-container');
        const activeCount = document.getElementById('active-cars-count');
        const totalCount = document.getElementById('total-cars-count');

        const pickupDateInput = document.querySelector('input[name="pickupDate"]');
        const pickupTimeInput = document.querySelector('input[name="pickupTime"]');
        const dropoffDateInput = document.querySelector('input[name="dropoffDate"]');
        const dropoffTimeInput = document.querySelector('input[name="dropoffTime"]');
        const durationDisplay = document.getElementById('duration-display');
        const daysCountSpan = document.getElementById('days-count');

        const modal = document.getElementById('booking-modal');
        const leftContent = document.getElementById('modal-left-content');
        const rightContent = document.getElementById('modal-right-content');

        function showTab(type) {
            const tabCar = document.getElementById('tab-car-content');
            const tabBooking = document.getElementById('tab-booking-content');
            const btnCar = document.getElementById('step-car-btn');
            const btnBooking = document.getElementById('step-booking-btn');
            const mainBtn = document.getElementById('modal-main-btn');

            if (!tabCar || !tabBooking || !mainBtn) return;

            if (type === 'car') {
                tabCar.classList.remove('hidden');
                tabBooking.classList.add('hidden');

                if(btnCar) {
                    btnCar.querySelector('span').className = "w-6 h-6 rounded-full bg-orange-600 text-white flex items-center justify-center text-[9px]";
                    btnCar.className = "flex items-center gap-2 text-orange-600 transition hover:opacity-80 whitespace-nowrap";
                }
                if(btnBooking) {
                    btnBooking.querySelector('span').className = "w-6 h-6 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center text-[9px]";
                    btnBooking.className = "flex items-center gap-2 text-gray-400 transition hover:text-orange-600 whitespace-nowrap";
                }

                mainBtn.innerHTML = '<span>Continue</span> <i class="fas fa-arrow-right text-[10px]"></i>';
                mainBtn.className = "w-full bg-orange-600 text-white font-black py-4 sm:py-5 rounded-[1.5rem] hover:bg-orange-700 transition shadow-lg shadow-orange-100 uppercase text-xs tracking-widest flex items-center justify-center gap-2";
            } else {
                tabCar.classList.add('hidden');
                tabBooking.classList.remove('hidden');

                if(btnBooking) {
                    btnBooking.querySelector('span').className = "w-6 h-6 rounded-full bg-orange-600 text-white flex items-center justify-center text-[9px]";
                    btnBooking.className = "flex items-center gap-2 text-orange-600 transition hover:opacity-80 whitespace-nowrap";
                }
                if(btnCar) {
                    btnCar.querySelector('span').className = "w-6 h-6 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center text-[9px]";
                    btnCar.className = "flex items-center gap-2 text-gray-400 transition hover:text-orange-600 whitespace-nowrap";
                }

                mainBtn.innerHTML = '<span>Confirm Reservation</span> <i class="fas fa-check text-[10px]"></i>';
                mainBtn.className = "w-full bg-green-600 text-white font-black py-4 sm:py-5 rounded-[1.5rem] hover:bg-green-700 transition shadow-lg shadow-green-100 uppercase text-xs tracking-widest flex items-center justify-center gap-2";
            }
            leftContent.scrollTop = 0;
        }

        function calculateDays() {
            if (pickupDateInput && pickupDateInput.value && dropoffDateInput.value) {
                const start = new Date(`${pickupDateInput.value}T${pickupTimeInput.value}`);
                const end = new Date(`${dropoffDateInput.value}T${dropoffTimeInput.value}`);
                const diffTime = end - start;

                if (diffTime >= 0) {
                    const diffMinutes = Math.floor(diffTime / (1000 * 60));
                    let diffDays = Math.floor(diffMinutes / (24 * 60));
                    if ((diffMinutes % (24 * 60)) >= 15) diffDays++;

                    const totalDays = diffDays + 1;
                    if(daysCountSpan) daysCountSpan.textContent = totalDays;
                    if (durationDisplay) durationDisplay.classList.replace('opacity-0', 'opacity-100');
                } else {
                    if (durationDisplay) durationDisplay.classList.replace('opacity-100', 'opacity-0');
                }
            }
        }
        [pickupDateInput, pickupTimeInput, dropoffDateInput, dropoffTimeInput].forEach(i => {
            if(i) i.addEventListener('change', calculateDays);
        });


        if (searchForm) {
            searchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const params = new URLSearchParams(new FormData(this));
                container.style.opacity = '0.3';
                fetch(this.action + '?' + params.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(res => res.json())
                    .then(data => {
                        container.innerHTML = data.html;
                        container.style.opacity = '1';
                        if(activeCount) activeCount.textContent = data.current_count;
                        if(totalCount) totalCount.textContent = data.total;
                        if (data.has_more) { loadMoreContainer.classList.remove('hidden'); btnLoadMore.setAttribute('data-url', data.next_page); }
                        else { loadMoreContainer.classList.add('hidden'); }
                    });
            });
        }

        if (btnLoadMore) {
            btnLoadMore.addEventListener('click', function() {
                const url = this.getAttribute('data-url');
                this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> LOADING...';
                fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(res => res.json())
                    .then(data => {
                        container.insertAdjacentHTML('beforeend', data.html);
                        if(activeCount) activeCount.textContent = container.querySelectorAll('.group').length;
                        this.innerHTML = 'Show More Vehicles <i class="fas fa-chevron-down ml-2"></i>';
                        if (data.has_more) this.setAttribute('data-url', data.next_page);
                        else loadMoreContainer.classList.add('hidden');
                    });
            });
        }

        document.addEventListener('click', function(e) {


            const bookBtn = e.target.closest('.btn-book-now');
            if (bookBtn) {
                const vehicleId = bookBtn.getAttribute('data-vehicle-id');
                let days = (daysCountSpan) ? daysCountSpan.textContent.trim() : 1;
                if (days === "0" || !days) days = 1;

                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');

                leftContent.innerHTML = '<div class="flex items-center justify-center h-full text-orange-600"><i class="fas fa-spinner fa-spin fa-3x"></i></div>';
                rightContent.innerHTML = '<div class="flex items-center justify-center h-full text-orange-600"><i class="fas fa-spinner fa-spin fa-2x"></i></div>';

                let pDate = document.querySelector('input[name="pickupDate"]')?.value || '';
                let dDate = document.querySelector('input[name="dropoffDate"]')?.value || '';

                fetch(`/vehicle/${vehicleId}/booking-details?days=${days}&pickupDate=${pDate}&dropoffDate=${dDate}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                    .then(res => res.text())
                    .then(html => {
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = html;

                        const newLeftTabCar = tempDiv.querySelector('#tab-car-content');
                        const newLeftTabBooking = tempDiv.querySelector('#tab-booking-content');
                        const newRightSummary = tempDiv.querySelector('#summary-content');

                        if(newLeftTabCar && newLeftTabBooking && newRightSummary) {
                            leftContent.innerHTML = '';
                            leftContent.appendChild(newLeftTabCar);
                            leftContent.appendChild(newLeftTabBooking);
                            rightContent.innerHTML = newRightSummary.innerHTML;
                            showTab('car');
                            updateModalBookingDetails();
                            calculateTotal();

                            const bookedDatesInput = document.getElementById('vehicle-booked-dates');
                            let disabledDates = [];
                            if (bookedDatesInput && bookedDatesInput.value) {
                                disabledDates = JSON.parse(bookedDatesInput.value);
                            }

                            const pDateInput = document.querySelector('input[name="pickupDate"]');
                            const dDateInput = document.querySelector('input[name="dropoffDate"]');
                            const pTimeInput = document.querySelector('input[name="pickupTime"]');
                            const dTimeInput = document.querySelector('input[name="dropoffTime"]');

                            const modalPickupTime = document.getElementById('modal_pickup_time');
                            const modalDropoffTime = document.getElementById('modal_dropoff_time');

                            if(modalPickupTime && pTimeInput) modalPickupTime.value = pTimeInput.value;
                            if(modalDropoffTime && dTimeInput) modalDropoffTime.value = dTimeInput.value;


                            function syncDatesAndRecalculate() {
                                const mPickup = document.getElementById('modal_pickup_date').value;
                                const mDropoff = document.getElementById('modal_dropoff_date').value;

                                // 1. Logjika e Mesazheve (E Kuqe -> E Gjelbër)
                                const redMsg = document.getElementById('conflict-warning-msg');
                                const greenMsg = document.getElementById('conflict-success-msg');

                                if (mPickup && mDropoff) {
                                    if (redMsg) redMsg.classList.add('hidden');
                                    if (greenMsg) greenMsg.classList.remove('hidden');
                                }

                                // 2. Llogaritja ekskluzivisht për Modalin (Pa prekur Search Bar)
                                if (mPickup && mDropoff) {
                                    const start = new Date(`${mPickup}T${document.getElementById('modal_pickup_time').value || '10:00'}`);
                                    const end = new Date(`${mDropoff}T${document.getElementById('modal_dropoff_time').value || '10:00'}`);
                                    const diffTime = end - start;

                                    if (diffTime >= 0) {
                                        const diffMinutes = Math.floor(diffTime / (1000 * 60));
                                        let diffDays = Math.floor(diffMinutes / (24 * 60));
                                        if ((diffMinutes % (24 * 60)) >= 15) diffDays++;

                                        const totalDays = diffDays + 1;

                                        // Përditësojmë VETËM të dhënat brenda modalit
                                        const calcTotalDays = document.getElementById('calc-total-days');
                                        const modalDaysText = document.getElementById('summary-days-text');

                                        if(calcTotalDays) calcTotalDays.value = totalDays;
                                        if(modalDaysText) modalDaysText.innerText = totalDays;

                                        calculateTotal(); // Llogarisim çmimet
                                    }
                                }
                            }

                            flatpickr("#modal_pickup_date", {
                                dateFormat: "Y-m-d",
                                minDate: "today",
                                disable: disabledDates,
                                defaultDate: pDateInput ? pDateInput.value : null,
                                onChange: syncDatesAndRecalculate
                            });

                            flatpickr("#modal_dropoff_date", {
                                dateFormat: "Y-m-d",
                                minDate: "today",
                                disable: disabledDates,
                                defaultDate: dDateInput ? dDateInput.value : null,
                                onChange: syncDatesAndRecalculate
                            });

                            if(modalPickupTime) modalPickupTime.addEventListener('change', syncDatesAndRecalculate);
                            if(modalDropoffTime) modalDropoffTime.addEventListener('change', syncDatesAndRecalculate);
                        }
                    })
                    .catch(err => {
                        console.error("Error loading modal:", err);
                        leftContent.innerHTML = '<div class="text-red-500 p-10">Something went wrong</div>';
                    });
            }


            const stepCar = e.target.closest('#step-car-btn');
            const stepBooking = e.target.closest('#step-booking-btn');
            const btnNext = e.target.closest('#modal-main-btn');

            if (stepCar) showTab('car');
            if (stepBooking) showTab('booking');

            if (btnNext) {
                e.preventDefault();
                const buttonText = btnNext.textContent.trim();

                if (buttonText.includes('Continue')) {
                    showTab('booking');
                } else if (buttonText.includes('Confirm Reservation')) {

                    const originalBtnHtml = btnNext.innerHTML;
                    btnNext.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
                    btnNext.disabled = true;

                    const formatDate = (dateStr) => {
                        if (!dateStr) return null;
                        const [y, m, d] = dateStr.split('-');
                        return `${d}-${m}-${y}`;
                    };

                    const csrfToken = document.querySelector('input[name="_token"]')?.value || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');


                    const serviceInputs = document.querySelectorAll('.service-qty-input');
                    const formattedAdditionalServices = [];

                    serviceInputs.forEach(input => {
                        const qty = parseInt(input.value) || 0;
                        if (qty > 0) {
                            formattedAdditionalServices.push({
                                id: input.getAttribute('data-id'),
                                quantity: qty
                            });
                        }
                    });

                    const payload = {
                        first_name: document.getElementById('first_name')?.value,
                        last_name: document.getElementById('last_name')?.value,
                        birthday: formatDate(document.getElementById('birthday')?.value),
                        email: document.getElementById('email')?.value,
                        phone: document.getElementById('phone')?.value,
                        notes: document.getElementById('notes')?.value,

                        pickup_date: formatDate(document.getElementById('modal_pickup_date')?.value || document.querySelector('input[name="pickupDate"]')?.value),
                        dropoff_date: formatDate(document.getElementById('modal_dropoff_date')?.value || document.querySelector('input[name="dropoffDate"]')?.value),
                        pickup_time: document.getElementById('modal_pickup_time')?.value || document.querySelector('input[name="pickupTime"]')?.value,
                        dropoff_time: document.getElementById('modal_dropoff_time')?.value || document.querySelector('input[name="dropoffTime"]')?.value,

                        vehicle_id: document.getElementById('modal_vehicle_id')?.value,
                        insurance_id: document.querySelector('input[name="insurance"]:checked')?.value,

                        additional_services: formattedAdditionalServices,

                        payment_gateway: document.querySelector('input[name="payment_gateway"]:checked')?.value,

                        pickup_location: document.querySelector('select[name="pickupLocation"]')?.value || document.querySelector('input[name="pickupLocation"]')?.value || 1,
                        dropoff_location: document.querySelector('select[name="dropoffLocation"]')?.value || document.querySelector('input[name="dropoffLocation"]')?.value || 1,

                        booking_status_id: 1
                    };


                    fetch('{{ route('api.bookings.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify(payload)
                    })
                        .then(async response => {
                            const data = await response.json();
                            if (!response.ok) {
                                console.error("Errors Details by Laravel:", data);

                                let errorMsg = 'An error occurred during booking.';
                                if (data.errors) {
                                    errorMsg = Object.values(data.errors).flat().join('\n');
                                } else if (data.error) {
                                    errorMsg = data.error;
                                } else if (data.message) {
                                    errorMsg = data.message;
                                }
                                throw new Error(errorMsg);
                            }
                            return data;
                        })
                        .then(data => {
                            if (data.success && data.checkout_url) {
                                window.location.href = data.checkout_url;
                            } else {
                                throw new Error("Stripe checkout session was not returned.");
                            }
                        })
                        .catch(error => {
                            console.error('Booking Error:', error);
                            alert('Could not complete booking:\n' + error.message);
                            btnNext.innerHTML = originalBtnHtml;
                            btnNext.disabled = false;
                        });
                }
            }


            if (e.target.id === 'modal-overlay' || e.target.closest('#close-modal')) {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        });
    });
</script>

<script>

    function changeImage(element) {
        const mainImage = document.getElementById('mainImage');
        const newSrc = element.src;

        document.querySelectorAll('.thumbnail-img').forEach(img => {
            img.classList.remove('border-orange-500');
            img.classList.add('border-gray-100');
        });
        element.classList.remove('border-gray-100');
        element.classList.add('border-orange-500');

        mainImage.style.opacity = '0.3';
        setTimeout(() => {
            mainImage.src = newSrc;
            mainImage.style.opacity = '1';
        }, 100);
    }

    function openModal(src) {
        const modal = document.getElementById('imageModal');
        const fullImg = document.getElementById('fullImage');

        fullImg.src = src;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    window.onclick = function(event) {
        const modal = document.getElementById('imageModal');
        if (event.target == modal) {
            closeModal();
        }
    }
</script>

<script>
    function updateServiceQty(button, change) {
        const input = button.parentElement.querySelector('.service-qty-input');
        let currentQty = parseInt(input.value) || 0;

        let newQty = currentQty + change;
        if (newQty < 0) newQty = 0;
        if (newQty > 10) newQty = 10;

        input.value = newQty;

        calculateTotal();
    }

    function calculateTotal() {

        const daysElement = document.getElementById('calc-total-days');
        const dailyRateElement = document.getElementById('calc-daily-rate');

        if (!daysElement || !dailyRateElement) return;

        const totalDays = parseInt(daysElement.value) || 1;
        const baseDailyRate = parseFloat(dailyRateElement.value) || 0;

        let totalBaseRentBeforeTariff = 0;
        let seasonalPrices = [];
        const seasonsInput = document.getElementById('calc-seasonal-prices');

        if (seasonsInput && seasonsInput.value) {
            try { seasonalPrices = JSON.parse(seasonsInput.value); } catch(e) {}
        }

        const modalPickupInput = document.getElementById('modal_pickup_date');
        const pickupInput = (modalPickupInput && modalPickupInput.value) ? modalPickupInput : document.querySelector('input[name="pickupDate"]');
        let currentDate = pickupInput && pickupInput.value ? new Date(pickupInput.value) : new Date();
        currentDate.setHours(12, 0, 0, 0);

        for (let i = 0; i < totalDays; i++) {
            let dailyMultiplier = 1.0;

            for (const season of seasonalPrices) {
                const sStart = new Date(season.start_date);
                const sEnd = new Date(season.end_date);
                sStart.setHours(0, 0, 0, 0);
                sEnd.setHours(23, 59, 59, 999);

                if (currentDate >= sStart && currentDate <= sEnd) {
                    dailyMultiplier *= parseFloat(season.rate_multiplier);
                }
            }

            totalBaseRentBeforeTariff += (baseDailyRate * dailyMultiplier);
            currentDate.setDate(currentDate.getDate() + 1);
        }

        let tariffMultiplier = 1.0;
        const tariffsInput = document.getElementById('calc-tariffs');

        if (tariffsInput && tariffsInput.value) {
            try {
                const tariffs = JSON.parse(tariffsInput.value);
                const activeTariff = tariffs.find(t => {
                    const meetsMinDays = totalDays >= t.min_days;
                    const meetsMaxDays = t.max_days === null || totalDays <= t.max_days;
                    return meetsMinDays && meetsMaxDays;
                });

                if (activeTariff && activeTariff.rate_multiplier !== undefined) {
                    let parsedMultiplier = parseFloat(activeTariff.rate_multiplier);
                    tariffMultiplier = parsedMultiplier > 0 ? parsedMultiplier : 1.0;
                }
            } catch (e) {}
        }

        const baseRentCost = totalBaseRentBeforeTariff * tariffMultiplier;

        let totalInsuranceCost = 0;
        let totalServicesCost = 0;
        let totalDeliveryFee = 0;
        let depositAmount = 0;

        const selectedInsurance = document.querySelector('input[name="insurance"]:checked');
        if (selectedInsurance) {
            const insurancePricePerDay = parseFloat(selectedInsurance.dataset.price) || 0;
            totalInsuranceCost = insurancePricePerDay * totalDays;
            depositAmount = parseFloat(selectedInsurance.dataset.deposit) || 0;
        }

        const serviceInputs = document.querySelectorAll('.service-qty-input');
        serviceInputs.forEach(input => {
            const qty = parseInt(input.value) || 0;
            const price = parseFloat(input.dataset.price) || 0;
            totalServicesCost += (qty * price);
        });

        const pickupSelect = document.querySelector('select[name="pickupLocation"]');
        const dropoffSelect = document.querySelector('select[name="dropoffLocation"]');

        if (pickupSelect && pickupSelect.options[pickupSelect.selectedIndex]) {
            totalDeliveryFee += parseFloat(pickupSelect.options[pickupSelect.selectedIndex].getAttribute('data-price')) || 0;
        }
        if (dropoffSelect && dropoffSelect.options[dropoffSelect.selectedIndex]) {
            totalDeliveryFee += parseFloat(dropoffSelect.options[dropoffSelect.selectedIndex].getAttribute('data-price')) || 0;
        }

        const baseRentUI = document.getElementById('summary-base-rent');
        const insuranceUI = document.getElementById('summary-insurance');
        const servicesUI = document.getElementById('summary-services');
        const deliveryUI = document.getElementById('summary-delivery');
        const totalUI = document.getElementById('summary-total');

        const payNowUI = document.getElementById('summary-pay-now');
        const payLaterUI = document.getElementById('summary-pay-later');
        const depositUI = document.getElementById('summary-deposit');
        const daysTextUI = document.getElementById('summary-days-text');

        const discountWrapper = document.getElementById('discount-wrapper');
        const discountPercent = document.getElementById('discount-percent');
        const originalTotalPrice = document.getElementById('original-total-price');

        if (tariffMultiplier < 1.0) {
            const discountVal = Math.round((1 - tariffMultiplier) * 100);
            if (discountWrapper) {
                discountWrapper.classList.remove('hidden');
                discountWrapper.classList.add('flex');
            }
            if (discountPercent) discountPercent.innerText = `-${discountVal}% LONG-TERM`;

            if (originalTotalPrice) originalTotalPrice.innerText = '€' + totalBaseRentBeforeTariff.toFixed(2);
        } else {

            if (discountWrapper) {
                discountWrapper.classList.add('hidden');
                discountWrapper.classList.remove('flex');
            }
        }

        if (daysTextUI) daysTextUI.innerText = totalDays;
        if (baseRentUI) baseRentUI.innerText = '€' + baseRentCost.toFixed(2);
        if (insuranceUI) insuranceUI.innerText = totalInsuranceCost > 0 ? '€' + totalInsuranceCost.toFixed(2) : 'Included';
        if (servicesUI) servicesUI.innerText = totalServicesCost > 0 ? '€' + totalServicesCost.toFixed(2) : '€0.00';
        if (deliveryUI) deliveryUI.innerText = totalDeliveryFee > 0 ? '€' + totalDeliveryFee.toFixed(2) : 'Free';


        const grandTotal = baseRentCost + totalInsuranceCost + totalServicesCost + totalDeliveryFee;
        const payNow = (baseRentCost + totalInsuranceCost + totalServicesCost) * 0.20;
        const payLater = grandTotal - payNow;


        if (totalUI) totalUI.innerText = '€' + grandTotal.toFixed(2);
        if (payNowUI) payNowUI.innerText = '€' + payNow.toFixed(2);
        if (payLaterUI) payLaterUI.innerText = '€' + payLater.toFixed(2);
        if (depositUI) depositUI.innerText = '€' + depositAmount.toFixed(2);
    }

    document.addEventListener("DOMContentLoaded", function() {

        calculateTotal();
    });
</script>

<script>

    function updateModalBookingDetails() {

        const formatTimeAMPM = (timeStr) => {
            if (!timeStr) return '';
            let [hours, minutes] = timeStr.split(':');
            hours = parseInt(hours);
            const ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12;
            return `${hours}:${minutes} ${ampm}`;
        };

        const formatBeautifulDate = (dateStr) => {
            if (!dateStr) return '';
            const date = new Date(dateStr);
            if (isNaN(date)) return dateStr;
            return date.toLocaleDateString('en-US', { month: 'long', day: 'numeric' });
        };

        const pDateVal = document.querySelector('input[name="pickupDate"]')?.value || '';
        const pTimeVal = document.querySelector('input[name="pickupTime"]')?.value || '';
        const dDateVal = document.querySelector('input[name="dropoffDate"]')?.value || '';
        const dTimeVal = document.querySelector('input[name="dropoffTime"]')?.value || '';

        const pDateDisplay = document.getElementById('display-pickup-datetime');
        const dDateDisplay = document.getElementById('display-dropoff-datetime');


        if (pDateDisplay) {
            pDateDisplay.innerText = `${formatBeautifulDate(pDateVal)}, ${formatTimeAMPM(pTimeVal)}`;
        }

        if (dDateDisplay) {
            dDateDisplay.innerText = `${formatBeautifulDate(dDateVal)}, ${formatTimeAMPM(dTimeVal)}`;
        }


        const pSelect = document.querySelector('select[name="pickupLocation"]');
        const dSelect = document.querySelector('select[name="dropoffLocation"]');
        const pLocText = (pSelect && pSelect.selectedIndex !== -1) ? pSelect.options[pSelect.selectedIndex].text : 'Tirana Airport (TIA)';
        const dLocText = (dSelect && dSelect.selectedIndex !== -1) ? dSelect.options[dSelect.selectedIndex].text : 'Tirana Airport (TIA)';

        document.getElementById('display-pickup-loc').innerText = pLocText;
        document.getElementById('display-dropoff-loc').innerText = dLocText;
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const banner = document.getElementById('cookie-consent-banner');
        const acceptBtn = document.getElementById('btn-accept-cookies');

        if (!localStorage.getItem('cookieConsentAccepted')) {
            setTimeout(() => {
                banner.classList.remove('translate-y-full');
            }, 1000);
        }
        acceptBtn.addEventListener('click', function() {
            localStorage.setItem('cookieConsentAccepted', 'true');
            banner.classList.add('translate-y-full');
        });
    });
</script>

</body>
</html>
