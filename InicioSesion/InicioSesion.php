<?php

require_once '../config/conection.php';
session_start();

$error_message = ''; // Inicializamos la variable para manejar errores

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Establecemos la conexión a la base de datos
        $connection = new Connection();
        $pdo = $connection->connect();

        // Preparamos la consulta para obtener el usuario
        $sql = "SELECT * FROM usuario WHERE username = :username";
        $stsm = $pdo->prepare($sql);
        $stsm->execute(['username' => $username]);
        $user = $stsm->fetch(PDO::FETCH_ASSOC);

        if ($password === $user['password']) {
                // Asignamos las variables de sesión
                $_SESSION['id_usuario'] = $user['id_usuario'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['id_roll'] = $user['id_roll'];

            // Redirigimos según el rol del estudiante 1, profesor 2
            if ($user['id_roll'] == 1) {
                header('Location: ../Home/estudiante.php');
                exit();  // Detenemos la ejecución después de la redirección
            } elseif ($user['id_roll'] == 2) {
                header('Location: ../Home/profesor.php');
                exit();  // Detenemos la ejecución después de la redirección
            } else {
                echo 'Acceso Denegado'; // En caso de que el rol no sea válido
                exit();
            }
        } else {
            // Si las credenciales son incorrectas
            $error_message = 'Credenciales Incorrectas';
        }
    } catch (\Throwable $th) {
        // Si hay un error de conexión
        $error_message = "Error de Conexión: " . $th->getMessage();
    }
}

// Si hay un mensaje de error, lo mostramos
if (!empty($error_message)) {
    echo '<div class="error-message">' . $error_message . '</div>';
}

?>















