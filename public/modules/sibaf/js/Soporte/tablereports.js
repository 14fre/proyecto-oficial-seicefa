function confirmSubmit(action, id) {
        let title = action === 'arreglo' ? 'Aprobar para Arreglo' : 'Aprobar para Baja';
        let text = action === 'arreglo' ? '¿Está seguro de que desea aprobar este reporte para arreglo?' : '¿Está seguro de que desea aprobar este reporte para baja? Asegúrese de haber seleccionado los archivos Excel.';
        Swal.fire({
            icon: 'question',
            title: title,
            text: text,
            showCancelButton: true,
            confirmButtonColor: action === 'arreglo' ? '#28a745' : '#ffc107',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(action + 'Form' + id).submit();
            }
        });
    }

    // Función para el botón de rechazo con SweetAlert2
    document.querySelectorAll('.reject-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault(); // Evita el envío inmediato del formulario
            const reportId = this.getAttribute('data-report-id');
            Swal.fire({
                icon: 'warning',
                title: 'Rechazar Reporte',
                text: '¿Está seguro de que desea rechazar este reporte? Esta acción no se puede deshacer.',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Rechazar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.form.submit(); // Envía el formulario si se confirma
                }
            });
        });
    });