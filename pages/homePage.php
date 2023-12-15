<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Ejercicios_UT6_1_Victor_Valdes_Cobos/libraries/functions/funciones.php';
session_start();


if($_SERVER["REQUEST_METHOD"]=="POST"){
    $miUsuario=unserialize(base64_decode($_POST["miUsuario"]));
    $miUsuario->actualizarPost($_POST);
}


if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"]=="POST" && comprobarLogin($tabla)) {
    crearInstanciaUsuario($miUsuario, $tabla);
    $miUsuario->actualizarSesion($_SESSION,$tabla);
} else if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"]=="POST") {
    switch (FuncionalidadPeliculas($funcionalidadID)) {
        case "anadirPelicula":
            anadirPelicula($maxIdPeliculas);
            break;
        case "modificarPelicula":
            modificarPelicula();
            break;
        case "eliminarPelicula":
            eliminarPeliculas($funcionalidadID);
            break;
        default:
            break;
    }
} else{
    //header('Location: ./pages/homepage.php?miUsuario='.$_POST["miUsuario"]);
}

?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <title>Iniciar Sesión - Videoclub</title>


        <!-- Agrega el enlace al archivo CSS de Bootstrap -->
        <!--===============================================================================================-->	
        <link rel="icon" type="image/png" href="../images/icons/favicon.ico"/>
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="../assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="../assets/fonts/iconic/css/material-design-iconic-font.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="../vendor/animate/animate.css">
        <!--===============================================================================================-->	
        <link rel="stylesheet" type="text/css" href="../vendor/css-hamburgers/hamburgers.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="../vendor/animsition/css/animsition.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="../vendor/select2/select2.min.css">
        <!--===============================================================================================-->	
        <link rel="stylesheet" type="text/css" href="../vendor/daterangepicker/daterangepicker.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="../css/util.css">
        <link rel="stylesheet" type="text/css" href="../css/main.css">
        <!--===============================================================================================-->


    </head>
    <body class="bg-dark">

        <div class="container mx-auto mt-5">

            <!-- Contenedor principal (main) -->
            <main class="container m-auto text-center">                 

                <?php 
                    //$miUsuario=unserialize(base64_decode($_POST["miUsuario"]));
                    if($_SERVER["REQUEST_METHOD"]=="GET") {
                        $miUsuario=unserialize(base64_decode($_GET["miUsuario"]));
                        //$miUsuario->actualizarSesion($_SESSION,$tabla);
                    }
                    $tabla=extraerTablas("SELECT * FROM PELICULAS");
                    if (!isset($arrPeliculas)) {
                        $arrPeliculas = crearInstanciasPelicula($tabla,$maxID);
                    }
                    unset($tabla);
                    echo entornoFormulario(imprimirTabla($arrPeliculas),array("usuario" => $miUsuario,"peliculas" => $arrPeliculas),$miUsuario,$maxID);
                    //echo modalAnadirPelicula();
                    
                ?>
                
            </main>
            <!-- Aquí va el contenido de tu página -->

        </div>
        <!-- Section: Design Block -->

    </div>

    <!--===============================================================================================-->
    <script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="../vendor/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="../vendor/bootstrap/js/popper.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="../vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="../vendor/daterangepicker/moment.min.js"></script>
    <script src="../vendor/daterangepicker/daterangepicker.js"></script>
    <!--===============================================================================================-->
    <script src="../vendor/countdowntime/countdowntime.js"></script>
    <!--===============================================================================================-->
    <script src="../js/main.js"></script>

</body>
</html>
