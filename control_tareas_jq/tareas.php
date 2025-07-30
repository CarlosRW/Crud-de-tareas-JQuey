<?php
include("include/conexion.php");
include("include/menu.php");

// Obtener usuarios para el combo
$usuarios = $conexion->query("SELECT id_usuario, nombre FROM usuarios");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Tareas</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <div class="container mt-5">
    <h2 class="mb-4">Agregar Nueva Tarea</h2>
    <form id="formTarea">
      <div class="mb-3">
        <label for="titulo" class="form-label">Título</label>
        <input type="text" class="form-control" id="titulo" name="titulo" required>
      </div>
      <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
      </div>
      <div class="mb-3">
        <label for="estado" class="form-label">Estado</label>
        <select class="form-control" id="estado" name="estado" required>
          <option value="Pendiente">Pendiente</option>
          <option value="En Proceso">En Proceso</option>
          <option value="Completado">Completado</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="id_usuario" class="form-label">Usuario Responsable</label>
        <select class="form-control" id="id_usuario" name="id_usuario" required>
          <option value="">Seleccione un usuario</option>
          <?php while ($usuario = $usuarios->fetch_assoc()): ?>
            <option value="<?= $usuario['id_usuario'] ?>"><?= $usuario['nombre'] ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <input type="hidden" name="accion" value="crear">
      <button type="submit" class="btn btn-success">Guardar Tarea</button>
    </form>

    <hr class="my-4">

    <h2>Lista de Tareas</h2>
    <div id="tablaTareas"></div>
  </div>

  <script>
    function cargarTareas() {
      $.post("tareas_crud.php", { accion: "leer" }, function(data) {
        $("#tablaTareas").html(data);
      });
    }

    $("#formTarea").submit(function(e) {
      e.preventDefault();
      $.post("tareas_crud.php", $(this).serialize(), function(respuesta) {
        alert(respuesta);
        $("#formTarea")[0].reset();
        cargarTareas();
      });
    });

    function eliminarTarea(id) {
      if (confirm("¿Deseas eliminar esta tarea?")) {
        $.post("tareas_crud.php", { accion: "eliminar", id_tarea: id }, function(r) {
          alert(r);
          cargarTareas();
        });
      }
    }

    $(document).ready(cargarTareas);
  </script>
</body>
</html>
