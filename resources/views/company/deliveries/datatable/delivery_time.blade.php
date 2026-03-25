<div>
    <a class="text-gray-700 semi-bold fs-6">
        {{ $delivery->delivery_time ? \Carbon\Carbon::parse($delivery->delivery_time)->format('H:i') : '—' }}
    </a>
</div>