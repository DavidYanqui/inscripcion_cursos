<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root"; 
$password = "123456"; 
$dbname = "inscripcion_cursos";

$conn = new mysqli($servername, $username, $password, $dbname, 3307);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
// Establecer la zona horaria de Ecuador
date_default_timezone_set('America/Guayaquil');

// Crear inscripción (INSERT)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inscribir'])) {
    $id_alumno = $_POST['id_alumno'];
    $id_curso = $_POST['id_curso'];
    
    // La fecha actual del servidor
    $fecha_inscripcion = date('Y-m-d'); // Obtener la fecha actual en formato YYYY-MM-DD
    
    $estado = 1; // Estado activo de la inscripción

    // Verificar si el alumno ya está inscrito en el curso
    $check_sql = "SELECT * FROM inscripcion WHERE id_alumnos = $id_alumno AND id_curso = $id_curso";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        // Si el alumno ya está inscrito en el curso
        echo "<div class='message error'>El estudiante ya está inscrito en este curso.</div>";
    } else {
        // Si no está inscrito, insertar la inscripción
        $sql = "INSERT INTO inscripcion (fecha_inscripcion, estado, id_alumnos, id_curso) 
                VALUES ('$fecha_inscripcion', $estado, $id_alumno, $id_curso)";

        if ($conn->query($sql) === TRUE) {
            echo "<div class='message success'>Inscripción realizada con éxito.</div>";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            echo "<div class='message error'>Error: " . $conn->error . "</div>";
        }
    }
}

// Eliminar inscripción (DELETE)
if (isset($_GET['eliminar'])) {
    $id_inscripcion = $_GET['eliminar'];
    $sql = "DELETE FROM inscripcion WHERE id_inscripcion=$id_inscripcion";
    
    if ($conn->query($sql) === TRUE) {
        echo "<div class='message success'>Inscripción eliminada con éxito.</div>";
    } else {
        echo "<div class='message error'>Error: " . $conn->error . "</div>";
    }
}

// Obtener todos los cursos
$curso_sql = "SELECT id_curso, nombre FROM curso";
$curso_result = $conn->query($curso_sql);

// Obtener todos los alumnos
$alumno_sql = "SELECT id_alumnos, nombre_alumno FROM alumnos";
$alumno_result = $conn->query($alumno_sql);

