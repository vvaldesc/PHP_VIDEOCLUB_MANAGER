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
function comprobarLogin(&$tabla) {
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

function imprimirTabla($arrPeliculas) {
    $html = '<table class="table">';
    $html .= '<thead><tr>';
    foreach (array_keys(get_object_vars($arrPeliculas[0])) as $columna) {
        $html .= '<th scope="col">' . $columna . '</th>';
    }

    password_verify('1', $_SESSION['rol']) ? $html .= imprimirIndicesControlesTabla(count($arrPeliculas)) : null;
    $html .= '</tr></thead><tbody>';

    for ($i = 0; $i < count($arrPeliculas); $i++) {
        $html .= '<tr>';

        $arrAtributos = get_object_vars($arrPeliculas[$i]);

        foreach ($arrAtributos as $nombre => $valor) {
            $html .= '<td>';
            if ($nombre === 'cartel') {
                $html .= '<img class="img-thumbnail w-50 h-50" src="../assets/img/' . $valor . '" alt="Cartel">';
            } else {
                $html .= $valor;
            }
            $html .= '</td>';
        }

        password_verify('1', $_SESSION['rol']) ? $html .= imprimirControlesTabla($arrAtributos["id"]) : null;
        // Aquí deberías llamar a la función imprimirControlesTabla y concatenar su resultado a $html
        $html .= '</tr>';
    }

    $html .= '</tbody></table>';
    return $html;
}

function imprimirControlesTabla($id) {
    $html = '<td>';
    $html .= '<button type="submit" class="btn btn-danger" name="eliminarPeliculaId_' . $id . '">Eliminar</button>';
    $html .= '</td>';
    $html .= '<td>';
    $html .= '<button type="button" class="btn btn-secondary" name="modificarPeliculaId_' . $id . '">Modificar</button>';
    $html .= '</td>';
    $html .= '<td>';
    $html .= '<input type="radio" name="selectorPeliculaId_' . $id . '" autocomplete="off">';
    $html .= '</td>';
    return $html;
}

function imprimirIndicesControlesTabla($max) {
    $html = '<th scope="col">' . $max . '</th>';
    $html .= '<th scope="col">' . $max + 1 . '</th>';
    $html .= '<th scope="col">' . $max + 2 . '</th>';

    return $html;
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

/**
 * Using this function to embrace my table by a form
 * 
 * @param type $innerForm
 * @param type $datosEnviar
 * @return type
 */
function entornoFormulario($innerForm, $datosEnviar) {
    return '<form method="POST" action=' . $_SERVER["PHP_SELF"] . '>'
            . $innerForm
            //isset($_SESSION["rol"]) && password_verify('1', $_SESSION['rol']) ? imprimirInputsHiddenForm($datosEnviar) : null
            . '</form>';
}

function imprimirInputsHiddenForm($datosEnviar) {
    //AQUI ENTRAN TODOS LOS INPUTS QUE HAN DE ENTRAR, DEBERIA DDE SER EL ARRAY DIRECTAMENTE
    return '<input type="hidden" name="datosEnviar" value=' . $datosEnviar . '></input>';
}

/**
 * I/O Parameter used to get proper info about how the database is going to be modified.
 * It checks multiple deletions too.
 *
 * @param array $funcionalityID The input/output parameter to obtain information about the functionality.
 * @return string The detected functionality.
 */
function obtenerID($key) {
    return strpos($key, "_") !== false ? substr($key, strpos($key, "_") + 1) : $key;
}

/**
 * I/O Parameter used to get proper info about how Data Base is going to be modified.
 * It checks multiple deletions too
 * 
 * @param type $funcionalidadID
 * @return string
 */
function funcionalidadPeliculas(&$funcionalidadID) {
    // Get all keys from $_POST.
    $clavePost = array_keys($_POST);
    $arrSelectorIDs = array();

    for ($i = 0; $i < count($clavePost); $i++) {

        $key = $clavePost[$i];

        // Check if the key contains "selectorMovieId".
        if (strpos($key, "selectorPeliculaId") === 0) {
            // Get the ID and add it to the array of selector IDs.
            $id = obtenerID($key);
            array_push($arrSelectorIDs, $id);
        }
        // Check other functionalities based on $_POST keys.
        if (strpos($key, "anadirPelicula") === 0) {
            // Return the "anadirPelicula" functionality.
            $funcionalidadID = array("funcion" => "anadirPelicula");
            return "anadirPelicula";
        } else if (strpos($key, "modificarPeliculaId") === 0) {
            // Return the "modificarPelicula" functionality.
            $id = obtenerID($key);
            $funcionalidadID = array("funcion" => "modificarPelicula", "id" => $id);
            return "modificarPelicula";
        } else if (strpos($key, "eliminarPeliculaId") === 0) {
            //Devuelve array(eliminarPeliculaId,idPelicula)
            //Si me encuentro en la ultima posicion y nos e han encontrado selectores...
            //Return eliminar solo con ese id
            if ($i == count($clavePost) - 1) {
                $id = obtenerID($key);
                $funcionalidadID = array("funcion" => "eliminarPelicula", "id" => $id);
            } else {
                // Iterate over the remaining keys to collect selector IDs.
                while ($i < count($clavePost)) {
                    $key = $clavePost[$i];

                    if (strpos($key, "selectorPeliculaId") === 0) {
                        $id = obtenerID($key);
                        array_push($arrSelectorIDs, $id);
                    }

                    $i++;
                }
            }
            // Return the "eliminarPelicula" functionality.
            $funcionalidadID = array("funcion" => "eliminarPelicula", "id" => $arrSelectorIDs);
            return "eliminarPelicula";
        }
    }
}

function anadirPeliculas($funcionalidadID) {
    return 0;
}

function modificarPeliculas($funcionalidadID) {
    return 0;
}

function eliminarPeliculas($funcionalidadID) {
    return 0;
}
