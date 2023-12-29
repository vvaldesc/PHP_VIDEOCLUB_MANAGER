<?php

    //include_once $_SERVER['DOCUMENT_ROOT'] . '/Ejercicios_UT6_1_Victor_Valdes_Cobos/libraries/functions/funciones.php';
    
//en este fichero están todas las funciónes que están pensadas para imprimir código html y que no dependen de '/Ejercicios_UT6_1_Victor_Valdes_Cobos/libraries/functions/funciones.php'.

/**
 * Introduces parameter into a select element
 * 
 * @param string $innerForm
 * @return type string
 */
function entornoSelect($innerForm) {
    return '<select class="form-control" id="exampleFormControlSelect1">' . $innerForm . '</form>';
}

/**
 * Creates a form element with specified inner content and hidden input for user data
 * 
 * @param string $innerForm
 * @param Usuario $miUsuario
 * @return string
 */
function entornoFormulario($innerForm,$miUsuario) {
    return '<form method="POST" action="' . $_SERVER["PHP_SELF"] . '">' 
    . $innerForm 
    . '<input type="hidden" name="miUsuario" value="' . (!empty($miUsuario) ? base64_encode(serialize($miUsuario)) : '') . '">'
    . '</form>';
}

/**
 * Prints attributes for display, $id I/O parameter meant to return id of the displayed element.
 * 
 * @param string $columna
 * @param mixed $valor
 * @param mixed $id
 * @return string
 */
function imprimirAtributosMostrar($columna, $valor, &$id) {
    $htmlTd = '';
    if ($columna === 'cartel') {
        $htmlTd .= '<img class="img-thumbnail" style="width: 160px; height: 240px;" src="../assets/img/carteles/' . $valor . '" alt="Cartel">';
    } else if ($columna === 'id') {
        $htmlTd .= $valor;
        $id = $valor;
    } else {
        $htmlTd .= '<p class="text-lg text-white">' . $valor . '</p>';
    }
    return $htmlTd;
}

/**
 * Prints attributes for midificate, $id I/O parameter meant to return id of the displayed element.
 * 
 * @param string $columna
 * @param mixed $valor
 * @param mixed $id
 * @return string
 */
function imprimirAtributosInput($columna, $valor, &$id) {
    $htmlTd = '';
//$htmlTd .= '<input type="hidden" name="modificarBD" value="'.true.'">';
    switch ($columna) {
        case "id":
            $htmlTd .= $valor;
            $id = $valor;
            break;
        case "titulo": case "genero": case"pais": case"anyo":
            $htmlTd .= '<input class="form-control" type="text" value="' . $valor . '" name="modificarInput_' . ucfirst($columna) . '" required>';
            break;
        case "cartel":
            $htmlTd .= '<input class="form-control" type="text" value="' . $valor . '" name="modificarInput_' . ucfirst($columna) . '" required>';
            break;
        default:
            break;
    }
    return $htmlTd;
}

/**
 * Prints necessary hidden inputs to determinate wich film is going to be updated, if this varible is set we know
 * the database has to be updated.
 * I/O $imprimido controls inputs are ptinted once.
 * 
 * @param string $innerHTML
 * @param bool $imprimido
 * @param int $idPelicula
 * @return string
 */
function entornoInputsModificarPelicula($innerHTML, &$imprimido, $idPelicula) {
    if (!$imprimido) {
        $innerHTML .= '<input type="hidden" name="modificarBD" value="true">';
        $innerHTML .= '<input type="hidden" name="IDpeliculaModificar" value="' . $idPelicula . '">';
        $imprimido = true;
    }
    return $innerHTML;
}

/**
 * Prints a button for sending mail
 * 
 * @param string $idAdmin
 * @return string
 */
function imprimirControlMail($idAdmin) {
    $html = '<button type="submit" class="btn btn-primary" name="enviarMailId_' . $idAdmin . '">Enviar</button>';
    return $html;
}

/**
 * Creates a flex container div
 * 
 * @param string $innerHtml
 * @return string
 */
function entornoCajaFlex($innerHtml) {
    return '<div class="d-flex justify-content-center align-center text-center">' . $innerHtml . '</div>';
}

/**
 * Creates a table cell with specified inner content and colspan
 * 
 * @param string $innerTd
 * @param int $colspan
 * @return string
 */
function entornoTd($innerTd, $colspan = 1) {
    return '<td colspan=' . $colspan . '>' . $innerTd . '</td>';
}

/**
 * Creates a table element with specified inner content
 * 
 * @param string $innerTable
 * @return string
 */
function entornoTable($innerTable) {
    return '<table class="table text-white">' . $innerTable . '</table>';
}

/**
 * Prints actor details in a formatted manner
 * 
 * @param array $arrActores
 * @return string
 */
function imprimirReparto($arrActores) {
    $html = '';
    for ($index = 0; $index < count($arrActores); $index++) {
        $html .= '<article class="p-3 m-3 card bg-secondary  text-white d-flex flex-column align-center">';
        $arrActor = $arrActores[$index]->toArray();
        for ($j = 0; $j < count($arrActor); $j++) {
            $key = array_keys($arrActor)[$j];
            switch ($key) {
                case "nombre":
                    $html .= '<h3 class="small text-white">' . $arrActor["nombre"] . '</h3>';
                    break;
                case "fotografia":
                    $html .= '<img class="img-thumbnail img-fluid" style="width: 120px; height: 170px" src="../assets/img/actores/' . $arrActor["fotografia"] . '" alt="Actor">';
                    break;
                case "apellidos":
                    $html .= '<h5 class="small text-white">' . $arrActor["apellidos"] . '</h5>';
                    break;
                default:
                    break;
            }
        }
        $html .= '</article>';
    }
    return $html;
}

