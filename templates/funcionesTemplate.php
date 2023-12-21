<?php

    //include_once $_SERVER['DOCUMENT_ROOT'] . '/Ejercicios_UT6_1_Victor_Valdes_Cobos/libraries/functions/funciones.php';
    
//en este fichero están todas las funciónes que están pensadas para imprimir código html y que no dependen de '/Ejercicios_UT6_1_Victor_Valdes_Cobos/libraries/functions/funciones.php'.


function entornoSelect($innerForm) {
    return '<select class="form-control" id="exampleFormControlSelect1">' . $innerForm . '</form>';
}

function entornoFormulario($innerForm,$miUsuario) {
    return '<form method="POST" action="' . $_SERVER["PHP_SELF"] . '">' 
    . $innerForm 
    . '<input type="hidden" name="miUsuario" value="' . (!empty($miUsuario) ? base64_encode(serialize($miUsuario)) : '') . '">'
    . '</form>';
}

function imprimirAtributosMostrar($nombre, $valor, &$id) {
    $htmlTd = '';
    if ($nombre === 'cartel') {
        $htmlTd .= '<img class="img-thumbnail w-50 h-50" src="../assets/img/carteles/' . $valor . '" alt="Cartel">';
    } else if ($nombre === 'id') {
        $htmlTd .= $valor;
        $id = $valor;
    } else {
        $htmlTd .= '<p class="text-white">' . $valor . '</p>';
    }
    return $htmlTd;
}

function entornoInputsModificarPelicula($innerHTML, &$imprimido, $idPelicula) {
    if (!$imprimido) {
        $innerHTML .= '<input type="hidden" name="modificarBD" value="true">';
        $innerHTML .= '<input type="hidden" name="IDpeliculaModificar" value="' . $idPelicula . '">';
        $imprimido = true;
    }
    return $innerHTML;
}

function imprimirAtributosInput($nombre, $valor, &$id) {
    $htmlTd = '';
//$htmlTd .= '<input type="hidden" name="modificarBD" value="'.true.'">';
    switch ($nombre) {
        case "id":
            $htmlTd .= $valor;
            $id = $valor;
            break;
        case "titulo": case "genero": case"pais": case"anyo":
            $htmlTd .= '<input type="text" value="' . $valor . '" name="modificarInput_' . ucfirst($nombre) . '">';
            break;
        case "cartel":
            $htmlTd .= '<input type="text" value="' . $valor . '" name="modificarInput_' . ucfirst($nombre) . '">';
            break;
        default:
            break;
    }
    return $htmlTd;
}

function imprimirControlMail($id) {
    $html = '';
    $html .= '<td>';
    $html .= '<button type="submit" class="btn btn-primary" name="enviarMailId_' . $id . '">Enviar</button>';
    $html .= '</td>';
    return $html;
}

function entornoCajaFlex($innerHtml) {
    return '<div class="d-flex justify-content-center align-center text-center">' . $innerHtml . '</div>';
}

function entornoTd($innerTd, $colspan = 1) {
    return '<td colspan=' . $colspan . '>' . $innerTd . '</td>';
}

function entornoTable($innerTable) {
    return '<table class="table text-white">' . $innerTable . '</table>';
}

function imprimirReparto($arrActores) {
    $html = '';
    for ($index = 0; $index < count($arrActores); $index++) {
        $html .= '<article class="p-3 m-3 card bg-secondary  text-white d-flex flex-column align-center">';
        $arrActor = $arrActores[$index]->toArray();
        for ($j = 0; $j < count($arrActor); $j++) {
            $key = array_keys($arrActor)[$j];
            switch ($key) {
                case "nombre":
                    $html .= '<p class="text-white">' . $arrActor["nombre"] . '</p>';
                    break;
                case "fotografia":
                    $html .= '<img class="img-thumbnail img-fluid" style="width: 120px; height: 170px" src="../assets/img/actores/' . $arrActor["fotografia"] . '" alt="Actor">';
                    break;
                case "apellidos":
                    $html .= '<p class="text-white">' . $arrActor["apellidos"] . '</p>';
                    break;
                default:
                    break;
            }
        }
        $html .= '</article>';
    }
    return $html;
}

function entornoTr($innerHTML) {
    return '<tr>' . $innerHTML . '</tr>';
}

function imprimirControlesTabla($id, $soloBorrar = false, $nombreBorrar = null) {
    $html = '';
    if (!$soloBorrar)
        $html = '<td>';
//nombre operador ternario hacer name="eliminarPeliculaId_' 
    $html .= '<button type="submit" class="btn btn-danger" name=' . ($nombreBorrar === null ? 'eliminarPeliculaId_' : $nombreBorrar) . '' . $id . '>Eliminar</button>';
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

function imprimirIndicesControlesTabla($max) {
    $html = '<th scope="col">' . $max . '</th>';
    $html .= '<th scope="col">' . $max + 1 . '</th>';
    $html .= '<th scope="col">' . $max + 2 . '</th>';
    return $html;
}

function imprimirIndiceControlMail($max) {
    $html = '<th scope="col">' . $max . '</th>';
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

function inputsAnadirPelicula() {
    return $formulario = '
        <div class="form-group">
            <label for="nombre">Título</label>
            <input name="nuevaPelicula_Titulo" type="text" class="form-control" id="titulo" placeholder="Título">
        </div>
        <div class="form-group">
            <label for="apellidos">Género</label>
            <input name="nuevaPelicula_Genero" type="text" class="form-control" id="genero" placeholder="Genero">
        </div>
        <div class="form-group">
            <label for="domicilio">Pais</label>
            <input name="nuevaPelicula_Pais" type="text" class="form-control" id="pais" placeholder="Pais">
        </div>
        <div class="form-group">
            <label for="domicilio">Año</label>
            <input name="nuevaPelicula_Anyo" type="number" class="form-control" id="anyo" placeholder="Año">
        </div>
        <div class="form-group">
            <label for="domicilio">Cartel</label>
            <input name="nuevaPelicula_Cartel" type="text" class="form-control" id="cartel" placeholder="Cartel">
        </div>
    ';
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