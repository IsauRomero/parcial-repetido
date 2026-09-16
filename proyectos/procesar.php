<?php

session_start();

$cursos = require __DIR__ . "/datos.php";
require_once __DIR__ . "/funciones.php";


// ==========================================
// CREAR SESION DE PARTICIPANTES
// ==========================================

if (!isset($_SESSION["participantes"])) {
    $_SESSION["participantes"] = [];
}


$registro = [];
$errores = [];


// ==========================================
// VERIFICAR ENVIO POST
// ==========================================

if ($_SERVER["REQUEST_METHOD"] === "POST") {


    // ==========================================
    // RECIBIR DATOS
    // ==========================================

    $nombre = trim($_POST["nombre"] ?? "");

    $edad = trim($_POST["edad"] ?? "");

    $correo = trim($_POST["correo"] ?? "");

    $curso = trim($_POST["curso"] ?? "");

    $modalidad = trim($_POST["modalidad"] ?? "");

    $experiencia = trim($_POST["experiencia"] ?? "");

    $horasExtras = trim($_POST["horasExtras"] ?? "");



    // ==========================================
    // VALIDAR NOMBRE
    // ==========================================

    if (empty($nombre)) {

        $errores[] = "El nombre es obligatorio.";
    }



    // ==========================================
    // VALIDAR EDAD
    // ==========================================

    if ($edad === "") {

        $errores[] = "La edad es obligatoria.";

    } elseif (!is_numeric($edad)) {

        $errores[] = "La edad debe ser numerica.";

    } elseif ($edad < 16 || $edad > 60) {

        $errores[] =
            "La edad debe estar entre 16 y 60 años.";
    }



    // ==========================================
    // VALIDAR CORREO
    // ==========================================

    if (empty($correo)) {

        $errores[] = "El correo es obligatorio.";

    } elseif (
        !filter_var(
            $correo,
            FILTER_VALIDATE_EMAIL
        )
    ) {

        $errores[] =
            "El correo ingresado no es valido.";
    }



    // ==========================================
    // VALIDAR CURSO
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
    // VALIDAR MODALIDAD
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
            "La modalidad seleccionada no es valida.";
    }



    // ==========================================
    // VALIDAR EXPERIENCIA
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
            "El nivel seleccionado no es valido.";
    }



    // ==========================================
    // VALIDAR HORAS EXTRAS
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
    // SI LAS VALIDACIONES BASICAS ESTAN BIEN
    // ==========================================

    if (empty($errores)) {


        // Convertir datos
        $edad = (int)$edad;

        $horasExtras = (int)$horasExtras;



        // ======================================
        // OBTENER INFORMACION DEL CURSO
        // ======================================

        $cursoInfo = $cursos[$curso];



        // ======================================
        // CONTAR PARTICIPANTES DEL CURSO
        // ======================================

        $cantidadInscritos = 0;


        foreach (
            $_SESSION["participantes"]
            as $participante
        ) {

            if (
                $participante["cursoClave"]
                === $curso
            ) {

                $cantidadInscritos++;
            }
        }



        // ======================================
        // VALIDAR CUPO
        // ======================================

        if (
            $cantidadInscritos
            >= $cursoInfo["cupo"]
        ) {

            $errores[] =
                "El curso seleccionado ya no tiene cupos disponibles.";
        }
    }



    // ==========================================
    // SI TODAVIA NO EXISTEN ERRORES
    // ==========================================

    if (empty($errores)) {


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
        // CALCULAR CATEGORIA
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


            // Clave utilizada para comparar cupos
            "cursoClave" => $curso,


            // Datos reales del curso
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



        // ======================================
        // GUARDAR EN SESION
        // ======================================

        $_SESSION["participantes"][] =
            $registro;
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



    <!-- ==========================================
         MOSTRAR ERRORES
    =========================================== -->

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
            Volver al formulario
        </a>



    <!-- ==========================================
         SI TODO SALIO BIEN
    =========================================== -->

    <?php elseif (!empty($registro)): ?>


        <h2>
            Inscripcion realizada correctamente
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


        <br>


        <a href="index.php">
            Nueva inscripcion
        </a>


    <?php endif; ?>


</body>

</html>