<?php

class Actor {

    // Atributos de la clase Actor
    public $id;
    public $nombre;
    public $apellidos;
    public $fotografia;

    // Método constructor para inicializar el actor con sus atributos
    public function __construct($id, $nombre, $apellidos, $fotografia) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->fotografia = $fotografia;
    }

    // Otros métodos de la clase Actor (si es necesario)
    public function obtenerNombreCompleto() {
        return $this->nombre . ' ' . $this->apellidos;
    }

    public function __toString() {
        return "Actor[id={$this->id}, nombre={$this->nombre}, apellidos={$this->apellidos}]";
    }

    public function __destruct() {
        // Código de limpieza, si es necesario
    }
}
