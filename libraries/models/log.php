<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/Ejercicios_UT6_1_Victor_Valdes_Cobos/libraries/functions/conexionPDO.php';

class Log {

    private $texto;

    public function __construct($id, $username, $error) {
        $fechaHora = date('Y-m-d H:i:s');
        if ($error) {
            $this->texto = "[$fechaHora] ERROR: Intento de inicio de sesión fallido para el usuario {$username}.";
        } else {
            $this->texto = "[$fechaHora] El usuario {$username} [{$id}] ha iniciado sesión correctamente.";
        }
        //Si no existe la tabla la crea, además inserta
        !comprobarLog() ? crearTabla("log", array("texto" => "varchar(255)")) : null;
        insertar("Log", array("texto" => $this->texto));
        $this->crearCookieSesion();
        //Aquí debería llamar al destructor
        $this->__destruct();
    }

    private function crearCookieSesion() {
        $fechaActualObjeto = new DateTime();
        $fechaActualString = $fechaActualObjeto->format('Y-m-d H:i:s');
        setcookie("ultCone", $fechaActualString, time() + 3000, 'localhost');
    }

    public function __destruct() {
        // Lógica del destructor (si es necesario)
        // Puedes realizar acciones de limpieza o liberar recursos aquí
    }
}
