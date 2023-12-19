<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/Ejercicios_UT6_1_Victor_Valdes_Cobos/libraries/functions/conexion.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Ejercicios_UT6_1_Victor_Valdes_Cobos/libraries/functions/conexionPDO.php';

include_once $_SERVER['DOCUMENT_ROOT'] . '/Ejercicios_UT6_1_Victor_Valdes_Cobos/libraries/models/usuario.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Ejercicios_UT6_1_Victor_Valdes_Cobos/libraries/models/pelicula.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Ejercicios_UT6_1_Victor_Valdes_Cobos/libraries/models/actor.php';

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

function crearInstanciasPelicula($tabla,&$maxID) {
    $maxID=0;
    $arrPeliculas = array();
    foreach ($tabla as $pelicula) {
        $peliculaAux = new Pelicula(
            $pelicula["id"],
            $pelicula["titulo"],
            $pelicula["genero"],
            $pelicula["pais"],
            $pelicula["anyo"],
            $pelicula["cartel"]
        );
        array_push($arrPeliculas, $peliculaAux);
        if ($maxID < intval($pelicula["id"])) $maxID=$pelicula["id"];
    }
    return $arrPeliculas;
}

function crearInstanciasActores($tabla,&$maxID) {
    $maxID=0;
    $arrActores = array();
    foreach ($tabla as $actor) {
        $actorAux = new Actor(
            $actor["id"],
            $actor["nombre"],
            $actor["apellidos"],
            $actor["fotografia"]
        );
        array_push($arrActores, $actorAux);
        if ($maxID < intval($actor["id"])) $maxID=$actor["id"];
    }
    return $arrActores;
}

function imprimirTablaPeliculas($arrPeliculas,$arrTablaExtra = null) {
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
                $html .= '<img class="img-thumbnail w-50 h-50" src="../assets/img/carteles/' . $valor . '" alt="Cartel">';
            } else {
                $html .= $valor;
            }
            $html .= '</td>';
        }
        password_verify('1', $_SESSION['rol']) ? $html .= imprimirControlesTabla($arrAtributos["id"]) : null;
        
        // se deberia imprimir un td con el maximo colspan, y dentro de esto una tabla para el reparto
        
        //if ($arrTablaExtra !== null) $html .= entornoTr(imprimirReparto($arrTablaExtra[$i]),count($arrPeliculas)+2);
            
        $html .= '</tr>';
    }

    $html .= '</tbody></table>';
    return $html;
}

function imprimirReparto($arrActores) {
    for ($index = 0; $index < count($arrActores); $index++) {
        $html = '<td>';
        for ($j = 0; $j < count($arrActores[$index]); $j++){
            $key = array_keys($arrActores)[$j];
            switch ($key) {
                case "nombre":
                     $html .= '<p>'.$arrActores["nombre"].'</p>';
                    break;
                case "fotografia":
                     $html .= '<img class="img-thumbnail w-50 h-50" src="../assets/img/actores/' . $arrActores["fotografia"] . '" alt="Actor">';
                    break;
                case "apellidos":
                     $html .= '<p>'.$arrActores["apellidos"].'</p>';
                    break;

                default:
                    break;
            }
        }
        $html .= '<td>';
    }
    return $html;
}

function entornoTr($innerHTML,$colspan){
    return '<tr>'.$innerHTML.'</tr>';
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
function entornoFormulario($innerForm, $miUsuario, $maxIDPeliculas) {
    return '<form method="POST" action=' . $_SERVER["PHP_SELF"] . '>'
            . $innerForm
            . (isset($_SESSION["rol"]) && password_verify('1', $_SESSION['rol']) ? modalAnadirPelicula() : '')
            . '<input type="hidden" name="miUsuario" value="' . (!empty($miUsuario) ? base64_encode(serialize($miUsuario)) : '') . '">'
            . '<input type="hidden" name="maxIDPeliculas" value="' . $maxIDPeliculas . '">'
            . '</form>';
}

function botonModalAnadirPelicula() {
    return $html = '
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                Añadir película
              </button>';
}

function modalAnadirPelicula() {
    return $html = botonModalAnadirPelicula() . '
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Añadir película</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ' . inputsAnadirPelicula() . '
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <input name="anadirPelicula" type="submit" class="btn btn-primary" value="Enviar">
                    </div>
                </div>
            </div>
        </div>';
    return $html;
}

function inputsAnadirPelicula() {
    return $formulario = '
        <div class="form-group">
            <label for="nombre">Título</label>
            <input name="nuevaPelicula_Titulo" type="text" class="form-control" id="titulo" placeholder="Título" required>
        </div>
        <div class="form-group">
            <label for="apellidos">Género</label>
            <input name="nuevaPelicula_Genero" type="text" class="form-control" id="genero" placeholder="Genero" required>
        </div>
        <div class="form-group">
            <label for="domicilio">Pais</label>
            <input name="nuevaPelicula_Pais" type="text" class="form-control" id="pais" placeholder="Pais" required>
        </div>
        <div class="form-group">
            <label for="domicilio">Año</label>
            <input name="nuevaPelicula_Anyo" type="number" class="form-control" id="anyo" placeholder="Año" required>
        </div>
        <div class="form-group">
            <label for="domicilio">Cartel</label>
            <input name="nuevaPelicula_Cartel" type="text" class="form-control" id="cartel" placeholder="Cartel" required>
        </div>
    ';
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
            // Iterate over the remaining keys to collect selector IDs.
            while ($i < count($clavePost)) {
                $key = $clavePost[$i];

                if (strpos($key, "selectorPeliculaId") === 0 || strpos($key, "eliminarPeliculaId") === 0) {
                    $id = obtenerID($key);
                    array_push($arrSelectorIDs, $id);
                }
                $i++;
            }
            // Return the "eliminarPelicula" functionality.
            $funcionalidadID = array("funcion" => "eliminarPelicula", "id" => $arrSelectorIDs);
            return "eliminarPelicula";
        }
    }
}

function anadirPelicula($maxIDPeliculas) {
    insertar("peliculas", array("id" => $maxIDPeliculas + 1, "titulo" => $_POST["nuevaPelicula_Titulo"], "genero" => $_POST["nuevaPelicula_Genero"], "pais" => $_POST["nuevaPelicula_Pais"], "anyo" => $_POST["nuevaPelicula_Anyo"], "cartel" => $_POST["nuevaPelicula_Cartel"]));
}

function modificarPelicula() {
    return 0;
}

function eliminarPeliculas($funcionalidadID) {
    if (is_array($funcionalidadID["id"])) {
        $valores = array(); // Crear un array para almacenar los valores
        foreach ($funcionalidadID["id"] as $value) {
            $valores[] = $value; // Agregar cada valor individual al array
        }
        $valores = implode(", ", $valores); // Combina los valores con " OR "
    } else {
        $valores = $funcionalidadID["id"];
    }

    // Eliminar datos utilizando el valor o la combinación de valores
    eliminarDatos("peliculas", "id", $valores);
}
