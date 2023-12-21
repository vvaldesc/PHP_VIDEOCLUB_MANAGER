<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Ejercicios_UT6_1_Victor_Valdes_Cobos/libraries/functions/funciones.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Ejercicios_UT6_1_Victor_Valdes_Cobos/templates/funcionesTemplate.php';

    
    session_start();
    if (isset($_POST["miUsuario"])) {
        $miUsuario = unserialize(base64_decode($_POST["miUsuario"]));
        $miUsuario->actualizarPost($_POST);
        $miUsuario->actualizarSesion($_SESSION,false);
    }   else{
        $_POST["password"]=hash('sha256', $_POST['password']);
    }
    if ($_SERVER["REQUEST_METHOD"]==="POST" && comprobarLogin($tabla)) {
        isset($_POST["miUsuario"]) ? gestionarFuncionalidad() : crearInstanciaUsuario($miUsuario, $tabla, $_SESSION);
        unset($password,$tabla);
        if (isset($_POST["miUsuario"])) unset ($_POST["miUsuario"]);
        if (isset($_POST["password"])) unset ($_POST["password"]);
        if (isset($_POST["usr"])) unset ($_POST["usr"]);
    } else{
        crearInstanciaLogError($_POST["usr"]);
        $url = '../index.php?formError=true&usr=' . urlencode($_POST["usr"]);
        $_SESSION=[];
        session_destroy();
        header('Location: ../index.php?formError=true&usr='.$_POST["usr"].'');
        exit();
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
            <main style="max-width: 1000px" class="container m-auto text-center">                 

                <?php 
                echo '<h1>'.$_COOKIE["ultCone"].'</h1>';
                    //$sqlActores="SELECT * FROM ACTORES";
                    //$tablaPeliculasActores = extraerTablas($sqlActores, true);  unset($sqlActores);
                    $sqlActuan="SELECT * FROM ACTUAN";
                    $tablaActuan = extraerTablas($sqlActuan, true);  unset($sqlActuan);
                    $tabla=extraerTablas("SELECT * FROM PELICULAS");
                    if (!isset($arrPeliculas)) {
                        $arrPeliculas = crearInstanciasPelicula($tabla,$maxIDPelicula);
                    }
                    if (!isset($arrActores)) {
                        $arrActores = extraerTablas(
                            "SELECT * FROM ACTORES",true);
                        $arrActores = crearInstanciasActores($arrActores,$maxIDActor);
                    }
                    unset($tabla);
                    $esRolAdmin = isset($_SESSION["rol"]) && password_verify('1', $_SESSION['rol']);
                    echo $esRolAdmin
                        ? entornoFormularioPrincipal(anadirListaParo(imprimirTablaPeliculas($arrPeliculas, $arrActores, $tablaActuan, $arrActoresParo), $arrActoresParo, $arrActores), $miUsuario, $maxIDPelicula)
                        : imprimirTablaPeliculas($arrPeliculas, $arrActores, $tablaActuan, $arrActoresParo, true);
                    if (!$esRolAdmin) {
                        $tabla=extraerTablas("SELECT * FROM USUARIOS WHERE ROL = 1",true);
                        $arrAdmins=crearInstanciasAdminsAux($tabla);
                        echo entornoFormulario(inputsFormularioMailAdmin($arrAdmins),$miUsuario);
                    }
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
