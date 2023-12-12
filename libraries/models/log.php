<?php

class Log {

    private $texto;

    public function __construct($id, $username, $error) {
        $fechaHora = date('Y-m-d H:i:s');
        if ($error) {
            $this->texto = "[$fechaHora] ERROR: Intento de inicio de sesión fallido para el usuario {$username}.";
        } else {
            $this->texto = "[$fechaHora] El usuario {$username} [{$id}] ha iniciado sesión correctamente.";
        }
    }
}
