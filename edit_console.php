<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <?php require 'conexion.php' ?>
</head>

<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (isset($_GET["id_consola"])) {
            $id_consola = $_GET["id_consola"];
            $sql = $conexion->prepare("SELECT * FROM consolas WHERE id_consola = ?");
            $sql->bind_param("i", $id_consola);
            $sql->execute();

            $resultado = $sql->get_result();
            $fila = $resultado->fetch_assoc();



            $nombre = $fila["nombre_consola"];
            $anyo = $fila["anyo_lanzamiento"];
            $desarrollador = $fila["desarrollador"];


        }
    }
    ?>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_consola = $_POST["id_consola"];
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
        } else {
            $desarrollador = $temp_desarrollador;
        }

        if (isset($nombre) and (isset($anyo)) and (isset($desarrollador))) {
            $stmt = $conexion->prepare("UPDATE consolas SET nombre_consola=?, anyo_lanzamiento=?, desarrollador=? where id_consola = '$id_consola'");
            $stmt->bind_param("sis", $nombre, $anyo, $desarrollador);
            $stmt->execute();
            header("Location: index.php");
        }
    }
    ?>
    <h1>Editar consola</h1>
    <form action="" method="post">
        <label for="nombre" class="form-label">Nombre:</label>
        <input type="text" name="nombre" id="nombre" class="form-control" value="<?php if (isset($nombre))
            echo $nombre ?>">
            <b>
            <?php if (isset($err_nombre))
            echo $err_nombre ?>
            </b>
            <br>
            <label for="anyo" class="form-label">Año:</label>
            <input type="text" name="anyo" id="anyo" class="form-control" value="<?php if (isset($anyo))
            echo $anyo ?>">
            <b>
            <?php if (isset($err_anyo))
            echo $err_anyo ?>
            </b>
            <br>
            <label for="desarrollador" class="form-label">Desarrollador</label>
            <select id="" class="form-select" name="desarrollador">
                <option selected hidden value="<?php if (isset($desarrollador))
            echo $desarrollador ?>">
                <?php echo $desarrollador ?>
            </option>
            <option value="Sega">Sega</option>
            <option value="Nintendo">Nintendo</option>
            <option value="Sony">Sony</option>
            <option value="Microsoft">Microsoft</option>
        </select>
        <br>
        <b>
            <?php if (isset($err_desarrollador))
                echo $err_desarrollador ?>
            </b>
            <input type="hidden" name="id_consola" value="<?php if (isset($id_consola))
                echo $id_consola ?>">
            <a href="index.php"><input type="submit" value="Actualizar" class="btn btn-primary mt-2"></a>

        </form>
        <a href="index.php" class="btn btn-secondary mt-4">Volver a inicio</a>

    </body>

    </html>