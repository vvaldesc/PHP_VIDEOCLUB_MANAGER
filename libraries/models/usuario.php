<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/Ejercicios_UT6_1_Victor_Valdes_Cobos/libraries/models/log.php';

class Usuario {

    // Atributos de la clase Usuario
    private $id;
    private $username;
    private $password;
    private $rol;
    private $log;

    // Método constructor para inicializar el usuario con sus atributos
    public function __construct($id, $username, $password, $rol) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->rol = $rol;
        $this->log = new Log($id, $username, $error = false);
    }

    public function __toString() {
        return "Usuario[id={$this->id}, username={$this->username}, rol={$this->rol}]";
    }

    public function actualizarSesion(&$sesion_aux,$tabla) {
        $sesion_aux['id'] = $tabla[0]["id"];
        $sesion_aux['username'] = $tabla[0]["username"];
        $sesion_aux['contraseña'] = $tabla[0]["password"];
        $sesion_aux['rol'] = $tabla[0]["rol"];
    }

    public function __destruct() {
        // Código de limpieza, si es necesario
    }
    
    
    // Getter para obtener el ID
    public function getId() {
        return $this->id;
    }

    // Setter para establecer el ID
    public function setId($id) {
        $this->id = $id;
    }

    // Getter para obtener el nombre de usuario
    public function getUsername() {
        return $this->username;
    }

    // Setter para establecer el nombre de usuario
    public function setUsername($username) {
        $this->username = $username;
    }

    // Getter para obtener la contraseña
    public function getPassword() {
        return $this->password;
    }

    // Setter para establecer la contraseña
    public function setPassword($password) {
        $this->password = $password;
    }

    // Getter para obtener el rol
    public function getRol() {
        return $this->rol;
    }

    // Setter para establecer el rol
    public function setRol($rol) {
        $this->rol = $rol;
    }

    // Getter para obtener el objeto Log
    public function getLog() {
        return $this->log;
    }

    // Setter para establecer el objeto Log
    public function setLog($log) {
        $this->log = $log;
    }

    // Otros métodos de la clase Usuario (si es necesario)

    public function esAdmin() {
        return $this->rol === 'admin';
    }    
    
    
    
}