// Obtener todas las inscripciones
$inscripcion_sql = "SELECT * FROM inscripcion";
$inscripcion_result = $conn->query($inscripcion_sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscripción a Cursos</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap">
        <style>
        /* Fuentes generales */
 body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        /* Contenedor principal */
        .main {
            margin-left: 270px;
            padding: 40px;
        }

        /* Estilo de los encabezados y cards */
        h1, h3 {
            color: #2c3e50;
        }

        .card {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .card h3 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        /* Estilo del formulario */
        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        form input, form select, form textarea {
            padding: 12px;
            font-size: 16px;
            border: 2px solid #ccc;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        form input:focus, form select:focus, form textarea:focus {
            border-color: #3498db;
            outline: none;
        }

        form textarea {
            resize: vertical;
            min-height: 120px;
        }

        form button {
            padding: 12px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        form button:hover {
            background-color: #2980b9;
        }

        /* Estilos para la tabla de cursos */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f4f7fc;
            color: #2c3e50;
        }

        table td {
            background-color: #fff;
        }

        table a {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        table a:hover {
            color: #2980b9;
        }

        table tr:hover {
            background-color: #ecf0f1;
        }

        /* Estilo de mensaje */
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-size: 16px;
            color: #fff;
        }

        .message.success {
            background-color: #2ecc71;
        }

        .message.error {
            background-color: #e74c3c;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>INSCRIPCIONES</h2>
        <a href="../Home/estudiante.php">Inicio</a>
        <a href="../Crud/Inscripciones.php">Inscripciones</a>
        <a href="../Crud/Cursos.php">Cursos</a>
        <a href="../Crud/Detalle.php">Detalle de los cursos</a>
        <a href="../InicioSesion/CerrarSesion.php">Cerrar sesión</a>
    </div>
    <div class="main">
        <h1>Inscribirse a Cursos</h1>

        <!-- Formulario para realizar la inscripción -->
        <div class="card">
            <h3>Realizar Inscripción</h3>
            <form action="" method="POST" id="form-inscripcion">
                <label for="id_alumno">Selecciona Alumno:</label>
                <select id="id_alumno" name="id_alumno" required>
                    <option value="">Seleccione un Alumno</option>
                    <?php
                    if ($alumno_result->num_rows > 0) {
                        while ($alumno = $alumno_result->fetch_assoc()) {
                            echo "<option value='".$alumno['id_alumnos']."'>".$alumno['nombre_alumno']."</option>";
                        }
                    } else {
                        echo "<option value=''>No hay alumnos disponibles</option>";
                    }
                    ?>
                </select>

                <label for="id_curso">Selecciona Curso:</label>
                <select id="id_curso" name="id_curso" required>
                    <option value="">Seleccione un Curso</option>
                    <?php
                    if ($curso_result->num_rows > 0) {
                        while ($curso = $curso_result->fetch_assoc()) {
                            echo "<option value='".$curso['id_curso']."'>".$curso['nombre']."</option>";
                        }
                    } else {
                        echo "<option value=''>No hay cursos disponibles</option>";
                    }
                    ?>
                </select>

                <button type="button" id="confirmarInscripcion">Inscribir</button>
            </form>
        </div>

        <!-- Mostrar inscripciones existentes -->
        <div class="card">
            <h3>Inscripciones Existentes</h3>
            <table>
                <tr>
                    <th>ID Inscripción</th>
                    <th>Alumno</th>
                    <th>Curso</th>
                    <th>Fecha Inscripción</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
                <?php
                if ($inscripcion_result->num_rows > 0) {
                    while ($inscripcion = $inscripcion_result->fetch_assoc()) {
                        // Obtener nombre del alumno y curso
                        $alumno_id = $inscripcion['id_alumnos'];
                        $curso_id = $inscripcion['id_curso'];

                        // Obtener nombre del alumno
                        $alumno_name_query = "SELECT nombre_alumno FROM alumnos WHERE id_alumnos = $alumno_id";
                        $alumno_name_result = $conn->query($alumno_name_query);
                        $alumno_name = $alumno_name_result->fetch_assoc()['nombre_alumno'];

                        // Obtener nombre del curso
                        $curso_name_query = "SELECT nombre FROM curso WHERE id_curso = $curso_id";
                        $curso_name_result = $conn->query($curso_name_query);
                        $curso_name = $curso_name_result->fetch_assoc()['nombre'];

                        // Estado de la inscripción
                        $estado = ($inscripcion['estado'] == 1) ? 'Activo' : 'Inactivo';

                        echo "<tr>
                                <td>".$inscripcion['id_inscripcion']."</td>
                                <td>".$alumno_name."</td>
                                <td>".$curso_name."</td>
                                <td>".$inscripcion['fecha_inscripcion']."</td>
                                <td>".$estado."</td>
                                <td><a href='?eliminar=".$inscripcion['id_inscripcion']."'>Eliminar</a></td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No hay inscripciones registradas.</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>

    <script>
        // Confirmar inscripción antes de enviar el formulario
        document.getElementById('confirmarInscripcion').addEventListener('click', function() {
            var form = document.getElementById('form-inscripcion');
            var alumno = document.getElementById('id_alumno').value;
            var curso = document.getElementById('id_curso').value;

            if (alumno === '' || curso === '') {
                alert('Por favor, seleccione un alumno y un curso.');
                return;
            }

            // Mostrar confirmación
            var confirmacion = confirm('¿Estás seguro de que deseas inscribir al alumno en este curso?');

            if (confirmacion) {
                form.submit(); // Enviar el formulario si el usuario confirma
            }
        });
    </script>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>
