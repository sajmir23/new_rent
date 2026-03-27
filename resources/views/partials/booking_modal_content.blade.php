<div id="tab-car-content" class="modal-tab">
    <div class="flex justify-between items-start mb-6 gap-4">
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-black text-gray-900 uppercase tracking-tighter">{{ $vehicle->title }}</h2>
        <button class="text-gray-300 hover:text-red-500 transition shrink-0"><i class="far fa-heart text-2xl"></i></button>
    </div>

    <div id="imageModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-90 flex items-center justify-center p-4">
        <span class="absolute top-5 right-5 md:right-10 text-white text-4xl cursor-pointer hover:text-orange-500" onclick="closeModal()">&times;</span>
        <img id="fullImage" src="" class="max-w-full max-h-full rounded-lg shadow-2xl">
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-3 mb-8">
        <div class="lg:col-span-3">
            <img id="mainImage"
                 src="{{ $vehicle->images->isNotEmpty() ? asset('storage/' . $vehicle->images->first()->path) : '' }}"
                 onclick="openModal(this.src)"
                 class="w-full h-64 sm:h-80 object-cover rounded-3xl shadow-sm transition-opacity duration-300 cursor-zoom-in">
        </div>

        <div class="hidden lg:flex flex-col gap-3">
            @foreach($vehicle->images->take(4) as $img)
                <img src="{{ asset('storage/' . $img->path) }}"
                     onclick="changeImage(this)"
                     class="thumbnail-img h-[74px] w-full object-cover rounded-xl border {{ $loop->first ? 'border-orange-500' : 'border-gray-100' }} cursor-pointer hover:border-orange-500 transition-all duration-200">
            @endforeach
        </div>
    </div>

    <div class="mb-10">
        <h3 class="text-lg font-black text-gray-800 uppercase mb-4 tracking-tight flex items-center gap-2">
            Specifications <i class="fas fa-bolt text-orange-500 text-xs"></i>
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 border-t border-gray-50 pt-4">
            <div class="flex justify-between sm:pr-6 sm:border-r border-gray-50"><span class="text-gray-400">Gear box</span> <span class="font-bold uppercase text-xs">{{ $vehicle->transmissionType->title_en }}</span></div>
            <div class="flex justify-between sm:pl-6"><span class="text-gray-400">Engine</span> <span class="font-bold uppercase text-xs">{{ $vehicle->engine_size }} L</span></div>
            <div class="flex justify-between sm:pr-6 sm:border-r border-gray-50"><span class="text-gray-400">Year</span> <span class="font-bold uppercase text-xs">{{ $vehicle->year }}</span></div>
            <div class="flex justify-between sm:pl-6"><span class="text-gray-400">Fuel</span> <span class="font-bold uppercase text-xs">{{ $vehicle->fuelType->title_en }}</span></div>
        </div>

        <div id="all-specs" class="hidden mt-4 space-y-4 pt-4 border-t border-dotted border-gray-200">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4">
                <div class="flex justify-between sm:pr-6 sm:border-r border-gray-50"><span class="text-gray-400">Seats</span> <span class="font-bold">{{ $vehicle->seats }}</span></div>
                <div class="flex justify-between sm:pl-6"><span class="text-gray-400">Drive</span> <span class="font-bold uppercase text-xs">AWD</span></div>
                <div class="flex justify-between sm:pr-6 sm:border-r border-gray-50"><span class="text-gray-400">Air Conditioning</span> <span class="font-bold">Yes</span></div>
                <div class="flex justify-between sm:pl-6"><span class="text-gray-400">Cruise Control</span> <span class="font-bold">Yes</span></div>
            </div>
        </div>
        <button onclick="document.getElementById('all-specs').classList.toggle('hidden')" class="mt-4 text-orange-600 font-bold text-[10px] uppercase tracking-widest flex items-center gap-2">
            All Specifications <i class="fas fa-chevron-down text-[8px]"></i>
        </button>
    </div>

    <div class="mb-10 bg-gray-50/50 p-4 sm:p-6 rounded-3xl border border-gray-100">
        <h3 class="text-sm font-black text-gray-400 uppercase mb-5 tracking-[0.2em]">Rental Requirements</h3>

        <div class="space-y-4">

            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1 sm:gap-0">
                <div class="flex items-center gap-3">
                    <i class="fas fa-user-check text-gray-300 text-xs"></i>
                    <span class="text-xs font-bold text-gray-500 uppercase">Driver's age</span>
                </div>
                <span class="text-sm font-black text-gray-800">{{ $vehicle->min_drive_age ?? 21 }} — {{ $vehicle->max_drive_age ?? 70 }} years</span>
            </div>

            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1 sm:gap-0">
                <div class="flex items-center gap-3">
                    <i class="fas fa-globe text-gray-300 text-xs"></i>
                    <span class="text-xs font-bold text-gray-500 uppercase">International Licence</span>
                </div>
                <span class="text-[11px] font-black uppercase tracking-wider {{ $vehicle->international_licence_required ? 'text-orange-600' : 'text-green-600' }}">
                {{ $vehicle->international_licence_required ? 'Required' : 'Not Required' }}
            </span>
            </div>

            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1 sm:gap-0">
                <div class="flex items-center gap-3">
                    <i class="fas fa-infinity text-gray-300 text-xs"></i>
                    <span class="text-xs font-bold text-gray-500 uppercase">Mileage limit</span>
                </div>
                <span class="text-xs font-black text-gray-800 uppercase tracking-tighter">Unlimited Mileage</span>
            </div>
        </div>
    </div>

    <div class="mb-10">
        <h3 class="text-lg font-black text-gray-800 uppercase mb-5 tracking-tight">Insurance Options</h3>
        <div class="grid grid-cols-1 gap-4">
            @forelse($insurances as $index => $insurance)
                <label class="relative flex flex-col sm:flex-row items-start p-4 sm:p-5 rounded-2xl border-2 {{ $loop->first ? 'border-orange-500 bg-orange-50/30' : 'border-gray-100 hover:border-orange-200' }} transition cursor-pointer insurance-label">

                    <div class="flex items-center w-full sm:w-auto mb-3 sm:mb-0">
                        <input type="radio"
                               name="insurance"
                               value="{{ $insurance->id }}"
                               {{ $loop->first ? 'checked' : '' }}
                               class="mt-1 sm:mt-0 h-5 w-5 accent-orange-600 insurance-radio shrink-0"
                               data-price="{{ $insurance->price_per_day }}"
                               data-deposit="{{ $insurance->has_deposit ? $insurance->deposit_price : 0 }}"
                               onclick="updateInsuranceUI(this)"
                               onchange="calculateTotal()">
                    </div>

                    <div class="sm:ml-4 flex-grow w-full">
                        <div class="flex flex-wrap justify-between items-center mb-1 gap-2">
                            <span class="font-bold text-gray-800 uppercase text-xs tracking-wide">{{ $insurance->title_en }}</span>
                            <span class="font-black {{ $insurance->price_per_day > 0 ? 'text-orange-600' : 'text-gray-400' }}">
                                {{ $insurance->price_per_day > 0 ? '€' . number_format($insurance->price_per_day, 2) : 'Free of charge' }}
                                @if($insurance->price_per_day > 0)
                                    <small class="text-gray-400 text-xs">/day</small>
                                @endif
                            </span>
                        </div>

                        @if($loop->first)
                            <div class="text-[10px] text-green-600 font-bold uppercase mb-2">Recommended</div>
                        @endif

                        <p class="text-[11px] text-gray-500">
                            @if($insurance->has_deposit && $insurance->deposit_price > 0)
                                Deposit: €{{ number_format($insurance->deposit_price, 0) }}.
                            @endif
                            {{ $insurance->description_en }}
                        </p>
                    </div>
                </label>
            @empty
                <div class="text-sm text-gray-500 italic p-4 bg-gray-50 rounded-xl">No insurance options available for this vehicle.</div>
            @endforelse
        </div>
    </div>

    <div class="mb-4">
        <h3 class="text-lg font-black text-gray-800 uppercase mb-5 tracking-tight">Additional Services</h3>
        <div class="space-y-3">
            @forelse($additionalServices as $service)
                <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 bg-white border border-gray-100 rounded-2xl hover:shadow-sm transition gap-3 sm:gap-0">
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-semibold text-gray-700">{{ $service->title_en ?? $service->name }}</span>
                    </div>

                    <div class="flex items-center justify-between sm:justify-end gap-4 w-full sm:w-auto">
                        <span class="text-sm font-black text-gray-900">
                            {{ $service->service_price > 0 ? '€' . number_format($service->service_price, 2) : 'Free' }}
                        </span>

                        @if($service->service_price > 0)
                            <div class="flex items-center bg-gray-50 rounded-lg border border-gray-200 p-1">
                                <button type="button" onclick="updateServiceQty(this, -1)" class="w-7 h-7 flex items-center justify-center text-gray-500 hover:text-orange-600 bg-white rounded shadow-sm focus:outline-none transition">-</button>

                                <input type="text"
                                       class="service-qty-input w-8 text-center bg-transparent border-none text-xs font-bold p-0 focus:ring-0"
                                       value="0" readonly
                                       data-price="{{ $service->service_price }}"
                                       data-id="{{ $service->id }}">

                                <button type="button" onclick="updateServiceQty(this, 1)" class="w-7 h-7 flex items-center justify-center text-gray-500 hover:text-orange-600 bg-white rounded shadow-sm focus:outline-none transition">+</button>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-[11px] text-gray-500 italic">No additional services available.</div>
            @endforelse
        </div>
    </div>
