<?php
    $cadena_conexion = 'mysql:dbname=videoclubonline;host=localhost';
    $username = 'root';
    $password = '';

function conexionPDO(){
    global $cadena_conexion,$username,$password;
    return new PDO($cadena_conexion, $username, $password);
}

function nullPDO(){
    $BD = null;
}
