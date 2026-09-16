<?php

session_start();


// ==========================================
// VERIFICAR QUE EXISTA UN COMPROBANTE
// ==========================================

if (!isset($_SESSION["ultimoParticipante"])) {

    header("Location: index.php");
    exit;
}


$participante =
    $_SESSION["ultimoParticipante"];

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
        Comprobante de Inscripcion
    </title>

</head>

<body>


    <h1>
        Comprobante de Inscripcion
    </h1>


    <h2>
        Datos del participante
    </h2>


    <p>
        <strong>Nombre:</strong>

        <?= htmlspecialchars(
            $participante["nombre"]
        ) ?>
    </p>


    <p>
        <strong>Edad:</strong>

        <?= htmlspecialchars(
            (string)$participante["edad"]
        ) ?>
    </p>


    <p>
        <strong>Correo:</strong>

        <?= htmlspecialchars(
            $participante["correo"]
        ) ?>
    </p>


    <hr>


    <h2>
        Informacion del curso
    </h2>


    <p>
        <strong>Curso:</strong>

        <?= htmlspecialchars(
            $participante["curso"]
        ) ?>
    </p>


    <p>
        <strong>Codigo:</strong>

        <?= htmlspecialchars(
            $participante["codigo"]
        ) ?>
    </p>


    <p>
        <strong>Area:</strong>

        <?= htmlspecialchars(
            $participante["area"]
        ) ?>
    </p>


    <p>
        <strong>Modalidad:</strong>

        <?= htmlspecialchars(
            ucfirst(
                $participante["modalidad"]
            )
        ) ?>
    </p>


    <p>
        <strong>Nivel:</strong>

        <?= htmlspecialchars(
            ucfirst(
                $participante["experiencia"]
            )
        ) ?>
    </p>


    <p>
        <strong>Categoria:</strong>

        <?= htmlspecialchars(
            $participante["categoria"]
        ) ?>
    </p>


    <p>
        <strong>Horas Extras:</strong>

        <?= htmlspecialchars(
            (string)$participante["horasExtras"]
        ) ?>
    </p>


    <hr>


    <h2>
        Detalle del Pago
    </h2>


    <p>
        <strong>Precio del curso:</strong>

        $<?= number_format(
            $participante["precioCurso"],
            2
        ) ?>
    </p>


    <p>
        <strong>Costo horas extras:</strong>

        $<?= number_format(
            $participante["costoHoras"],
            2
        ) ?>
    </p>


    <p>
        <strong>Subtotal:</strong>

        $<?= number_format(
            $participante["subtotal"],
            2
        ) ?>
    </p>


    <p>
        <strong>Porcentaje de descuento:</strong>

        <?= number_format(
            $participante["porcentajeDescuento"] * 100,
            0
        ) ?>%
    </p>


    <p>
        <strong>Descuento:</strong>

        -$<?= number_format(
            $participante["descuento"],
            2
        ) ?>
    </p>


    <p>
        <strong>Cargo Administrativo:</strong>

        $<?= number_format(
            $participante["cargoAdministrativo"],
            2
        ) ?>
    </p>


    <hr>


    <h2>

        Total a pagar:

        $<?= number_format(
            $participante["total"],
            2
        ) ?>

    </h2>


    <br>


    <a href="index.php">
        Nueva Inscripcion
    </a>


    <br><br>


    <a href="participantes.php">
        Ver Participantes
    </a>


</body>

</html>