</div>

<div id="tab-booking-content" class="modal-tab hidden">
    <h2 class="text-2xl sm:text-3xl font-black text-gray-900 uppercase tracking-tighter mb-8">Booking Details</h2>

    <div id="conflict-warning-msg" class="bg-red-50 border border-red-200 p-4 mb-6 rounded-2xl flex items-start gap-3 {{ (isset($hasConflict) && $hasConflict) ? '' : 'hidden' }}">
        <i class="fas fa-exclamation-circle text-red-500 text-lg mt-0.5"></i>
        <div>
            <h4 class="text-sm font-black text-red-800 uppercase tracking-tight">This car is booked!</h4>
            <p class="text-[11px] text-red-600 font-medium mt-1">The dates you requested are not available.Please choose dates that are not crossed-out in red.</p>
        </div>
    </div>

    <div id="conflict-success-msg" class="bg-green-50 border border-green-200 p-4 mb-6 rounded-2xl flex items-start gap-3 hidden transition-all">
        <i class="fas fa-check-circle text-green-500 text-lg mt-0.5"></i>
        <div>
            <h4 class="text-sm font-black text-green-800 uppercase tracking-tight">Dates are available!</h4>
            <p class="text-[11px] text-green-600 font-medium mt-1">This car is available for the selected dates.</p>
        </div>
    </div>

    <div id="no-dropoff-warning-msg" class="bg-orange-50 border border-orange-200 p-4 mb-6 rounded-2xl flex items-start gap-3 hidden transition-all">
        <i class="fas fa-calendar-times text-orange-500 text-lg mt-0.5"></i>
        <div>
            <h4 class="text-sm font-black text-orange-800 uppercase tracking-tight">Not enough days available</h4>
            <p class="text-[11px] text-orange-600 font-medium mt-1">The car is booked immediately after this date.</p>
        </div>
    </div>

    <input type="hidden" id="vehicle-booked-dates" value="{{ json_encode($bookedDates ?? []) }}">

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-10">
        <div class="p-5 sm:p-6 bg-gray-50 rounded-3xl border border-gray-100">
            <span class="text-[10px] font-black text-orange-600 uppercase mb-2 block tracking-widest">Pick-up</span>
            <div id="display-pickup-loc" class="font-bold text-gray-800 text-sm mb-3 break-words">...</div>
            <div class="flex gap-1 sm:gap-2">
                <input type="text" id="modal_pickup_date" class="w-[55%] p-2 text-xs font-bold bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 outline-none" placeholder="Choose Date">
                <input type="time" id="modal_pickup_time" class="w-[45%] p-2 text-xs font-bold bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 outline-none">
            </div>
        </div>

        <div class="p-5 sm:p-6 bg-gray-50 rounded-3xl border border-gray-100">
            <span class="text-[10px] font-black text-orange-600 uppercase mb-2 block tracking-widest">Drop-off</span>
            <div id="display-dropoff-loc" class="font-bold text-gray-800 text-sm mb-3 break-words">...</div>
            <div class="flex gap-1 sm:gap-2">
                <input type="text" id="modal_dropoff_date" class="w-[55%] p-2 text-xs font-bold bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 outline-none" placeholder="Choose Date">
                <input type="time" id="modal_dropoff_time" class="w-[45%] p-2 text-xs font-bold bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 outline-none">
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <h3 class="text-lg font-black text-gray-800 uppercase tracking-tight mb-4">Main Driver's Details</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="text" id="first_name" placeholder="First Name *" class="p-4 bg-gray-50 border-none rounded-xl text-sm focus:ring-2 focus:ring-orange-500 w-full">
            <input type="text" id="last_name" placeholder="Last Name *" class="p-4 bg-gray-50 border-none rounded-xl text-sm focus:ring-2 focus:ring-orange-500 w-full">

            <input type="date" id="birthday" placeholder="Date of birth *" class="p-4 bg-gray-50 border-none rounded-xl text-sm focus:ring-2 focus:ring-orange-500 w-full">
            <input type="email" id="email" placeholder="Email *" class="p-4 bg-gray-50 border-none rounded-xl text-sm focus:ring-2 focus:ring-orange-500 w-full">
            <input type="tel" id="phone" placeholder="Contact phone number *" class="p-4 bg-gray-50 border-none rounded-xl text-sm focus:ring-2 focus:ring-orange-500 w-full">
        </div>

        <div class="p-4 bg-blue-50/50 rounded-2xl border border-blue-100 text-[11px] text-blue-800 leading-relaxed">
            Please specify instant messengers on this phone number. We will try to use them first to contact you.
            <div class="flex flex-wrap gap-4 mt-3">
                <label class="flex items-center gap-2"><input type="checkbox" class="accent-blue-600"> WhatsApp</label>
                <label class="flex items-center gap-2"><input type="checkbox" class="accent-blue-600"> Telegram</label>
                <label class="flex items-center gap-2"><input type="checkbox" class="accent-blue-600"> Instagram</label>
                <label class="flex items-center gap-2"><input type="checkbox" class="accent-blue-600"> Facebook</label>
            </div>
        </div>

        <input type="hidden" id="modal_vehicle_id" value="{{ $vehicle->id }}">

        <textarea id="notes" placeholder="Comment" class="w-full mt-6 p-4 bg-gray-50 border-none rounded-xl text-sm focus:ring-2 focus:ring-orange-500 h-32"></textarea>

        <div class="mt-6 flex flex-col gap-3 border-t border-gray-100 pt-5">

            <label class="flex items-center gap-3 cursor-pointer group">
                <input type="checkbox" id="terms_accept" name="terms_accept" required
                       class="w-4 h-4 text-orange-600 bg-white border-gray-300 rounded focus:ring-orange-500 focus:ring-2 cursor-pointer transition-all">
                <span class="text-[13px] text-gray-600 font-medium group-hover:text-gray-900 transition-colors">
            I accept the <a href="{{ route('terms') }}" target="_blank" class="text-[#20c997] hover:text-[#1aa179] transition-colors">Terms of use</a>
        </span>
            </label>

            <label class="flex items-center gap-3 cursor-pointer group">
                <input type="checkbox" id="privacy_read" name="privacy_read" required
                       class="w-4 h-4 text-orange-600 bg-white border-gray-300 rounded focus:ring-orange-500 focus:ring-2 cursor-pointer transition-all">
                <span class="text-[13px] text-gray-600 font-medium group-hover:text-gray-900 transition-colors">
            I have read the <a href="{{ route('privacy.policy') }}" target="_blank" class="text-[#20c997] hover:text-[#1aa179] transition-colors">Privacy policy</a>
        </span>
            </label>

        </div>

    </div>
