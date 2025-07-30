document.addEventListener('DOMContentLoaded', function () {
    const modalTarea = new bootstrap.Modal(document.getElementById('tareaModal'));
    const modalTitle = document.getElementById('tareaModalLabel');
    const formTarea = document.getElementById('formTarea');
    const selectUsuario = document.getElementById('usuario');

// Función para cargar usuarios en el combobox
function cargarUsuarios() {
    $.ajax({
        url: '../procesar_usuario.php?obtener_usuarios=1',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            console.log("Usuarios cargados:", data);
            const $select = $('#usuario');
            $select.empty(); // Limpiar opciones anteriores
            
            if (data && data.length > 0) {
                $select.append('<option value="">Seleccione un usuario</option>');
                data.forEach(usuario => {
                    $select.append(`<option value="${usuario.Id_usuario}">${usuario.Nombre}</option>`);
                });
            } else {
                $select.append('<option value="">No hay usuarios disponibles</option>');
            }
        },
        error: function(xhr, status, error) {
            console.error("Error al cargar usuarios:", error);
            $('#usuario').html('<option value="">Error al cargar usuarios</option>');
        }
    });
}
    // Cargar tareas iniciales
    function cargarTareas() {
        $.get('../obtener_tareas.php', function(data) {
            $('#tablaTareas tbody').html(data);
        });
    }

    // Manejar clic en Editar
    $(document).on('click', '.btnEditarTarea', function() {
        const id = $(this).data('id');
        $.get('../obtener_tareas.php?detalle=' + id, function(tarea) {
            modalTitle.textContent = 'Editar Tarea';
            $('#tareaIndex').val(tarea.id_tarea);
            $('#titulo').val(tarea.titulo);
            $('#descripcion').val(tarea.descripcion);
            $('#estado').val(tarea.estado);
            $('#usuario').val(tarea.id_usuario);
            modalTarea.show();
        }, 'json');
    });

    // Manejar clic en Eliminar
    $(document).on('click', '.btnEliminarTarea', function() {
        if(!confirm('¿Está seguro de eliminar esta tarea?')) return;
        const id = $(this).data('id');
        $.post('../procesar_tarea.php', { eliminar: id }, function(respuesta) {
            alert(respuesta);
            cargarTareas();
        });
    });

    // Enviar formulario de tarea
    $('#formTarea').on('submit', function(e) {
        e.preventDefault();
        const datos = $(this).serialize();
        
        $.post('../procesar_tarea.php', datos, function(respuesta) {
            alert(respuesta);
            modalTarea.hide();
            cargarTareas();
        });
    });

    // Limpiar modal al cerrar
    $('#tareaModal').on('hidden.bs.modal', () => {
        formTarea.reset();
        modalTitle.textContent = 'Agregar Tarea';
    });

    // Inicializar
    cargarUsuarios();
    cargarTareas();
});