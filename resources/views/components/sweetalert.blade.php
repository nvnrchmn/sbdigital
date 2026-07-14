<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- SweetAlert2 Initialization -->
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('swal:modal', (data) => {
            Swal.fire({
                title: data[0].title,
                text: data[0].text,
                icon: data[0].icon,
                confirmButtonColor: '#4f46e5',
            });
        });

        Livewire.on('notify', (data) => {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: data[0].icon || 'success',
                title: data[0].message,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        });

        Livewire.on('swal:confirm', (data) => {
            Swal.fire({
                title: data[0].title,
                text: data[0].text,
                icon: data[0].icon ?? 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: data[0].confirmText ?? 'Ya, Hapus!',
                cancelButtonText: data[0].cancelText ?? 'Batal',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl',
                    cancelButton: 'rounded-xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch(data[0].action, data[0].params ?? {});
                }
            });
        });
    });
</script>