</div>

<div id="summary-content">
    <input type="hidden" id="calc-total-days" value="{{ $totalDays }}">
    <input type="hidden" id="calc-daily-rate" value="{{ $vehicle->base_daily_rate }}">
    <input type="hidden" id="calc-tariffs" value="{{ json_encode($tariffs ?? []) }}">
    <input type="hidden" id="calc-seasonal-prices" value="{{ json_encode($seasonalPrices ?? []) }}">

    <h3 class="text-xl font-black text-gray-800 uppercase tracking-tight mb-6 sm:mb-8">Cost Summary</h3>

    <div class="space-y-4 mb-8 border-b border-gray-100 pb-8">
        <div class="flex justify-between items-center text-sm mb-2">
            <span class="text-gray-500">Rent for <span id="summary-days-text">{{ $totalDays }}</span> days</span>
            <div class="text-right flex flex-col items-end">

                <div id="discount-wrapper" class="hidden flex-col items-end">
            <span id="discount-percent" class="text-[10px] font-black text-green-600 uppercase tracking-widest bg-green-50 px-2 py-0.5 rounded-md mb-1">
                -0% Discount
            </span>
                    <span id="original-total-price" class="text-gray-400 line-through text-xs mb-0.5">
                €0.00
            </span>
                </div>

                <span id="summary-base-rent" class="font-black text-gray-900 text-lg">€0.00</span>
            </div>
        </div>

        <div class="flex justify-between text-sm">
            <span class="text-gray-400">Insurance</span>
            <span id="summary-insurance" class="font-black text-gray-800 text-right">€0.00</span>
        </div>

        <div class="flex justify-between text-sm">
            <span class="text-gray-400">Additional services</span>
            <span id="summary-services" class="font-black text-gray-800 text-right">€0.00</span>
        </div>

        <div class="flex justify-between items-center py-2 border-b border-gray-50">
            <span class="text-xs font-bold text-gray-500 uppercase">Delivery</span>
            <span id="summary-delivery" class="text-sm font-black text-gray-800">Please choose one</span>
        </div>
    </div>

    <div class="bg-orange-50 p-5 sm:p-6 rounded-[2rem] border border-orange-100 mb-8">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-2 sm:gap-0 text-center sm:text-left">
            <span class="text-[10px] font-black text-orange-900 uppercase tracking-widest">Total Estimated</span>
            <span id="summary-total" class="text-3xl font-black text-orange-600">€{{ number_format(($vehicle->base_daily_rate * $totalDays), 2) }}</span>
        </div>
    </div>

    <div class="space-y-4 mb-8 px-2">
        <div class="flex justify-between items-start">
            <div class="flex flex-col">
                <span class="text-sm font-bold text-gray-800">To pay now on the website</span>
                <span class="text-xs text-gray-400 mt-0.5">Visa, Mastercard</span>
            </div>
            <span id="summary-pay-now" class="font-black text-gray-800 text-sm">€0.00</span>
        </div>

        <div class="flex justify-between items-start">
            <div class="flex flex-col">
                <span class="text-sm font-bold text-gray-800">To pay when picking up the car</span>
                <span class="text-xs text-gray-400 mt-0.5">Cash</span>
            </div>
            <span id="summary-pay-later" class="font-black text-gray-800 text-sm">€0.00</span>
        </div>

        <div class="flex justify-between items-start pt-4 border-t border-gray-100">
            <div class="flex flex-col">
                <span class="text-sm font-bold text-gray-800">+ refundable deposit</span>
                <span class="text-xs text-gray-400 mt-0.5">Cash (immediate refund after drop-off)</span>
            </div>
            <span id="summary-deposit" class="font-black text-gray-800 text-sm">€0.00</span>
        </div>
    </div>



    <div class="space-y-3 mb-10 px-2 opacity-60">
        <div class="text-[10px] text-gray-500 text-center italic">
            Final exact prices including selected insurances and add-ons will be calculated securely on the next step.
        </div>
    </div>

    <div class="mb-8">
        <h3 class="text-sm font-black text-gray-800 uppercase tracking-widest mb-4">
            Payment Method
        </h3>

        <div class="space-y-3">
            <label class="flex flex-col sm:flex-row sm:items-center justify-between p-4 border border-gray-200 rounded-2xl cursor-pointer hover:border-orange-400 transition gap-3 sm:gap-0">
                <div class="flex items-center gap-4">
                    <input type="radio" name="payment_gateway" value="stripe" class="accent-orange-600" checked>
                    <img src="https://cdn.worldvectorlogo.com/logos/stripe-4.svg" class="h-5 sm:h-6">
                    <span class="text-sm font-semibold text-gray-700">Pay with card</span>
                </div>
                <span class="text-xs text-gray-400 sm:text-right pl-8 sm:pl-0">Visa / Mastercard</span>
            </label>

            <label class="flex items-center justify-between p-4 border border-gray-200 rounded-2xl cursor-pointer hover:border-orange-400 transition bg-white">
                <div class="flex items-center gap-4">
                    <input type="radio" name="payment_gateway" value="pok" class="w-4 h-4 accent-orange-600 shrink-0">
                    <div class="flex items-center justify-center p-2 rounded-lg -ml-2 sm:-ml-4 shrink-0" style="width: 70px; height: 50px;">
                        <img src="{{ asset('poku.png') }}" alt="Pok Albania" class="max-h-full max-w-full object-contain" style="transform: scale(1.4);">
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm font-bold text-gray-800">Pay with POK</span>
                        <span class="text-[10px] text-gray-400 leading-tight">Secure Albanian Payment</span>
                    </div>
                </div>
            </label>
        </div>
    </div>

    <button id="modal-main-btn" class="w-full bg-orange-600 text-white font-black py-4 sm:py-5 rounded-[1.5rem] hover:bg-orange-700 transition shadow-lg shadow-orange-100 uppercase text-xs tracking-widest flex items-center justify-center gap-2">
        <span>Continue</span> <i class="fas fa-arrow-right text-[10px]"></i>
    </button>
</div>


