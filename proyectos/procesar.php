<?php

$cursos = require __DIR__ . "/datos.php";

require_once __DIR__ . "/funciones.php";

$registro = [];
$errores = [];


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // ==========================================
    // RECIBIR DATOS
    // ==========================================

    $nombre =
        trim($_POST["nombre"] ?? "");

    $edad =
        trim($_POST["edad"] ?? "");

    $correo =
        trim($_POST["correo"] ?? "");

    $curso =
        trim($_POST["curso"] ?? "");

    $modalidad =
        trim($_POST["modalidad"] ?? "");

    $experiencia =
        trim($_POST["experiencia"] ?? "");

    $horasExtras =
        trim($_POST["horasExtras"] ?? "");


    // ==========================================
    // VALIDACIONES
    // ==========================================

    if (empty($nombre)) {

        $errores[] =
            "El nombre es obligatorio.";
    }


    if ($edad === "") {

        $errores[] =
            "La edad es obligatoria.";

    } elseif (!is_numeric($edad)) {

        $errores[] =
            "La edad debe ser numerica.";

    } elseif ($edad < 16 || $edad > 60) {

        $errores[] =
            "La edad debe estar entre 16 y 60 años.";
    }


    if (empty($correo)) {

        $errores[] =
            "El correo es obligatorio.";

    } elseif (
        !filter_var(
            $correo,
            FILTER_VALIDATE_EMAIL
        )
    ) {

        $errores[] =
            "El correo no es valido.";
    }


    // ==========================================
    // VALIDAR QUE EL CURSO EXISTA
    // ==========================================

    if (empty($curso)) {

        $errores[] =
            "Debe seleccionar un curso.";

    } elseif (
        !array_key_exists($curso, $cursos)
    ) {

        $errores[] =
            "El curso seleccionado no existe.";
    }


    // ==========================================
    // MODALIDAD
    // ==========================================

    if (empty($modalidad)) {

        $errores[] =
            "Debe seleccionar una modalidad.";

    } elseif (
        !in_array(
            $modalidad,
            ["presencial", "virtual"]
        )
    ) {

        $errores[] =
            "La modalidad no es valida.";
    }


    // ==========================================
    // EXPERIENCIA
    // ==========================================

    if (empty($experiencia)) {

        $errores[] =
            "Debe seleccionar un nivel.";

    } elseif (
        !in_array(
            $experiencia,
            [
                "principiante",
                "intermedio",
                "avanzado"
            ]
        )
    ) {

        $errores[] =
            "El nivel no es valido.";
    }


    // ==========================================
    // HORAS EXTRAS
    // ==========================================

    if ($horasExtras === "") {

        $errores[] =
            "Debe ingresar las horas extras.";

    } elseif (!is_numeric($horasExtras)) {

        $errores[] =
            "Las horas extras deben ser numericas.";

    } elseif (
        $horasExtras < 0 ||
        $horasExtras > 5
    ) {

        $errores[] =
            "Las horas extras deben estar entre 0 y 5.";
    }


    // ==========================================
    // SI TODO ESTA CORRECTO
    // ==========================================

    if (empty($errores)) {

        // Convertimos valores
        $edad = (int)$edad;
        $horasExtras = (int)$horasExtras;


        // ======================================
        // OBTENER DATOS DEL CURSO
        // ======================================

        $cursoInfo = $cursos[$curso];


        // ======================================
        // CALCULAR PAGO
        // ======================================

        $pago = calcularPago(
            (float)$cursoInfo["precio"],
            $modalidad,
            $experiencia,
            $horasExtras
        );


        // ======================================
        // CATEGORIA
        // ======================================

        $categoria = match (true) {

            $edad < 18
                => "Junior",

            $experiencia === "principiante"
                => "Principiante",

            $experiencia === "intermedio"
                => "Tecnico",

            $experiencia === "avanzado"
                => "Especialista",

            default
                => "Sin categoria"
        };


        // ======================================
        // CREAR REGISTRO
        // ======================================

        $registro = [

            "nombre" => $nombre,

            "edad" => $edad,

            "correo" => $correo,

            "curso" =>
                $cursoInfo["nombre"],

            "codigo" =>
                $cursoInfo["codigo"],

            "area" =>
                $cursoInfo["area"],

            "modalidad" =>
                $modalidad,

            "experiencia" =>
                $experiencia,

            "categoria" =>
                $categoria,

            "horasExtras" =>
                $horasExtras,

            "precioCurso" =>
                $pago["precioOriginal"],

            "costoHoras" =>
                $pago["costoHoras"],

            "subtotal" =>
                $pago["subtotal"],

            "porcentajeDescuento" =>
                $pago["porcentajeDescuento"],

            "descuento" =>
                $pago["descuento"],

            "cargoAdministrativo" =>
                $pago["cargoAdministrativo"],

            "total" =>
                $pago["total"]
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

    <title>
        Procesar Inscripcion
    </title>

</head>

<body>

    <h1>
        Resultado de Inscripcion
    </h1>


    <?php if (!empty($errores)): ?>

        <h2>
            Errores encontrados
        </h2>

        <ul>

            <?php foreach ($errores as $error): ?>

                <li>
                    <?= htmlspecialchars($error) ?>
                </li>

            <?php endforeach; ?>

        </ul>


        <a href="index.php">
            Volver
        </a>


    <?php elseif (!empty($registro)): ?>

        <h2>
            Inscripcion correcta
        </h2>


        <?php foreach ($registro as $key => $value): ?>

            <p>

                <strong>
                    <?= htmlspecialchars($key) ?>:
                </strong>

                <?= htmlspecialchars(
                    (string)$value
                ) ?>

            </p>

        <?php endforeach; ?>


        <a href="index.php">
            Nueva inscripcion
        </a>

    <?php endif; ?>

</body>

</html>