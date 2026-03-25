<script>
    $(document).ready(function () {
        @if(session()->has(\App\Support\FlashNotification::SESSION_NAME))
        @foreach(session()->get(\App\Support\FlashNotification::SESSION_NAME) as $notification)
        toastr.{{ @$notification['type'] }}('{{ @$notification['message'] }}', '{{ @$notification['title'] }}');
        @endforeach
        @endif
    })
</script>
