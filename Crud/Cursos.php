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

// Crear curso (INSERT)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $profesor_id = $_POST['profesor_id'];
    $alumno_id = $_POST['alumno_id'];

    $sql = "INSERT INTO curso (nombre, descripcion, fecha_inicio, fecha_fin, profesor_id_profesor, alumnos_id_alumnos) 
            VALUES ('$nombre', '$descripcion', '$fecha_inicio', '$fecha_fin', $profesor_id, $alumno_id)";

    if ($conn->query($sql) === TRUE) {
        echo "Nuevo curso creado con éxito";
         header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Editar curso (UPDATE)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar'])) {
    $id_curso = $_POST['id_curso'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $profesor_id = $_POST['profesor_id'];
    $alumno_id = $_POST['alumno_id'];

    $sql = "UPDATE curso SET nombre='$nombre', descripcion='$descripcion', fecha_inicio='$fecha_inicio', 
            fecha_fin='$fecha_fin', profesor_id_profesor=$profesor_id, alumnos_id_alumnos=$alumno_id 
            WHERE id_curso=$id_curso";

    if ($conn->query($sql) === TRUE) {
        echo "Curso actualizado con éxito";
        // Redirigir para limpiar el formulario
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Eliminar curso (DELETE)
if (isset($_GET['eliminar'])) {
    $id_curso = $_GET['eliminar'];
    $sql = "DELETE FROM curso WHERE id_curso=$id_curso";
    
    if ($conn->query($sql) === TRUE) {
        echo "Curso eliminado con éxito";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Obtener todos los profesores
$professors_sql = "SELECT id_profesor, nombre FROM profesor";
$professors_result = $conn->query($professors_sql);

// Obtener todos los alumnos
$students_sql = "SELECT id_alumnos, nombre_alumno FROM alumnos";
$students_result = $conn->query($students_sql);

// Obtener todos los cursos (SELECT)
$sql = "SELECT * FROM curso";
$result = $conn->query($sql);

// Si se pasa un ID de curso para editar, obtener los datos de ese curso
$edit_data = null;
if (isset($_GET['editar'])) {
    $id_curso = $_GET['editar'];
    $edit_query = "SELECT * FROM curso WHERE id_curso = $id_curso";
    $edit_result = $conn->query($edit_query);
    $edit_data = $edit_result->fetch_assoc();
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
<body>
    <div class="sidebar">
        <h2>ESTUDIANTE</h2>
        <a href="../Home/estudiante.php">Inicio</a>
        <a href="../Crud/Inscripciones.php">Inscripciones</a>
        <a href="../Crud/Cursos.php">Cursos</a>
        <a href="../Crud/Detalle.php">Detalle de los cursos</a>
        <a href="../InicioSesion/CerrarSesion.php">Cerrar sesión</a>
    </div>
    <div class="main">
        <h1>Crear y modifica los Cursos</h1>
        
        <!-- Formulario para crear o editar curso -->
        <div class="card">
            <h3><?php echo $edit_data ? 'Editar Curso' : 'Crear Curso'; ?></h3>
            <form action="" method="POST">
                <?php if ($edit_data): ?>
                    <input type="hidden" name="id_curso" value="<?php echo $edit_data['id_curso']; ?>">
                <?php endif; ?>

                <label for="nombre">Nombre del Curso:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $edit_data ? $edit_data['nombre'] : ''; ?>" required>
                
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" required><?php echo $edit_data ? $edit_data['descripcion'] : ''; ?></textarea>
                
                <label for="fecha_inicio">Fecha de Inicio:</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?php echo $edit_data ? $edit_data['fecha_inicio'] : ''; ?>" required>
                
                <label for="fecha_fin">Fecha de Fin:</label>
                <input type="date" id="fecha_fin" name="fecha_fin" value="<?php echo $edit_data ? $edit_data['fecha_fin'] : ''; ?>" required>
                
                <!-- Selección del Profesor -->
                <label for="profesor_id">Selecciona Profesor:</label>
                <select id="profesor_id" name="profesor_id" required>
                    <option value="">Seleccione un Profesor</option>
                    <?php
                    if ($professors_result->num_rows > 0) {
                        while($prof = $professors_result->fetch_assoc()) {
                            $selected = ($edit_data && $prof['id_profesor'] == $edit_data['profesor_id_profesor']) ? 'selected' : '';
                            echo "<option value='".$prof['id_profesor']."' $selected>".$prof['nombre']."</option>";
                        }
                    } else {
                        echo "<option value=''>No hay profesores disponibles</option>";
                    }
                    ?>
                </select>
                
                <!-- Selección del Alumno -->
                <label for="alumno_id">Selecciona Alumno:</label>
                <select id="alumno_id" name="alumno_id" required>
                    <option value="">Seleccione un Alumno</option>
                    <?php
                    if ($students_result->num_rows > 0) {
                        while($student = $students_result->fetch_assoc()) {
                            $selected = ($edit_data && $student['id_alumnos'] == $edit_data['alumnos_id_alumnos']) ? 'selected' : '';
                            echo "<option value='".$student['id_alumnos']."' $selected>".$student['nombre_alumno']."</option>";
                        }
                    } else {
                        echo "<option value=''>No hay alumnos disponibles</option>";
                    }
                    ?>
                </select>

                <button type="submit" name="<?php echo $edit_data ? 'editar' : 'crear'; ?>">
                    <?php echo $edit_data ? 'Actualizar Curso' : 'Crear Curso'; ?>
                </button>
            </form>
        </div>

        <!-- Mostrar cursos existentes -->
        <div class="card">
            <h3>Cursos Disponibles</h3>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Profesor</th>
                    <th>Alumno</th>
                    <th>Acciones</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        // Obtener nombre del profesor y alumno
                        $profesor_id = $row['profesor_id_profesor'];
                        $alumno_id = $row['alumnos_id_alumnos'];
                        
                        // Obtener nombres del profesor y alumno
                        $prof_name_query = "SELECT nombre FROM profesor WHERE id_profesor = $profesor_id";
                        $prof_name_result = $conn->query($prof_name_query);
                        $prof_name = $prof_name_result->fetch_assoc()['nombre'];

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
                                <td>
                                    <a href='?editar=".$row["id_curso"]."'>Editar</a> | 
                                    <a href='?eliminar=".$row["id_curso"]."'>Eliminar</a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No hay cursos registrados.</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>
