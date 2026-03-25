{{--
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
                <div class="flex items-center"><i class="fas fa-users mr-2 text-gray-300 text-sm"></i> {{ $vehicle->seats ?? 5 }} Seats</div>
                <div class="flex items-center"><i class="fas fa-suitcase mr-2 text-gray-300 text-sm"></i> 2 Bags</div>
                <div class="flex items-center"><i class="fas fa-door-open mr-2 text-gray-300 text-sm"></i> 4 Doors</div>
                <div class="flex items-center"><i class="fas fa-cog mr-2 text-gray-300 text-sm"></i> {{ $vehicle->transmissionType->title_en ?? 'Auto' }}</div>
                <div class="flex items-center col-span-2"><i class="fas fa-gas-pump mr-2 text-gray-300 text-sm"></i> {{ $vehicle->fuelType->title_en ?? 'N/A' }}</div>
            </div>

            <div class="flex items-center text-[10px] font-bold text-green-600 uppercase mb-6">
                <i class="fas fa-check-circle mr-2 text-sm"></i>
                Free Cancellation
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

                <button
                        type="button"
                        data-vehicle-id="{{ $vehicle->id }}"
                        class="btn-book-now block text-center w-full bg-orange-600 text-white font-black py-3 rounded-lg hover:bg-orange-700 transition-all uppercase text-xs tracking-widest shadow-md"
                >
                    BOOK NOW
                </button>
            </div>
        </div>
    </div>
@empty
    <div class="col-span-1 md:col-span-3 bg-white p-12 text-center rounded-2xl border border-gray-100 shadow-sm">
        <i class="fas fa-car-side text-4xl text-gray-300 mb-4"></i>
        <h3 class="text-xl font-bold text-gray-700">No cars found</h3>
        <p class="text-sm text-gray-400 mt-2">Agencies are currently updating their fleets. Please try adjusting your search dates or filters.</p>
    </div>
@endforelse--}}

@forelse($vehicles as $vehicle)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-xl transition-all duration-300 flex flex-col">

        <div class="relative overflow-hidden h-52 shrink-0 bg-gray-50">
            @if($vehicle->images->isNotEmpty())
                <img src="{{ asset('storage/' . $vehicle->images->first()->path) }}" alt="{{ $vehicle->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
            @else
                <img src="https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?auto=format&fit=crop&w=600&q=80" alt="Default Car" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 opacity-80">
            @endif

            {{-- Badge për marketing mbi foto --}}
            <div class="absolute top-4 left-4 flex flex-col gap-2">
                <span class="bg-orange-600 text-white text-[9px] font-black px-2 py-1 rounded-md uppercase tracking-widest shadow-sm">Best Seller</span>
            </div>

            <div class="absolute top-4 right-4 bg-white/90 p-2 rounded-full text-orange-600 cursor-pointer shadow-sm hover:bg-orange-600 hover:text-white transition">
                <i class="far fa-heart text-sm"></i>
            </div>
        </div>

        <div class="p-6 flex flex-col flex-grow">
            <div class="flex justify-between items-start mb-3">
                <div>
                    <h3 class="font-extrabold text-xl text-gray-800 uppercase leading-none">{{ $vehicle->title }}</h3>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mt-2">
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

            <div class="grid grid-cols-2 gap-y-3 gap-x-2 text-[10px] font-bold text-gray-500 mb-5 uppercase">
                <div class="flex items-center" title="Seats"><i class="fas fa-users mr-2 text-orange-500 text-sm"></i> {{ $vehicle->seats ?? 2 }} People</div>
                <div class="flex items-center" title="Luggage"><i class="fas fa-suitcase mr-2 text-orange-500 text-sm"></i> 2 Bags</div>
                <div class="flex items-center" title="Transmission"><i class="fas fa-cog mr-2 text-orange-500 text-sm"></i> {{ $vehicle->transmissionType->title_en ?? 'Auto' }}</div>
                <div class="flex items-center" title="Fuel"><i class="fas fa-gas-pump mr-2 text-orange-500 text-sm"></i> {{ $vehicle->fuelType->title_en ?? 'N/A' }}</div>
                <div class="flex items-center col-span-2" title="Multimedia"><i class="fas fa-compact-disc mr-2 text-orange-500 text-sm"></i> Bluetooth / USB / A.C</div>
            </div>

            <div class="space-y-2 mb-6">
                <div class="flex items-center text-[10px] font-bold text-green-600 uppercase">
                    <i class="fas fa-check-circle mr-2 text-sm"></i>
                    Free Airport Pickup
                </div>
                <div class="flex items-center text-[10px] font-bold text-blue-600 uppercase">
                    <i class="fas fa-shield-alt mr-2 text-sm"></i>
                    Collision Damage Waiver (CDW)
                </div>
            </div>

            <div class="mt-auto pt-4 border-t border-gray-50">
                <div class="flex justify-between items-end mb-4">
                    <div>
                        <span class="block text-[9px] text-gray-400 font-bold uppercase tracking-widest mb-1">Total Guarantee</span>
                        <span class="text-gray-400 line-through text-xs">€{{ number_format($vehicle->base_daily_rate + 15, 0) }}</span>
                    </div>
                    <div class="text-right leading-none">
                        <span class="text-orange-600 font-black text-2xl">€{{ number_format($vehicle->base_daily_rate, 0) }}</span>
                        <span class="text-[10px] text-gray-400 font-bold uppercase block mt-1">/day</span>
                    </div>
                </div>

                <button
                        type="button"
                        data-vehicle-id="{{ $vehicle->id }}"
                        class="btn-book-now block text-center w-full bg-orange-600 text-white font-black py-3 rounded-xl hover:bg-orange-700 transition-all uppercase text-xs tracking-widest shadow-lg shadow-orange-100"
                >
                    BOOK NOW
                </button>
            </div>
        </div>
    </div>
@empty

@endforelse
