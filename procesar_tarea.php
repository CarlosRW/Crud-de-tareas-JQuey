<?php
require_once("include/conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_tarea = $_POST['tareaIndex'] ?? null;
    $id_usuario = $_POST['id_usuario'];
    $estado = $_POST['estado'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];

    if ($id_tarea) {
        // Actualizar tarea existente
        $stmt = $mysqli->prepare("UPDATE tareas 
                                  SET id_usuario = ?, estado = ?, titulo = ?, descripcion = ? 
                                  WHERE id_tarea = ?");
        $stmt->bind_param("isssi", $id_usuario, $estado, $titulo, $descripcion, $id_tarea);
    } else {
        // Crear nueva tarea
        $stmt = $mysqli->prepare("INSERT INTO tareas (id_usuario, estado, titulo, descripcion) 
                                  VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $id_usuario, $estado, $titulo, $descripcion);
    }

    if ($stmt->execute()) {
        echo "Tarea " . ($id_tarea ? "actualizada" : "creada") . " correctamente";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

if (isset($_POST['eliminar'])) {
    $id = $_POST['eliminar'];
    $stmt = $mysqli->prepare("DELETE FROM tareas WHERE id_tarea = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "Tarea eliminada correctamente";
    } else {
        echo "Error al eliminar: " . $stmt->error;
    }
    $stmt->close();
}

$mysqli->close();
?>