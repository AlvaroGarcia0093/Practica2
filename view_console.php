<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver consola</title>
    <?php require "conexion.php" ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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


        } else
            (header("Location: index.php"));
    }
    ?>
    <table class="table">
        <tr>
            <th>Nombre</th>
            <th>Año</th>
            <th>Desarrollador</th>
        </tr>
        <tr>
            <td><?php if (isset($nombre))
                echo $nombre; ?></td>
            <td><?php if (isset($anyo))
                echo $anyo; ?></td>
            <td><?php if (isset($desarrollador))
                echo $desarrollador; ?></td>
        </tr>
    </table>

    <a href="index.php" class="btn btn-secondary">Volver a inicio</a>
    <br><br>
    <form action="edit_console.php" method="get" class="mb-3">
        <input type="hidden" name="id_consola" value="<?php echo $fila['id_consola'] ?>">
        <input type="submit" value="Editar" class="btn btn-primary">
    </form>
</body>

</html>