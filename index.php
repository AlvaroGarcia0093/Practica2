<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <?php require "conexion.php" ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <?php
    $sql = "";
    if (isset($_POST['buscar']) && isset($_POST['bDesa']) && isset($_POST['fecha1']) && isset($_POST['fecha2']) && !empty($_POST['bDesa']) && !empty($_POST['buscar']) && !empty($_POST['fecha1']) && !empty($_POST['fecha2'])) {
        $bDesa = '%' . strtolower($_POST['bDesa']) . '%';
        $buscar = '%' . strtolower($_POST['buscar']) . '%';
        $fecha1 = $_POST['fecha1'];
        $fecha2 = $_POST['fecha2'];
        $sql = $conexion->prepare("SELECT * FROM consolas WHERE LOWER(nombre_consola) LIKE ? AND LOWER(desarrollador) LIKE ? AND anyo_lanzamiento between ? AND ?");
        $sql->bind_param("ssii", $buscar, $bDesa, $fecha1, $fecha2);
        $sql->execute();
        $resultado = $sql->get_result();
    } else if (isset($_POST["buscar"]) && isset($_POST["bDesa"]) && !empty($_POST['buscar']) && !empty($_POST['bDesa'])) {
        $bDesa = '%' . strtolower($_POST['bDesa']) . '%';
        $buscar = '%' . strtolower($_POST['buscar']) . '%';
        $sql = $conexion->prepare("SELECT * FROM consolas WHERE LOWER(nombre_consola) LIKE ? AND LOWER(desarrollador) LIKE ?");
        $sql->bind_param("ss", $buscar, $bDesa);
        $sql->execute();
        $resultado = $sql->get_result();
    } else if (isset($_POST["fecha1"]) && isset($_POST["bDesa"]) && isset($_POST['fecha2']) && !empty($_POST['fecha1']) && !empty($_POST['bDesa']) && !empty($_POST['fecha2'])) {
        $bDesa = '%' . strtolower($_POST['bDesa']) . '%';
        $fecha1 = $_POST['fecha1'];
        $fecha2 = $_POST['fecha2'];
        $sql = $conexion->prepare("SELECT * FROM consolas WHERE LOWER(desarrollador) LIKE ? AND anyo_lanzamiento between ? AND ?");
        $sql->bind_param("sii", $bDesa, $fecha1, $fecha2);
        $sql->execute();
        $resultado = $sql->get_result();
    } else if (isset($_POST["fecha1"]) && isset($_POST["buscar"]) && isset($_POST['fecha2']) && !empty($_POST['buscar']) && !empty($_POST['fecha1']) && !empty($_POST['fecha2'])) {
        $buscar = '%' . strtolower($_POST['buscar']) . '%';
        $fecha1 = $_POST['fecha1'];
        $fecha2 = $_POST['fecha2'];
        $sql = $conexion->prepare("SELECT * FROM consolas WHERE LOWER(nombre_consola) LIKE ? AND anyo_lanzamiento between ? AND ?");
        $sql->bind_param("sii", $buscar, $fecha1, $fecha2);
        $sql->execute();
        $resultado = $sql->get_result();
    } else if (isset($_POST['bDesa']) && !empty($_POST['bDesa'])) {
        $bDesa = '%' . strtolower($_POST['bDesa']) . '%';
        $sql = $conexion->prepare("SELECT * FROM consolas WHERE LOWER(desarrollador) LIKE ?");
        $sql->bind_param("s",$bDesa);
        $sql->execute();
        $resultado = $sql->get_result();
    } else if (isset($_POST["buscar"]) && !empty($_POST['buscar'])) {
        $buscar = '%' . strtolower($_POST['buscar']) . '%';
        $sql = $conexion->prepare("SELECT * FROM consolas WHERE LOWER(nombre_consola) LIKE ?");
        $sql->bind_param("s", $buscar);
        $sql->execute();
        $resultado = $sql->get_result();
    } else if (isset($_POST['fecha1']) && isset($_POST['fecha2']) && !empty($_POST['fecha1']) && !empty($_POST['fecha2'])) {
        $fecha1 = (int)$_POST['fecha1'];
        $fecha2 = (int)$_POST['fecha2'];
        
        if ($fecha1 < $fecha2) {
            $sql = $conexion->prepare("SELECT * FROM consolas WHERE anyo_lanzamiento between ? AND ?");
            $sql->bind_param("ii", $fecha1, $fecha2);
            $sql->execute();
            $resultado = $sql->get_result();
        } else {
            //$fecha2 = $error_fecha;
            $error_fecha = "Hola";
        }
    } else {
        $sql = $conexion->prepare("SELECT * FROM consolas");
        $sql->execute();
        $resultado = $sql->get_result();
    }

    if (isset($_POST['orden']) && ($_POST['orden'] == 'ASC' || $_POST['orden'] == 'DESC')) {
        $sql = $conexion->prepare("SELECT * FROM consolas ORDER BY LOWER(nombre_consola) " . ($_POST['orden']));
        $sql->execute();
        $resultado = $sql->get_result();
    }
    

    ?>
    <form action="" method="POST">
        <div class="buscar">
            <h1>Buscar</h1>
            <input type="text" name="buscar" id="buscar" class="form-control" placeholder="Nombre"><br>
            <select name="bDesa" id="" class="form-select" placeholder="Desarrollador">
                <option value="Desarrollador" selected disabled hidden placeholder="">Desarrollador</option>
                <option value="Sega">Sega</option>
                <option value="Nintendo">Nintendo</option>
                <option value="Sony">Sony</option>
                <option value="Microsoft">Microsoft</option>
            </select>
            <br>
            <input type="number" name="fecha1" id="fecha1" class="form-control" placeholder="Desde">
            <input type="number" name="fecha2" id="fecha2" class="form-control" placeholder="Hasta">
            <?php if(isset($error_fecha)) echo $error_fecha;?>
            <br>
            <label for="orden">Ordenar por nombre:</label><br>
            <input type="radio" id="asc" name="orden" value="ASC" class="form-check-input">
            <label for="asc">A-Z</label><br>
            <input type="radio" id="desc" name="orden" value="DESC" class="form-check-input">
            <label for="desc">Z-A</label>
            <br>
            <br>
        </div>
        <input type="submit" value="Ver" class="btn btn-primary">
        <a href="index.php" class="btn btn-secondary">Volver al inicio</a>
    </form>
    <table class="table">
        <tr>
            <th>Nombre</th>
            <th>Año</th>
            <th>Desarrollador</th>
            <th></th>
            <th></th>
        </tr>


        <?php while ($fila = $resultado->fetch_assoc()) { ?>
            <tr>
                <td>
                    <?php echo $fila["nombre_consola"] ?>
                </td>
                <td>
                    <?php echo $fila["anyo_lanzamiento"] ?>
                </td>
                <td>
                    <?php echo $fila["desarrollador"] ?>
                </td>
                <td>
                    <form action="view_console.php" method="get" class="mb-3">
                        <input type="hidden" name="id_consola" value="<?php echo $fila['id_consola'] ?>">
                        <input type="submit" value="Ver" class="btn btn-primary">
                    </form>
                </td>
                <td>
                    <form action="delete_console.php" method="get" class="mb-3">
                        <input type="hidden" name="id_consola" value="<?php echo $fila['id_consola'] ?>">
                        <input type="submit" value="Borrar" class="btn btn-danger">
                    </form>
                </td>
            </tr>
            <?php
        }
        ;
        ?>
    </table>
    <a href="create_console.php" class="btn btn-primary">Crear consola</a>
</body>

</html>
