<script>var hostUrl = "assets/";</script>
<script src="{{asset('metronic/assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('metronic/assets/js/scripts.bundle.js')}}"></script>
<script src="{{asset('metronic/assets/js/scripts.bundle.js')}}"></script>
<script src="{{ asset('metronic/assets/plugins/toastr/build/toastr.min.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.dismiss-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                let notifId = this.dataset.id;

                // Optimistic UI removal
                document.getElementById(`notif-${notifId}`)?.remove();

                // Update badge count
                let badge = this.closest('.app-navbar-item').querySelector('.badge');
                if (badge) {
                    let count = parseInt(badge.textContent.trim());
                    count--;
                    if (count > 0) {
                        badge.textContent = count;
                    } else {
                        badge.remove();
                    }
                }

                // TODO: send AJAX to mark notification as read or delete
                {{--fetch(`/notifications/${notifId}/dismiss`, {--}}
                {{--    method: 'POST',--}}
                {{--    headers: {--}}
                {{--        'X-CSRF-TOKEN': '{{ csrf_token() }}',--}}
                {{--        'Content-Type': 'application/json'--}}
                {{--    }--}}
                {{--});--}}
            });
        });
    });
</script>

<script>
    document.querySelectorAll('.dismiss-btn').forEach(function(button) {
        button.addEventListener('click', function () {
            const notificationId = this.getAttribute('data-id');
            const currentButton = this;


            fetch(`/company/notifications/marked/${notificationId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
                .then(response => {

                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        toastr.success(data.message || 'Notification marked as read', 'Success');
                        currentButton.closest('.notification-item').remove();
                    } else {
                        toastr.error(data.message || 'Something went wrong');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.error('An unexpected error occurred');
                });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        let userId = {{ auth()->id() }};

        const notificationSound = new Audio("{{asset('sound/shiny_ding_sound_effect.mp3')}}");
         notificationSound.volume=0.6;

        Echo.private(`App.Models.User.${userId}`)
            .notification((notification) => {

                notificationSound.play();

                let message = notification.message || notification.data.message;

                let bellIcon = document.querySelector('.btn.btn-icon.btn-custom');

                if (bellIcon) {
                    let badge = bellIcon.querySelector('.badge-circle');
                    if (badge) {
                        let count = parseInt(badge.textContent) || 0;
                        badge.textContent = count + 1;
                    } else {
                        bellIcon.insertAdjacentHTML(
                            'beforeend',
                            `<span class="position-absolute top-0 start-100 translate-middle badge badge-circle bg-danger fs-8">1</span>`
                        );
                    }
                }

                let headerCount = document.querySelector('.menu-sub .fs-8.opacity-75');
                if (headerCount) {
                    let current = parseInt(headerCount.textContent.match(/\d+/)) || 0;
                    headerCount.textContent = `${current + 1} new`;
                }

                let list = document.querySelector('.scroll-y');
                if(list) {
                    let html = `
                <div class="d-flex flex-stack py-4 notification-item" id="notif-${notification.id}">
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-35px me-4">
                            <span class="symbol-label bg-light-primary">
                                <i class="ki-outline ki-abstract-28 fs-2 text-primary"></i>
                            </span>
                        </div>
                        <div class="mb-0 me-2">
                            <div class="fs-6 text-gray-800 fw-bold">${message}</div>
                            <div class="text-gray-500 fs-7">just now</div>
                        </div>
                    </div>

                    <button class="btn btn-sm btn-icon btn-light-danger dismiss-btn"
                        data-id="${notification.id}">
                        <i class="bi bi-x fs-5"></i>
                    </button>
                </div>`;
                    list.insertAdjacentHTML('afterbegin', html);
                }

                let tableBody = document.querySelector('#notifications-table tbody');
                if(tableBody){
                    let rowHtml = `
                <tr id="notif-row-${notification.id}">
                    <td>
                        <button class="btn btn-sm btn-primary px-2 py-1 mark-read-btn" data-id="${notification.id}">
                            <i class="fa fa-check"></i> Mark as Read
                        </button>
                    </td>
                    <td>${message}</td>
                    <td><span class="badge bg-warning text-dark">Unread</span></td>
                    <td>just now</td>
                    <td>__</td>
                </tr>`;
                    tableBody.insertAdjacentHTML('afterbegin', rowHtml);
                }
                const dismissBtn = document.querySelector(`#notif-${notification.id} .dismiss-btn`);
                if (dismissBtn) {
                    dismissBtn.addEventListener('click', function () {
                        const notifId = this.dataset.id;
                        fetch(`/company/notifications/marked/${notifId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            }
                        })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    document.getElementById(`notif-${notifId}`)?.remove();
                                    if (bellIcon) {
                                        let badge = bellIcon.querySelector('.badge-circle');
                                        if (badge) {
                                            let count = parseInt(badge.textContent) || 0;
                                            count--;
                                            if (count > 0) badge.textContent = count;
                                            else badge.remove();
                                        }
                                    }

                                    if (headerCount) {
                                        let current = parseInt(headerCount.textContent.match(/\d+/)) || 0;
                                        current--;
                                        if (current > 0) headerCount.textContent = `${current} new`;
                                        else headerCount.textContent = `0 new`;
                                    }

                                    const tableRow = document.getElementById(`notif-row-${notifId}`);
                                    if(tableRow){
                                        tableRow.querySelector('td:nth-child(3)').innerHTML = '<span class="badge bg-success">Read</span>';
                                        tableRow.querySelector('td:nth-child(1)').innerHTML = '<span class="text-muted">—</span>';
                                        tableRow.querySelector('td:nth-child(5)').textContent = 'just now';
                                    }
                                }
                            });
                    });
                }

                const markBtn = document.querySelector(`#notif-row-${notification.id} .mark-read-btn`);
                if(markBtn){
                    markBtn.addEventListener('click', function () {
                        const notifId = this.dataset.id;
                        fetch(`/company/notifications/marked/${notifId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            }
                        })
                            .then(res => res.json())
                            .then(data => {
                                if(data.success){

                                    const tableRow = document.getElementById(`notif-row-${notifId}`);
                                    if(tableRow){
                                        tableRow.querySelector('td:nth-child(3)').innerHTML = '<span class="badge bg-success">Read</span>';
                                        tableRow.querySelector('td:nth-child(1)').innerHTML = '<span class="text-muted">—</span>';
                                        tableRow.querySelector('td:nth-child(5)').textContent = 'just now';
                                    }

                                    document.getElementById(`notif-${notifId}`)?.remove();

                                    if (bellIcon) {
                                        let badge = bellIcon.querySelector('.badge-circle');
                                        if (badge) {
                                            let count = parseInt(badge.textContent) || 0;
                                            count--;
                                            if (count > 0) badge.textContent = count;
                                            else badge.remove();
                                        }
                                    }

                                    if (headerCount) {
                                        let current = parseInt(headerCount.textContent.match(/\d+/)) || 0;
                                        current--;
                                        if (current > 0) headerCount.textContent = `${current} new`;
                                        else headerCount.textContent = `0 new`;
                                    }
                                }
                            });
                    });
                }

            });
    });
</script>






