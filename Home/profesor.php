<?php
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['username']) || $_SESSION['id_roll'] != 2) { // Suponiendo que el rol de secretaria es 2
    header("Location: ../index.php");
    exit();
}

// Conectar a la base de datos
require_once '../Config/Conection.php';
$connection = new Connection();
$pdo = $connection->connect();

// Obtener la lista de usuarios
$sql  = "SELECT id_usuario, username FROM usuario";


$stmt = $pdo->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Profesor</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap">
</head>
<body>
    <div class="sidebar">
        <h2>PROFESOR</h2>
        <a href="../Home/profesor.php">Inicio</a>
        <a href="../Crud/Inscripciones.php">Inscripciones</a>
        <a href="../Crud/Cursos.php">Agregar Cursos</a>
        <a href="../Crud/Detalle.php">Detalle de los cursos</a>
        <a href="../InicioSesion/CerrarSesion.php">Cerrar sesión</a>
    </div>
    <div class="main">
        <h1>Bienvenido Al Usuario de Administrador De Cursos.</h1>

        <!-- Resumen de Actividades con Imagen -->
        <div class="card">
            <h3>Es el momento de crear</h3>
            <img src="../img/for.jpg" alt="Resumen de Actividades" style="width: 100%; height: auto; border-radius: 8px;">
        </div>

    </div>
</body>
</html>