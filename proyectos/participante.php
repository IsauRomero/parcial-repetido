<?php

session_start();


if (!isset($_SESSION["participantes"])) {

    $_SESSION["participantes"] = [];
}


$participantes =
    $_SESSION["participantes"];

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
        Participantes Registrados
    </title>

</head>

<body>


    <h1>
        Participantes Registrados
    </h1>


    <?php if (empty($participantes)): ?>


        <p>
            No hay participantes registrados.
        </p>


    <?php else: ?>


        <table border="1">

            <thead>

                <tr>

                    <th>Nombre</th>

                    <th>Edad</th>

                    <th>Correo</th>

                    <th>Curso</th>

                    <th>Codigo</th>

                    <th>Modalidad</th>

                    <th>Experiencia</th>

                    <th>Categoria</th>

                    <th>Total</th>

                </tr>

            </thead>


            <tbody>


                <?php foreach (
                    $participantes
                    as $participante
                ): ?>


                    <tr>


                        <td>
                            <?= htmlspecialchars(
                                $participante["nombre"]
                            ) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars(
                                (string)$participante["edad"]
                            ) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars(
                                $participante["correo"]
                            ) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars(
                                $participante["curso"]
                            ) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars(
                                $participante["codigo"]
                            ) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars(
                                ucfirst(
                                    $participante["modalidad"]
                                )
                            ) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars(
                                ucfirst(
                                    $participante["experiencia"]
                                )
                            ) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars(
                                $participante["categoria"]
                            ) ?>
                        </td>


                        <td>

                            $<?= number_format(
                                $participante["total"],
                                2
                            ) ?>

                        </td>


                    </tr>


                <?php endforeach; ?>


            </tbody>

        </table>


    <?php endif; ?>


    <br><br>


    <a href="index.php">
        Nueva Inscripcion
    </a>


</body>

</html>