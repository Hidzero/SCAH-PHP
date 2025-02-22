<div {{ $attributes->merge(['class' => 'alert alert-' . ($type === 'error' ? 'danger' : 'success') . ' alert-dismissible fade show']) }} role="alert">
    {{ $slot }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(function () {
            let alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 10000); // 10 segundos
    });
</script>
