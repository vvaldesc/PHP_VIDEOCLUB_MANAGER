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

function imprimirTabla($arrPeliculas, $rol) {
    $html = '<table class="table">';
    $html .= '<thead><tr>';
    foreach (array_keys(get_object_vars($arrPeliculas[0])) as $columna) {
        $html .= '<th scope="col">' . $columna . '</th>';
    }
    
    $rol == 1 ? $html .= imprimirIndicesControlesTabla(count($arrPeliculas)) : null;
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
        imprimirControlesTabla($arrPeliculas[$i]->getId());
        $html .= '</tr>';
    }

    $html .= '</tbody></table>';
    return $html;
}

function imprimirControlesTabla($id) {
    $html = '<td>';
    $html .= '<button type="submit" class="btn btn-danger">Eliminar</button>';
    $html .= '</td>';
    $html .= '<td>';
    $html .= '<button type="button" class="btn btn-secondary">Modificar</button>';
    $html .= '</td>';
    return $html;
}

function imprimirIndicesControlesTabla($max){
    $html = '<th scope="col">' . $max . '</th>';
    $html .= '<th scope="col">' . $max + 1 . '</th>';
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
function entornoFormulario($innerForm,$datosEnviar) {
    return '<form method="POST" action='.$_SERVER["PHP_SELF"].'>' 
            . $innerForm .
            isset($_SESSION["rol"]) && password_verify('1', $_SESSION['rol']) ? imprimirInputsHiddenForm($datosEnviar) : null
            . '</form>';
}


function imprimirInputsHiddenForm($datosEnviar){
    //AQUI ENTRAN TODOS LOS INPUTS QUE HAN DE ENTRAR, DEBERIA DDE SER EL ARRAY DIRECTAMENTE
    return '<input type="hidden" name="datosEnviar"></input>';
} 

function comprobarFuncionalidad($arrPeliculas = null, &$arrPliculasAux = null){
    if (isset($_POST["eliminarPelicula"])) {
        eliminarDatos("peliculas", "id", $_POST["eliminar"]);
    } else if (isset($_POST["anadirPelicula"])) {
        array_push($array, $values);
        insertar("peliculas", array("id" => count($arrPeliculas),"titulo" => $_POST["peliculaTitulo"],"genero" => $_POST["peliculaGenero"],"pais" => $_POST["peliculaPais"],"anyo" => $_POST["peliculaAnyo"],"cartel" => $_POST["peliculaCartel"]));
    } else if (isset ($_POST["modificarPelicula"])){
        modificarTabla("peliculas", $_POST["modificarPelicula"]);
    }
}
?>