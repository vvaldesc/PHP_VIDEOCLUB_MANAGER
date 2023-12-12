<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . '/Ejercicios_UT6_1_Victor_Valdes_Cobos/libraries/functions/conexion.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Ejercicios_UT6_1_Victor_Valdes_Cobos/libraries/functions/conexionPDO.php';

/**
 * Comprueba si el usuario y contraseña son correctos para acceder a la aplicación.
 * 
 * @param array $POST Array que contiene los datos del formulario login.
 * 
 */
function comprobarLogin() {
    if (isset($_POST["pass"]) && isset($_POST["usr"])) {
        if ($_POST["pass"] != '' && $_POST["usr"] != '') {
            try {
                //Sentencia SQL
                $sql = "SELECT * FROM usuarios WHERE USERNAME = '" . $_POST['usr'] . "';";
                // AL SER USUARIO CLAVE UNICA LA PRIMERA CONDICIÓN ES PRÁCTICAMENTE INNECESARIA
                // ESTO NO LO HE COMPROBADO TODAVÍA
                $tabla = extraerTablas($sql);
                if (count($tabla) == 1) {
                    $_SESSION['id'] = $tabla[0]["id"];
                    $_SESSION['username'] = $tabla[0]["username"];
                    $_SESSION['contraseña'] = $tabla[0]["password"];
                    $_SESSION['rol'] = $tabla[0]["rol"];
                    //header('Location: ./pages/homepage.php');
                    return true;
                } else {
                    echo mensajeError("La contraseña o el usuario no es correcto");
                }
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        }
    } else {
        echo "no";
    }
    return false;
}

?>