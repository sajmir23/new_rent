<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmed - RentalBania</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" type="image/png" href="{{ asset('logo_rent.png') }}">
    <style>
        body { font-family: 'Montserrat', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4 sm:p-0">

<div class="bg-white p-6 sm:p-10 rounded-3xl shadow-xl max-w-lg w-full text-center border border-gray-100 my-8">
    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6">
        <i class="fas fa-check text-3xl sm:text-4xl text-green-600"></i>
    </div>

    <h1 class="text-2xl sm:text-3xl font-black text-gray-800 uppercase tracking-tighter mb-2">Booking Confirmed!</h1>
    <p class="text-gray-500 mb-6 sm:mb-8 text-xs sm:text-sm font-medium px-2">Thank you, {{ $booking->first_name }}. Your reservation has been successfully processed.</p>

    <div class="bg-gray-50 rounded-2xl p-4 sm:p-6 text-left border border-gray-100 mb-6 sm:mb-8">
        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-1 sm:gap-0 mb-4 border-b border-gray-200 pb-4 text-center sm:text-left">
            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Booking Code</span>
            <span class="text-lg font-black text-orange-600">{{ $booking->booking_code }}</span>
        </div>

        <div class="space-y-3">
            <div class="flex justify-between gap-4 text-sm">
                <span class="text-gray-500 font-semibold shrink-0">Vehicle:</span>
                <span class="font-bold text-gray-800 text-right">{{ $booking->vehicle->title ?? 'N/A' }}</span>
            </div>
            <div class="flex justify-between gap-4 text-sm">
                <span class="text-gray-500 font-semibold shrink-0">Pick-up:</span>
                <span class="font-bold text-gray-800 text-right">{{ \Carbon\Carbon::parse($booking->pickup_date)->format('d M, Y') }} at {{ $booking->pickup_time }}</span>
            </div>
            <div class="flex justify-between gap-4 text-sm">
                <span class="text-gray-500 font-semibold shrink-0">Drop-off:</span>
                <span class="font-bold text-gray-800 text-right">{{ \Carbon\Carbon::parse($booking->dropoff_date)->format('d M, Y') }} at {{ $booking->dropoff_time }}</span>
            </div>

            <div class="flex justify-between gap-4 text-sm">
                <span class="text-gray-500 font-semibold shrink-0">Deposit:</span>
                <span class="font-bold text-gray-800 text-right">€{{ number_format($booking->insurance->deposit_price ?? 0) }}</span>
            </div>

            <div class="flex justify-between gap-4 text-sm border-t border-gray-200 pt-3 mt-3">
                <span class="text-orange-600 font-bold shrink-0 text-[10px] uppercase tracking-wider">Paid Online:</span>
                <span class="font-black text-orange-600 text-right">€{{ number_format($booking->commission_amount, 2) }}</span>
            </div>

            <div class="flex justify-between gap-4 text-sm mt-1">
                <span class="text-gray-500 font-semibold shrink-0">Balance to pay at pick-up:</span>
                <span class="font-bold text-gray-800 text-right">€{{ number_format($booking->total_price - ($booking->commission_amount + $booking->insurance->deposit_price), 2) }}</span>
            </div>
        </div>
    </div>

    <p class="text-[10px] sm:text-[11px] text-gray-400 mb-6 sm:mb-8 leading-relaxed">
        A confirmation email has been sent to <strong>{{ $booking->email }}</strong> with full details. Please check your spam folder if you do not see it shortly.
    </p>

    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
        <a href="/" class="flex-1 bg-orange-600 text-white font-black py-3 sm:py-4 rounded-xl hover:bg-orange-700 transition text-center uppercase text-xs tracking-widest shadow-md shadow-orange-100">
            Back to Home
        </a>

        @if(isset($stripeInvoiceUrl) && !empty($stripeInvoiceUrl))
            <a href="{{ $stripeInvoiceUrl }}" target="_blank" class="flex-1 bg-blue-600 text-white font-black py-3 sm:py-4 rounded-xl hover:bg-blue-700 transition shadow-md text-center uppercase text-xs tracking-widest flex items-center justify-center gap-2">
                <i class="fas fa-receipt"></i> Download Receipt
            </a>
        @endif


    </div>
</div>

</body>
</html>
