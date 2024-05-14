<?php 
    require 'conexion.php';

    if($_SERVER["REQUEST_METHOD"] == "GET"){
        $id_consola = $_GET["id_consola"];
        $sql = $conexion->prepare("DELETE FROM consolas where id_consola = ?");
        $sql ->bind_param("s", $id_consola);
        $sql->execute();    
        header("Location: index.php");
    }
?>