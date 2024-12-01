<?php
require_once '../config/conection.php';

if ($_SERVER['REQUEST_METHOD']=== 'POST'){
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $username =$_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $id_roll = $_POST['id_roll'];
    
    try{
        $connection = new Connection();
        $pdo = $connection->connect();
        
        $sql = "INSERT INTO usuario (nombre, apellido, username, password, id_roll) VALUES (:nombre, :apellido, :username, :password, :id_roll)";
            
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute([
            'nombre' => $nombre,
            'apellido' => $apellido,
            'username' => $username,
            'password' => $password,
            'id_roll' => $id_roll,
        ]);
        
     echo "<script>
        alert('Usuario registrado correctamente.');
        window.location.href = '../index.php';
        </script>";
        
    } catch (\Throwable $th) {
        // Capturar errores y mostrar mensaje de error
        echo "<script>
        alert('Error al registrar el usuario: " . htmlspecialchars($th->getMessage()) . "');
        </script>";
    }
}
?>