/**
 * Creates a table row with specified inner content
 * 
 * @param string $innerHTML
 * @return string
 */
function entornoTr($innerHTML) {
    return '<tr>' . $innerHTML . '</tr>';
}

/**
 * Prints control buttons for a table row (delete, modify, select)
 * 
 * @param mixed $id
 * @param bool $soloBorrar
 * @param mixed $nombreBorrar
 * @return string
 */
function imprimirControlesTabla($id, $soloBorrar = false, $nombreBorrar = null) {
    $html = '';
    if (!$soloBorrar)
        $html = '<td>';
//nombre operador ternario hacer name="eliminarPeliculaId_' 
    $html .= '<button type="submit" class="btn btn-danger" name="' . ($nombreBorrar === null ? 'eliminarPeliculaId_' : $nombreBorrar) . $id . '">' . (isset($_POST["mostrarInputsPelicula_ID"]) ? 'Cancelar' : 'Eliminar') . '</button>';
    if (!$soloBorrar) {
        $html .= '</td>';
        $html .= '<td>';
        $html .= '<button type="submit" class="btn btn-secondary" name="modificarPeliculaId_' . $id . '">Modificar</button>';
        $html .= '</td>';
        $html .= '<td>';
        $html .= '<input type="radio" name="selectorPeliculaId_' . $id . '">';
        $html .= '</td>';
    }
    return $html;
}

/**
 * Prints table header cells with indices for control buttons
 * 
 * @param int $max The maximum index value
 * @return string HTML for table header cells
 */
function imprimirIndicesControlesTabla($max) {
    $html = '<th scope="col">' . $max . '</th>';
    $html .= '<th scope="col">' . $max + 1 . '</th>';
    $html .= '<th scope="col">' . $max + 2 . '</th>';
    return $html;
}

/**
 * Prints table header cell with index for mail control button
 * 
 * @param int $max The maximum index value
 * @return string HTML for table header cell
 */
function imprimirIndiceControlMail($max) {
    $html = '<th scope="col"></th>';
    return $html;
}

/**
 * Generates HTML for an error message container
 * 
 * @param string $message The error message to be displayed
 * @return string HTML for the error message container
 */
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
 * Generates HTML for input fields to add a new movie
 * 
 * @return string HTML for the movie addition input fields
 */
function inputsAnadirPelicula() {
    $formAnadirError = isset($_POST["formAnadirError"]) ? true : false;
    
    return $formulario = '
        <div class="form-group">
            <label for="titulo">Título</label>
            <input name="nuevaPelicula_Titulo" value="' . ($formAnadirError && isset($_POST["nuevaPelicula_Titulo"]) ? $_POST["nuevaPelicula_Titulo"] : '') . '" type="text" class="form-control" id="titulo" placeholder="Título">
        </div>
        <div class="form-group">
            <label for="genero">Género</label>
            <input name="nuevaPelicula_Genero" value="' . ($formAnadirError && isset($_POST["nuevaPelicula_Genero"]) ? $_POST["nuevaPelicula_Genero"] : '') . '" type="text" class="form-control" id="genero" placeholder="Género">
        </div>
        <div class="form-group">
            <label for="pais">País</label>
            <input name="nuevaPelicula_Pais" value="' . ($formAnadirError && isset($_POST["nuevaPelicula_Pais"]) ? $_POST["nuevaPelicula_Pais"] : '') . '" type="text" class="form-control" id="pais" placeholder="País">
        </div>
        <div class="form-group">
            <label for="anyo">Año</label>
            <input name="nuevaPelicula_Anyo" value="' . ($formAnadirError && isset($_POST["nuevaPelicula_Anyo"]) ? $_POST["nuevaPelicula_Anyo"] : '') . '" type="number" class="form-control" id="anyo" placeholder="Año">
        </div>
        <div class="form-group">
            <label for="cartel">Cartel</label>
            <input name="nuevaPelicula_Cartel" value="' . ($formAnadirError && isset($_POST["nuevaPelicula_Cartel"]) ? $_POST["nuevaPelicula_Cartel"] : '') . '" type="text" class="form-control" id="cartel" placeholder="Cartel">
        </div>
    ';
}


/**
 * Generates HTML for the button to open the modal to add a new movie
 * 
 * @return string HTML for the "Add Movie" button
 */
function botonModalAnadirPelicula() {
    return $html = '
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                Añadir película
              </button>';
}

/**
 * Generates HTML for the modal to add a new movie
 * 
 * @return string HTML for the modal to add a new movie
 */
function modalAnadirPelicula() {
    return $html = botonModalAnadirPelicula() . '
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter" aria-hidden="true">
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

/**
 * Generates HTML for hidden form inputs
 * 
 * @param mixed $datosEnviar The data to be sent with the form
 * @return string HTML for hidden form inputs
 */
function imprimirInputsHiddenForm($datosEnviar) {
//AQUI ENTRAN TODOS LOS INPUTS QUE HAN DE ENTRAR, DEBERIA DDE SER EL ARRAY DIRECTAMENTE
    return '<input type="hidden" name="datosEnviar" value=' . $datosEnviar . '></input>';
}

/**
 * Using this function to embrace my table by a form
 * 
 * @param type $innerForm
 * @param type $datosEnviar
 * @return type
 */
function entornoFormularioPrincipal($innerForm, $miUsuario, $maxIDPeliculas) {
    return ''
            . '<form method="POST" action="' . $_SERVER["PHP_SELF"] . '">'
            . $innerForm
            . modalAnadirPelicula()
            . '<input type="hidden" name="miUsuario" value="' . (!empty($miUsuario) ? base64_encode(serialize($miUsuario)) : '') . '">'
            . '<input type="hidden" name="maxIDPeliculas" value="' . $maxIDPeliculas . '">'
            . '</form>';
}