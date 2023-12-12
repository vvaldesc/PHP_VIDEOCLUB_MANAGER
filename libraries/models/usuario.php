<?php

class Usuario {

    // Atributos de la clase Usuario
    public $id;
    public $username;
    public $password;
    public $rol;

    // Método constructor para inicializar el usuario con sus atributos
    public function __construct($id, $username, $password, $rol) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->rol = $rol;
    }

    // Otros métodos de la clase Usuario (si es necesario)
    public function esAdmin() {
        return $this->rol === 'admin';
    }

    public function __toString() {
        return "Usuario[id={$this->id}, username={$this->username}, rol={$this->rol}]";
    }

    public function __destruct() {
        // Código de limpieza, si es necesario
    }
}
