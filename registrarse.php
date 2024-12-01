<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <!--CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Incluir SweetAlert desde un CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="wrapper">
        <div class="title">Registrarse</div>
        <form action="InicioSesion/registrarse.php" method="POST">
            
            <div class="field">
                <input type="text" id="nombres" name="nombre" required>
                <label for="username">Nombres completos</label>
            </div>
            <div class="field">
                <input type="text" id="apellidos" name="apellidos" required>
                <label for="username">Apellidos completos</label>
            </div>
            
            <div class="field">
                <input type="text" id="username" name="username" required>
                <label for="username">Usuario</label>
            </div>
            <div class="field">
                <input type="password" id="password" name="password" required>
                <label for="password">Contraseña</label>
            </div>
            <div class="field">
                <select id="id_roll" name="id_roll" required>
                    <option value="1">Estudiante</option>
                    <option value="2">Profesor</option>
                    <!-- Ajusta los valores según los roles disponibles en tu base de datos -->
                </select>
                <label for="id_roll">Roles</label>
            </div>
            <div class="field">
                <input type="submit" value="Registrar">
            </div>
            <div class="signup-link">
                ¿Ya tienes cuenta? <a href="index.php">Iniciar sesión</a>
            </div>
        </form>
    </div>
</body>

</html>
