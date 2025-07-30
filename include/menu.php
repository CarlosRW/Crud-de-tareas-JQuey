<?php
$base_url = '/Crud-de-tareas-JQuey'; // Ajusta esto según tu configuración
?>

<aside class="col-md-3 bg-dark text-white p-4">
    <h4 class="mb-4">Menú</h4>
    <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link text-white" href="<?php echo $base_url; ?>/home.php">Inicio</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="<?php echo $base_url; ?>/usuarios.php">Usuarios</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="<?php echo $base_url; ?>/control_tareas_jq/tareas.php">Tareas</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#">Reportes</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#">Configuración</a></li>
    </ul>
    <form action="<?php echo $base_url; ?>/include/logout.php" method="post" class="mt-4">
        <button type="submit" class="btn btn-danger w-100">Cerrar sesión</button>
    </form>
</aside>