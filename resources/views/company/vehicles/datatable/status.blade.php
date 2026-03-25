
<span style="
    color: {{ $vehicle->vehicleStatus->text_color }};
    background-color: {{ $vehicle->vehicleStatus->background_color }};
    padding: 0.25em 0.5em;
    border-radius: 0.25rem;
    font-weight: 600;
    display: inline-block;
" class="badge">
    {{ $vehicle->vehicleStatus->{"title_en"} ?? '--' }}
</span>
