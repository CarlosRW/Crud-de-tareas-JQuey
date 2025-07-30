<?php
require_once("include/conexion.php");

// Si se solicita detalle de una tarea específica
if (isset($_GET['detalle'])) {
    $id = $_GET['detalle'];
    $stmt = $mysqli->prepare("SELECT * FROM tareas WHERE id_tarea = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    echo json_encode($result->fetch_assoc());
    exit();
}

// Obtener todas las tareas para la tabla
$sql = "SELECT t.*, u.Nombre AS nombre_usuario 
        FROM tareas t
        LEFT JOIN usuarios u ON t.id_usuario = u.Id_usuario";
$result = $mysqli->query($sql);

if ($result && $result->num_rows > 0) {
    while ($tarea = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($tarea['titulo']) . "</td>
                <td>" . htmlspecialchars($tarea['descripcion']) . "</td>
                <td>" . htmlspecialchars($tarea['nombre_usuario']) . "</td>
                <td>" . htmlspecialchars($tarea['estado']) . "</td>
                <td>
                    <button class='btn btn-warning btn-sm btnEditarTarea' 
                            data-id='{$tarea['id_tarea']}'>Editar</button>
                    <button class='btn btn-danger btn-sm btnEliminarTarea' 
                            data-id='{$tarea['id_tarea']}'>Eliminar</button>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No hay tareas registradas</td></tr>";
}

$mysqli->close();
?>