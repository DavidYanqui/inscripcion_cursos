<?php
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}

// Verifica el rol del usuario
if ($_SESSION['id_roll'] !== 1) {
    echo "Acceso denegado. Solo los administradores pueden acceder a esta página.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estudiante</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap">
</head>
<body>
    <div class="sidebar">
        <h2>ESTUDIANTE</h2>
        <a href="../Home/estudiante.php">Inicio</a>
        <a href="../Crud/Inscripciones.php">Inscripciones</a>
        <a href="../Crud/Detalle.php">Detalle de los cursos</a>
        <a href="../InicioSesion/CerrarSesion.php">Cerrar sesión</a>
    </div>
    <div class="main">
        <h1>Bienvenido al usuario de Estudiante.</h1>

        <!-- Resumen de Actividades con Imagen -->
        <div class="card">
            <h3>Es el momento de avanzar</h3>
            <img src="../img/for.jpg" alt="Resumen de Actividades" style="width: 100%; height: auto; border-radius: 8px;">
        </div>

    </div>
</body>
</html>
