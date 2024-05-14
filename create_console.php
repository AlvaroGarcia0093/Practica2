<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear consola</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <?php require 'conexion.php' ?>
</head>

<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $temp_nombre = $_POST["nombre"];
        $temp_anyo = $_POST["anyo"];
        $temp_desarrollador = $_POST["desarrollador"];

        if (strlen($temp_nombre) == 0) {
            $err_nombre = "Campo obligatorio";
        } else {
            $nombre = $temp_nombre;
        }

        if (strlen($temp_anyo) == 0) {
            $err_anyo = "Campo obligatorio";
        } else if (!is_numeric($temp_anyo)) {
            $err_anyo = "Debe ser un valor numerico";
        } else if ($temp_anyo < 1950 || $temp_anyo > 2100) {
            $err_anyo = "El número debe ser entre 1950 y 2100";
        } else {
            $anyo = $temp_anyo;
        }

        if (strlen($temp_desarrollador) == 0) {
            $err_desarrollador = "Campo obligatorio";
        } else if (strlen($temp_desarrollador) > 20) {
            $err_desarrollador = "Debe tener menos de 20 caracteres";
        } else if (($temp_desarrollador != "Sega") and ($temp_desarrollador != "Sony") and ($temp_desarrollador != "Microsoft") and ($temp_desarrollador != "Nintendo")) {
            $err_desarrollador = "Debe de ser uno de los valores ya predefinidos";
            echo $temp_desarrollador;
        } else {
            $desarrollador = $temp_desarrollador;
        }

        if (isset($nombre) and (isset($anyo)) and (isset($desarrollador))) {
            $sql = "INSERT INTO consolas (nombre_consola, anyo_lanzamiento, desarrollador) values ('$nombre', '$anyo', '$desarrollador')";
            $conexion->query($sql);
            header("Location: index.php");
        }
    }
    ?>
    <form action="" method="post">
        <div class="mb-3">
            <label for="" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="" class="form-control">
            <b>
                <?php if (isset($err_nombre))
                    echo $err_nombre; ?>
            </b>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Año</label>
            <input type="text" name="anyo" id="" class="form-control">
            <b>
                <?php if (isset($err_anyo))
                    echo $err_anyo; ?>
            </b>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Desarrollador</label>
            <select name="desarrollador" id="" class="form-select">
                <option value="" selected disabled hidden></option>
                <option value="Sega">Sega</option>
                <option value="Nintendo">Nintendo</option>
                <option value="Sony">Sony</option>
                <option value="Microsoft">Microsoft</option>
            </select>
            <b>
                <?php if (isset($err_desarrollador))
                    echo $err_desarrollador ?>
                </b>
            </div>
            <a href="index.php"><input type="submit" class="btn btn-secondary" value="Crear"></a>
        </form>
        <a href="index.php" class="btn btn-secondary mt-4">Volver a inicio</a>
    </body>

    </html>