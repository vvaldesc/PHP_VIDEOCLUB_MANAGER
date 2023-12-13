<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/Ejercicios_UT6_1_Victor_Valdes_Cobos/libraries/functions/conexion.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Ejercicios_UT6_1_Victor_Valdes_Cobos/libraries/functions/conexionPDO.php';

include_once $_SERVER['DOCUMENT_ROOT'] . '/Ejercicios_UT6_1_Victor_Valdes_Cobos/libraries/models/usuario.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Ejercicios_UT6_1_Victor_Valdes_Cobos/libraries/models/pelicula.php';

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
                $tabla = extraerTablas($sql);
                if (count($tabla) == 1 && $_POST["pass"] == $tabla[0]["password"]) {
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

function crearInstanciaUsuario(&$miUsuario, $tabla) {
    $miUsuario = new Usuario($tabla[0]["id"], $tabla[0]["username"], $tabla[0]["password"], $tabla[0]["rol"]);
}

function crearInstanciaLogError($username) {
    new Log(null, $username, true);
}

function crearInstanciasPelicula($tabla) {
    $arrPeliculas = array();
    foreach ($tabla as $pelicula) {
        $peliculaAux = new Pelicula($pelicula["id"], $pelicula["titulo"], $pelicula["genero"], $pelicula["pais"], $pelicula["anyo"], $pelicula["cartel"]);
        array_push($arrPeliculas, $peliculaAux);
    }
    return $arrPeliculas;
}

function imprimirTabla($arrPeliculas, $rol) {

    echo '<table class="table">';
    echo '<thead><tr>';
    foreach (array_keys($arrPeliculas) as $columna) {
        echo '<th scope="col">' . $columna . '</th>';
    }
    echo '<th scope="col">' . count($arrPeliculas) . '</th>';
    echo '<th scope="col">' . count($arrPeliculas)+1  . '</th>';

    echo '</tr></thead><tbody>';

    for ($i = 1; $i < count($arrPeliculas); $i++) {
        echo '<tr>';

        // Obtén los atributos del objeto actual
        $arrAtributos = get_object_vars($arrPeliculas[$i]);

        // Itera sobre los atributos
        foreach ($arrAtributos as $nombre => $valor) {
            echo '<td>';

            // Verifica si el atributo es una imagen
            if ($nombre === 'cartel') {
                echo '<img src="' . $_SERVER['DOCUMENT_ROOT'] . '/Ejercicios_UT6_1_Victor_Valdes_Cobos/assets/img/' . $valor . '" alt="Imagen">';
            } else {
                // Aquí puedes realizar otras comprobaciones o procesamientos según el atributo
                echo $valor;
            }

            echo '</td>';
        }
        imprimirControlesTabla();

        echo '</tr>';
    }


    echo '</tbody></table>';
}

function imprimirControlesTabla(){
            echo '<td>';

                echo 'input';

            echo '</td>';
}

function mensajeError($message) {
    return '<nav class="navbar bg-body-tertiary bg-danger rounded m-2">
                <div class="container-fluid">
                    <p>
                        ' . $message . '
                    </p>
                </div>
            </nav>';
}

?>