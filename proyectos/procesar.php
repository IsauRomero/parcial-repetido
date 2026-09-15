<?php

$registro = [];
$errores = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    //Recibir y limpiar datos
    $nombre = trim($_POST["nombre"] ?? "");
    $edad = trim($_POST["edad"] ?? "");
    $correo = trim($_POST["correo"] ?? "");
    $curso = trim($_POST["curso"] ?? "");
    $modalidad = trim($_POST["modalidad"] ?? "");
    $experiencia = trim($_POST["experiencia"] ?? "");
    $horasExtras = trim($_POST["horasExtras"] ?? "");

    // VALIDACIONES

    //Nombre obligatorio
    if (empty($nombre)) {
        $errores[] = "El nombre es obligatorio.";
    }


    //Edad obligatoria y numérica
    if ($edad === "") {

        $errores[] = "La edad es obligatoria.";

    } elseif (!is_numeric($edad)) {

        $errores[] = "La edad debe ser numérica.";

    } elseif ($edad < 16 || $edad > 60) {

        $errores[] = "La edad debe estar entre 16 y 60 años.";
    }


    //Correo
    if (empty($correo)) {

        $errores[] = "El correo es obligatorio.";

    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {

        $errores[] = "El correo ingresado no es válido.";
    }


    //Curso
    if (empty($curso)) {
        $errores[] = "Debe seleccionar un curso.";
    }


    //Modalidad
    if (empty($modalidad)) {

        $errores[] = "Debe seleccionar una modalidad.";

    } elseif (!in_array($modalidad, ["presencial", "virtual"])) {

        $errores[] = "La modalidad seleccionada no es válida.";
    }


    //Experiencia
    if (empty($experiencia)) {

        $errores[] = "Debe seleccionar un nivel de experiencia.";

    } elseif (!in_array(
        $experiencia,
        ["principiante", "intermedio", "avanzado"]
    )) {

        $errores[] = "El nivel de experiencia no es válido.";
    }


    // Horas extras
    // No usamos empty() porque 0 sí es un valor válido
    if ($horasExtras === "") {

        $errores[] = "Debe ingresar las horas extras.";

    } elseif (!is_numeric($horasExtras)) {

        $errores[] = "Las horas extras deben ser numéricas.";

    } elseif ($horasExtras < 0 || $horasExtras > 5) {

        $errores[] = "Las horas extras deben estar entre 0 y 5.";
    }

    // SI NO HAY ERRORES

    if (empty($errores)) {

        $registro = [
            "nombre" => $nombre,
            "edad" => $edad,
            "correo" => $correo,
            "curso" => $curso,
            "modalidad" => $modalidad,
            "experiencia" => $experiencia,
            "horasExtras" => $horasExtras
        ];
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Procesar Inscripción</title>

</head>

<body>

    <h1>Procesar Inscripción</h1>


    <!-- ==========================================
    MOSTRAR ERRORES
    =========================================== -->

    <?php if (!empty($errores)): ?>

        <h2>Se encontraron los siguientes errores:</h2>

        <ul>

            <?php foreach ($errores as $error): ?>

                <li>
                    <?= htmlspecialchars($error) ?>
                </li>

            <?php endforeach; ?>

        </ul>

        <a href="index.php">
            Volver al formulario
        </a>


    <!-- ==========================================
         MOSTRAR DATOS SI TODO ESTÁ CORRECTO
    =========================================== -->

    <?php elseif (!empty($registro)): ?>

        <h2>Datos recibidos correctamente</h2>

        <?php foreach ($registro as $key => $value): ?>

            <p>

                <strong>
                    <?= htmlspecialchars($key) ?>:
                </strong>

                <?= htmlspecialchars($value) ?>

            </p>

        <?php endforeach; ?>

        <a href="index.php">
            Volver al formulario
        </a>

    <?php endif; ?>


</body>

</html>