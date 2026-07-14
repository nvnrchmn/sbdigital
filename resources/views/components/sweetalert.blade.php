<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- SweetAlert2 Initialization -->
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('swal:modal', (data) => {
            let payload = Array.isArray(data) ? data[0] : data;
            if (!payload) return;
            Swal.fire({
                title: payload.title,
                text: payload.text,
                icon: payload.icon,
                confirmButtonColor: '#4f46e5',
            });
        });
 
        Livewire.on('notify', (data) => {
            let payload = Array.isArray(data) ? data[0] : data;
            if (!payload) return;
            let title = typeof payload === 'string' ? payload : (payload.message || payload.title);
            let icon = typeof payload === 'string' ? 'success' : (payload.icon || 'success');
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: icon,
                title: title,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        });
 
        Livewire.on('swal:confirm', (data) => {
            let payload = Array.isArray(data) ? data[0] : data;
            if (!payload) return;
            Swal.fire({
                title: payload.title,
                text: payload.text,
                icon: payload.icon ?? 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: payload.confirmText ?? 'Ya, Hapus!',
                cancelButtonText: payload.cancelText ?? 'Batal',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl',
                    cancelButton: 'rounded-xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch(payload.action, payload.params ?? {});
                }
            });
        });
    });
</script>
