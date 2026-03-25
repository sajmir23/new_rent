{{--
<div id="booking-modal" class="fixed inset-0 z-[100] hidden overflow-y-auto" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" id="modal-overlay"></div>

    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative transform overflow-hidden rounded-[2rem] bg-white text-left shadow-2xl transition-all w-full max-w-6xl flex flex-col h-[90vh]">

            <div class="px-8 py-4 border-b border-gray-100 flex items-center gap-6 bg-white z-20">
                <nav class="flex items-center gap-4 text-[11px] font-black uppercase tracking-widest">
                    <button id="step-car-btn" class="flex items-center gap-2 text-orange-600 transition hover:opacity-80">
                        <span class="w-6 h-6 rounded-full bg-orange-600 text-white flex items-center justify-center text-[9px]">1</span>
                        Car
                    </button>
                    <i class="fas fa-chevron-right text-gray-300 text-[8px]"></i>
                    <button id="step-booking-btn" class="flex items-center gap-2 text-gray-400 transition hover:text-orange-600">
                        <span class="w-6 h-6 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center text-[9px]">2</span>
                        Booking
                    </button>
                    <i class="fas fa-chevron-right text-gray-300 text-[8px]"></i>
                    <span class="flex items-center gap-2 text-gray-300 cursor-not-allowed">
                        <span class="w-6 h-6 rounded-full bg-gray-50 text-gray-300 flex items-center justify-center text-[9px]">3</span>
                        Payment
                    </span>
                </nav>
                <button id="close-modal" class="ml-auto text-gray-400 hover:text-orange-600 transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="flex flex-col md:flex-row overflow-hidden flex-grow">
                <div class="w-full md:w-[65%] p-8 md:p-10 overflow-y-auto" id="modal-left-content">
                </div>

                <div class="w-full md:w-[35%] p-8 md:p-10 bg-gray-50 border-l border-gray-100 overflow-y-auto" id="modal-right-content">
                </div>
            </div>
        </div>
    </div>
</div>--}}

<div id="booking-modal" class="fixed inset-0 z-[100] hidden overflow-y-auto" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" id="modal-overlay"></div>

    <div class="flex min-h-full items-center justify-center p-0 sm:p-4">

        <div class="relative transform overflow-hidden rounded-none sm:rounded-[2rem] bg-white text-left shadow-2xl transition-all w-full max-w-6xl flex flex-col h-[100vh] sm:h-[90vh]">

            <div class="px-4 sm:px-8 py-3 sm:py-4 border-b border-gray-100 flex items-center justify-between sm:justify-start gap-2 sm:gap-6 bg-white z-20 shrink-0">
                <nav class="flex items-center gap-2 sm:gap-4 text-[9px] sm:text-[11px] font-black uppercase tracking-widest overflow-x-auto no-scrollbar py-1">
                    <button id="step-car-btn" class="flex items-center gap-1 sm:gap-2 text-orange-600 transition hover:opacity-80 whitespace-nowrap">
                        <span class="w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-orange-600 text-white flex items-center justify-center text-[9px]">1</span>
                        Car
                    </button>
                    <i class="fas fa-chevron-right text-gray-300 text-[8px] shrink-0"></i>

                    <button id="step-booking-btn" class="flex items-center gap-1 sm:gap-2 text-gray-400 transition hover:text-orange-600 whitespace-nowrap">
                        <span class="w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center text-[9px]">2</span>
                        Booking
                    </button>
                    <i class="fas fa-chevron-right text-gray-300 text-[8px] shrink-0"></i>

                    <span class="flex items-center gap-1 sm:gap-2 text-gray-300 cursor-not-allowed whitespace-nowrap">
                        <span class="w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-gray-50 text-gray-300 flex items-center justify-center text-[9px]">3</span>
                        Payment
                    </span>
                </nav>
                <button id="close-modal" class="ml-2 sm:ml-auto text-gray-400 hover:text-orange-600 transition shrink-0 pl-2 sm:pl-0 border-l sm:border-0 border-gray-100">
                    <i class="fas fa-times text-lg sm:text-xl"></i>
                </button>
            </div>

            <div class="flex flex-col md:flex-row overflow-y-auto md:overflow-hidden flex-grow relative">

                <div class="w-full md:w-[65%] p-4 sm:p-6 md:p-10 md:overflow-y-auto shrink-0 md:shrink" id="modal-left-content">
                </div>

                <div class="w-full md:w-[35%] p-4 sm:p-6 md:p-10 bg-gray-50 border-t md:border-t-0 md:border-l border-gray-100 md:overflow-y-auto shrink-0 md:shrink" id="modal-right-content">
                </div>

            </div>
        </div>
    </div>
</div>
