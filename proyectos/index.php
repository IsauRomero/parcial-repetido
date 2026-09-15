<?php

$cursos = [
    "php" => [
        "nombre" => "Desarrollo Web con PHP",
        "area" => "Programacion",
        "codigo" => "PHP01",
        "precio" => 10.00,
        "cupo" => 10
    ],

    "postgresql" => [
        "nombre" => "Fundamentos de PostgreSQL",
        "area" => "Base de Datos",
        "codigo" => "BD02",
        "precio" => 8.00,
        "cupo" => 8
    ],

    "redes" => [
        "nombre" => "Introduccion a Redes",
        "area" => "Infraestructura",
        "codigo" => "RD03",
        "precio" => 9.00,
        "cupo" => 12
    ],

    "git" => [
        "nombre" => "Git y GitHub",
        "area" => "Herramientas",
        "codigo" => "GIT04",
        "precio" => 7.00,
        "cupo" => 15
    ]
];

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Inscripcion de Cursos</title>
</head>

<body>

    <h1>Inscripcion de Cursos Tecnologicos</h1>

    <form action="procesar.php" method="POST">

        <label>Nombre</label>
        <br>

        <input
            type="text"
            name="nombre"
        >

        <br><br>


        <label>Edad</label>
        <br>

        <input
            type="number"
            name="edad"
        >

        <br><br>


        <label>Correo</label>
        <br>

        <input
            type="email"
            name="correo"
        >

        <br><br>


        <label>Curso</label>
        <br>

        <select name="curso">

            <option value="">
                --- Seleccione un curso ---
            </option>

            <?php foreach ($cursos as $key => $curso): ?>

                <option value="<?= htmlspecialchars($key) ?>">

                    <?= htmlspecialchars($curso["nombre"]) ?>

                    -

                    <?= htmlspecialchars($curso["area"]) ?>

                    -

                    $<?= number_format($curso["precio"], 2) ?>

                </option>

            <?php endforeach; ?>

        </select>

        <br><br>


        <label>Modalidad</label>
        <br>

        <select name="modalidad">

            <option value="">
                --- Seleccione una modalidad ---
            </option>

            <option value="presencial">
                Presencial
            </option>

            <option value="virtual">
                Virtual
            </option>

        </select>

        <br><br>


        <label>Nivel de Experiencia</label>
        <br>

        <select name="experiencia">

            <option value="">
                --- Seleccione su nivel ---
            </option>

            <option value="principiante">
                Principiante
            </option>

            <option value="intermedio">
                Intermedio
            </option>

            <option value="avanzado">
                Avanzado
            </option>

        </select>

        <br><br>


        <label>Horas Extras</label>
        <br>

        <input
            type="number"
            name="horasExtras"
            min="0"
            max="5"
        >

        <br><br>


        <button type="submit">
            Registrar
        </button>

    </form>

</body>

</html>