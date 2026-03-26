<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms of Service - Rentalbania</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Montserrat', sans-serif; scroll-behavior: smooth; }
        .legal-content h2 { color: #1a202c; font-weight: 800; text-transform: uppercase; letter-spacing: -0.025em; margin-top: 2.5rem; margin-bottom: 1rem; font-size: 1.1rem; border-left: 4px solid #ea580c; padding-left: 1rem; }
        .legal-content p { margin-bottom: 1.25rem; color: #4a5568; line-height: 1.8; font-size: 0.95rem; }
        .legal-content ul { margin-bottom: 1.5rem; list-style-type: disc; padding-left: 1.5rem; color: #4a5568; }
        .legal-content li { margin-bottom: 0.5rem; font-size: 0.95rem; }
    </style>
</head>
<body class="bg-white text-gray-800">

<div class="fixed top-0 left-0 w-full h-1.5 bg-gray-100 z-50">
    <div class="bg-orange-600 h-full w-full"></div>
</div>

<div class="max-w-3xl mx-auto px-6 py-16 sm:py-24">

    <div class="mb-12 border-b border-gray-100 pb-8 text-center sm:text-left">
        <div class="flex flex-col sm:flex-row items-center justify-between mb-6 gap-4">
            <span class="text-orange-600 font-black text-2xl tracking-tighter uppercase">Rentalbania</span>
            <a href="/" class="text-[10px] font-black text-gray-400 hover:text-gray-900 uppercase tracking-widest border border-gray-200 px-4 py-2 rounded-full transition-all">
                Back to Booking ✕
            </a>
        </div>
        <h1 class="text-4xl sm:text-5xl font-black text-gray-900 leading-none">Terms of <span class="text-orange-600">Service</span></h1>
        <p class="mt-4 text-gray-400 font-medium">Please read our car rental policies and requirements carefully.</p>
    </div>

    <div class="legal-content">

        <h2>1. Driver Requirements & Documents</h2>
        <p>To rent a vehicle through our marketplace, all drivers must meet the following criteria:</p>
        <ul>
            <li><strong>Minimum Age:</strong> Drivers must be at least 21 years old. For certain high-performance or luxury categories, the minimum age may be 25.</li>
            <li><strong>Driving Experience:</strong> A valid driving license held for at least 2 years is mandatory.</li>
            <li><strong>Mandatory Documents:</strong> You must present a valid Passport/ID and a valid original Driving License at the time of pickup. Photocopies are not accepted.</li>
        </ul>

        <h2>2. Booking, Deposit & Payments</h2>
        <p>Our platform facilitates the connection between you and independent car rental providers.</p>
        <ul>
            <li><strong>Online Deposit:</strong> A 20% deposit is required to confirm the booking via Stripe. This ensures the vehicle is reserved for your dates.</li>
            <li><strong>Remaining Balance:</strong> The remaining 80% is payable directly to the car owner/agency upon arrival (Cash or Card, depending on the provider).</li>
            <li><strong>Security Deposit:</strong> A refundable security deposit (guarantee) may be required by the provider during pickup, depending on the insurance package selected.</li>
        </ul>

        <h2>3. Fuel & Cleaning Policy</h2>
        <p>We follow a transparent fuel policy to avoid extra charges:</p>
        <ul>
            <li><strong>Fuel Level:</strong> Vehicles are generally provided with a certain level of fuel and must be returned with the same level (Like-for-Like). Missing fuel will be charged at local pump prices plus a service fee.</li>
            <li><strong>Cleanliness:</strong> Vehicles should be returned in a reasonably clean condition. An extra cleaning fee may apply if the interior is excessively dirty or if there is evidence of smoking.</li>
        </ul>

        <h2>4. Traffic Violations & Fines</h2>
        <p>The renter is solely responsible for all traffic violations incurred during the rental period:</p>
        <ul>
            <li>This includes parking tickets, speeding fines, bridge tolls, and any other traffic-related penalties.</li>
            <li>An administrative fee may be applied by the car provider for processing these fines on your behalf.</li>
        </ul>

        <h2>5. Usage Restrictions</h2>
        <p>To ensure safety and vehicle maintenance, the following are strictly prohibited:</p>
        <ul>
            <li>Driving under the influence of alcohol or drugs.</li>
            <li>Off-road driving (unless the vehicle is a designated 4x4 and permitted by the owner).</li>
            <li>Sub-leasing the vehicle or allowing unauthorized drivers to operate it.</li>
            <li>Using the vehicle for racing, towing, or commercial transport of goods.</li>
        </ul>

        <h2>6. Insurance & Accidents</h2>
        <p>Insurance coverage is provided by the car rental agency, not by Rentalbania directly.</p>
        <ul>
            <li>In case of an accident or damage, you must notify the car provider immediately and obtain a police report.</li>
            <li>Failure to provide a police report may void the insurance coverage, making the renter liable for the full cost of damages.</li>
        </ul>

        <div class="mt-16 p-8 bg-gray-50 rounded-3xl border border-gray-100">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Agreement</p>
            <p class="text-sm text-gray-600 italic">By clicking "I accept the Terms of Use" during the booking process, you acknowledge that you have read, understood, and agreed to all the points mentioned above.</p>
        </div>

    </div>

    <div class="mt-12 text-center">
        <p class="text-xs text-gray-400 mb-6 uppercase tracking-widest font-bold">© {{ date('Y') }} Rentalbania Marketplace</p>
    </div>
</div>

</body>
</html>