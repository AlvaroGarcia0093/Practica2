<?php
    $_servidor = 'localhost';
    $_usuario = 'root';
    $_contrasena = 'medac';
    $_base_de_datos = 'db_consolas';

    $conexion = new mysqli($_servidor,$_usuario,$_contrasena,$_base_de_datos) or die('Error de conexion');
?>
