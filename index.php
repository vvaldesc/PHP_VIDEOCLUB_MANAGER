<?php 
    include_once $_SERVER['DOCUMENT_ROOT'].'/Ejercicios_UT6_1_Victor_Valdes_Cobos/libraries/functions/funciones.php';
    session_start();
    $formError = (isset($_GET["usr"]));
    setcookie("ultCone", date("Y-m-d H:i:s"),time() + 3000, 'localhost');
    if (isset($_GET['logout']) && $_GET['logout']==true) cerrarSesion();
    if (isset($_GET['mensajeNoExisteUsr']) && $_GET['mensajeNoExisteUsr']==true) echo mensajeError("El usuario ".urldecode($_GET["usr"])." no existe o la contraseña es incorrecta");
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <title>Iniciar Sesión - Videoclub</title>
        
        <?php require './templates/styleLinks.php';?>
        
    </head>
    <body class="bg-dark">

        <div class="container mx-auto mt-5">

            <!-- Section: Design Block -->
            <section>
                <!-- Jumbotron -->
                <div class="px-2 py-5 px-md-5 text-center text-lg-start" style="background-color: hsl(0, 0%, 96%)">
                    <div class="container">
                        <div class="row gx-lg-5 align-items-center">
                            <div class="col-lg-6 mb-5 mb-lg-0">
                                <h1 class="my-5 display-3 fw-bold ls-tight">
                                    Videoclub <br />
                                    <span class="text-primary">Online</span>
                                </h1>
                                <p style="color: hsl(217, 10%, 50.8%)">
                                    Inicia sesión en la plataforma de gestión para Videoclub online para
                                    disfrutar de las funcionalidades de la aplicación.
                                </p>
                            </div>

                            <div class="col-lg-6 mb-5 mb-lg-0">
                                <div class="card">
                                    <div class="card-body py-5 px-md-5">
                                        <form method="POST" class="mt-4 p-4 d-flex flex-column" action='pages/homePage.php'>
                                            
                                            <span class="login100-form-title p-b-26">
                                                Welcome
                                            </span>   
                                                                                       
                                            <div class="wrap-input100 validate-input" data-validate = "Valid email is: a@b.c">
                                                <input class="input100" value="<?= $formError===true ? urldecode($_GET["usr"]) : "" ?>" type="text" name="usr">
                                                <span class="focus-input100" data-placeholder="Email"></span>
                                            </div>

                                            <div class="wrap-input100 validate-input" data-validate="Enter password">
                                                <span class="btn-show-pass">
                                                    <i class="zmdi zmdi-eye"></i>
                                                </span>
                                                <input class="input100" type="password" name="password">
                                                <span class="focus-input100" data-placeholder="Password"></span>
                                            </div>
                                            
                                            <!-- Submit button -->
                                            <button type="submit" class="btn btn-primary btn-block mb-4">
                                                Sign up
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Jumbotron -->
            </section>
            <!-- Section: Design Block -->
            
        <?php include './templates/footer.php'; ?>

        </div>
        
        <?php require './templates/scriptLinks.php';?>
        
        


    </body>
</html>
