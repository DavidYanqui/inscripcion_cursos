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

// Obtener todos los cursos (SELECT)
$sql = "SELECT * FROM curso";
$result = $conn->query($sql);

// Obtener todos los profesores
$professors_sql = "SELECT id_profesor, nombre FROM profesor";
$professors_result = $conn->query($professors_sql);

// Obtener todos los alumnos
$students_sql = "SELECT id_alumnos, nombre_alumno FROM alumnos";
$students_result = $conn->query($students_sql);

// Cerrar la conexión después de las consultas
// Si hay más consultas adicionales, deberías ejecutarlas antes de llegar a esta línea.
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Cursos</title>
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
        <h2>CURSOS</h2>
        <a href="../Home/estudiante.php">Inicio</a>
        <a href="../Crud/Inscripciones.php">Inscripciones</a>
        <a href="../Crud/Cursos.php">Cursos</a>
        <a href="../Crud/Detalle.php">Detalle de los cursos</a>
        <a href="../InicioSesion/CerrarSesion.php">Cerrar sesión</a>
    </div>

    <div class="main">
        <h1>Ver Cursos</h1>

        <!-- Mostrar cursos existentes -->
        <div class="card">
            <h3>Ver Detalle de Cursos Disponibles</h3>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Profesor</th>
                    <th>Alumno</th>
                </tr>
                <?php
                // Asegúrate de ejecutar todas las consultas antes de cerrar la conexión
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        // Obtener nombre del profesor y alumno
                        $profesor_id = $row['profesor_id_profesor'];
                        $alumno_id = $row['alumnos_id_alumnos'];

                        // Reabrir la conexión para las consultas de nombres, ya que se cerró antes
                        $conn = new mysqli($servername, $username, $password, $dbname, 3307);

                        // Obtener nombre del profesor
                        $prof_name_query = "SELECT nombre FROM profesor WHERE id_profesor = $profesor_id";
                        $prof_name_result = $conn->query($prof_name_query);
                        $prof_name = $prof_name_result->fetch_assoc()['nombre'];

                        // Obtener nombre del alumno
                        $alumno_name_query = "SELECT nombre_alumno FROM alumnos WHERE id_alumnos = $alumno_id";
                        $alumno_name_result = $conn->query($alumno_name_query);
                        $alumno_name = $alumno_name_result->fetch_assoc()['nombre_alumno'];

                        echo "<tr>
                                <td>".$row["id_curso"]."</td>
                                <td>".$row["nombre"]."</td>
                                <td>".$row["descripcion"]."</td>
                                <td>".$row["fecha_inicio"]."</td>
                                <td>".$row["fecha_fin"]."</td>
                                <td>".$prof_name."</td>
                                <td>".$alumno_name."</td>
                            </tr>";

                        // Cierra la conexión después de cada consulta adicional
                        $conn->close();
                    }
                } else {
                    echo "<tr><td colspan='7'>No hay cursos registrados.</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>

