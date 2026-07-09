<script>
    document.querySelectorAll('.status-form').forEach((form) => {
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            const button = form.querySelector('button[type="submit"]');
            const action = button ? button.textContent.trim().toLowerCase() : 'cambiar estado';

            Swal.fire({
                title: 'Confirmar accion',
                text: `Se va a ${action} este registro.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Si, continuar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#0d6efd'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
