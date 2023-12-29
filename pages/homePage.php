<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Ejercicios_UT6_1_Victor_Valdes_Cobos/libraries/functions/funciones.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Ejercicios_UT6_1_Victor_Valdes_Cobos/templates/funcionesTemplate.php';
    
    //Comienzo sesión
    session_start();
    if (isset($_POST["miUsuario"])) {
        //Si no es la primera vez que abro homePage, instancio $_POST["miUsuario"]
        //Ya que no puedo invocar al constructor de Usuario y los procesos que ello conlleva lo hago manualmente
        //Posria usar rodavía más variables en el cosntructor para actualizar post, sesión y la cookie automáticamente pero creo que es excesivo
        $miUsuario = unserialize(base64_decode($_POST["miUsuario"]));
        $miUsuario->actualizarPost($_POST);
        $miUsuario->actualizarSesion($_SESSION,false);
        $miUsuario->iniciarCookieSesion();
    }   else{
        //Si es la primera vez que vengo a homePage
        //Hash a la contraseña dada por el login
        $_POST["password"]=hash('sha256', $_POST['password']);
    }
    
    
    if ($_SERVER["REQUEST_METHOD"]==="POST" && comprobarLogin($tabla)) {
        //Método post y login correcto.
        //Si existe el usuario en POST -->> gestiono la funcionalidad de la App, si no creo la instancia usuario para...
        //... el usuario principal.
        isset($_POST["miUsuario"]) ? gestionarFuncionalidad() : crearInstanciaUsuario($miUsuario, $tabla, $_SESSION);
        unset($password,$tabla); //Datos innecesarios
        if (isset($_POST["miUsuario"])) unset ($_POST["miUsuario"]); //Datos innecesarios
        if (isset($_POST["password"])) unset ($_POST["password"]); //Datos innecesarios
        if (isset($_POST["usr"])) unset ($_POST["usr"]); //Datos innecesarios
    } else{
        //Esta parte destruye todo lo que tenga que ver con estar iniciado de sesión.
        crearInstanciaLogError($_POST["usr"]);
        isset($_POST["usr"]) ? $url = '../index.php?formError=true&usr=' . urlencode($_POST["usr"]) .'&mensajeNoExisteUsr=true' : $url = '../index.php?formError=true';
        $_SESSION=[];
        session_destroy();
        setcookie("ultCone", null, time() - 3600, 'localhost');
        header('Location: '.$url);
        exit();
    }
    unset($tabla); //Datos innecesarios
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
        <link rel="stylesheet" type="text/css" href="../css/util.css?1.0" media="all" >
        <link rel="stylesheet" type="text/css" href="../css/main.css?1.0" media="all" >
        <!--===============================================================================================-->


    </head>
    <body class="bg-dark">
        <div class="min_container container mx-auto mt-5">
            <?php include '../templates/header.php'; ?>

            <!-- Contenedor principal (main) -->
            <main class="container m-auto text-center">                 

                <?php 
                    //Imprimer cookie si existe
                    echo '<h1 class="text-white">' . (isset($_COOKIE["ultCone"]) ? $_COOKIE["ultCone"] : '') . '</h1>';
                
                    //Extrae todos los actores, true indica que se extrae un array asociativo (OPCIONAL)
                    $tablaActuan = extraerTablas("SELECT * FROM ACTUAN", true);
                    //Extrae todas las películas
                    $tablaPeliculas=extraerTablas("SELECT * FROM PELICULAS");
                    
                    //Instancio todas las películas y las devuelvo como un array $arrPeliculas
                    //tambien obtengo el máximo id por si tengo que añadir una película
                    if (!isset($arrPeliculas)) {    //Si es la primera vez que abro homePage (OPTIMIZACION)
                        $arrPeliculas = crearInstanciasPelicula($tablaPeliculas, $maxIDPelicula);
                    }

                    //Instancio todos los actores y los devuelvo como un array $arrActores
                    if (!isset($arrActores)) {    //Si es la primera vez que abro homePage (OPTIMIZACION)
                        $arrActores = extraerTablas("SELECT * FROM ACTORES", true);
                        $arrActores = crearInstanciasActores($arrActores, $maxIDActor);
                    }
                    
                    //Interpreto el rol del usuario usando password_verify
                    $esRolAdmin = isset($_SESSION["rol"]) && password_verify('1', $_SESSION['rol']);

                    
                    if ($esRolAdmin) {
                        // Acciones específicas para administradores
                        echo entornoFormularioPrincipal(//  Preparo todos los posts necesarios junto al formulario
                            anadirListaParo(//  Añado la lista de actores en paro
                                imprimirTablaPeliculas($arrPeliculas, $arrActores, $tablaActuan, $arrActoresParo),//  Imprimo todas las películas
                                $arrActoresParo,//  IS's de los actores en paro
                                $arrActores// Todas las instancias de Actor disponibles
                            ),
                            $miUsuario,// Instancia del cliente
                            $maxIDPelicula// Máximo id de la película
                        );
                    } else {
                        // Acciones específicas para no administradores
                        // Uso la función de imprimir tabla peliculas, true indica que no es funcional
                        // Posteriormente borro la variable $arrActoresParo, la necesito solo para llamar a imprimirTablaPeliculas()
                        echo imprimirTablaPeliculas($arrPeliculas, $arrActores, $tablaActuan, $arrActoresParo, true);   unset($arrActoresParo);
                        // Extraigo datos necesarios para mostrar a los admins
                        $tablaAdmins = extraerTablas("SELECT id, username FROM USUARIOS WHERE ROL = 1", true);
                        // Creo instancias Usuario para los admins (SIN CONTRASEÑA NI DATOS PRIVADOS)
                        $arrAdmins = crearInstanciasAdminsAux($tablaAdmins);    unset($tablaAdmins);
                        // Imprimo el formulario y la tabla
                        echo entornoFormulario(
                                inputsFormularioMailAdmin($arrAdmins),//  Dentro llama a imprimirTablaPeliculas()
                                $miUsuario
                        );
                    }

                ?>
                
            </main>
            <!-- Aquí va el contenido de tu página -->
        <?php include '../templates/footer.php'; ?>
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
