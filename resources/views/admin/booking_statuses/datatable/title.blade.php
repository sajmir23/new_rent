<span style="
    color: {{ $lead_status->text_color }};
    background-color: {{ $lead_status->background_color }};
    padding: 0.25em 0.5em;
    border-radius: 0.25rem;
    font-weight: 600;
    display: inline-block;
" class="badge">
    {{ $lead_status->title ?? '--' }}
</span>
