@if(session('success') || session('error') || session('status'))
    <div class="alerts-wrapper px-4 py-2">
        @foreach (['success', 'error', 'status'] as $msg)
            @if(session($msg))
                <div class="alert alert-{{ $msg === 'error' ? 'danger' : 'success' }} alert-dismissible fade show rounded-3 border-0" role="alert">
                    {{ session($msg) }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        @endforeach
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const alerts = document.querySelectorAll('.alerts-wrapper .alert');
            if (!alerts.length) {
                return;
            }
            setTimeout(() => {
                alerts.forEach(alert => {
                    alert.classList.add('alert-hide');
                    setTimeout(() => alert.remove(), 300);
                });
            }, 4000);
        });
    </script>
@endif
