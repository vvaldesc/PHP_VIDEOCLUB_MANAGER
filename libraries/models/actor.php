<?php

class Actor {

    // Atributos de la clase Actor
    private $id;
    private $nombre;
    private $apellidos;
    private $fotografia;

    // Método constructor para inicializar el actor con sus atributos
    public function __construct($id, $nombre, $apellidos, $fotografia) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->fotografia = $fotografia;
    }
    
    public function toArray(){
        return get_object_vars($this);
    }


    // Otros métodos de la clase Actor (si es necesario)
    public function obtenerNombreCompleto() {
        return $this->nombre . ' ' . $this->apellidos;
    }
    
        // Getter y Setter para 'id'
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    // Getter y Setter para 'nombre'
    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    // Getter y Setter para 'apellidos'
    public function getApellidos() {
        return $this->apellidos;
    }

    public function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    // Getter y Setter para 'fotografia'
    public function getFotografia() {
        return $this->fotografia;
    }

    public function setFotografia($fotografia) {
        $this->fotografia = $fotografia;
    }

    public function __toString() {
        return "Actor[id={$this->id}, nombre={$this->nombre}, apellidos={$this->apellidos}]";
    }

    public function __destruct() {
        // Código de limpieza, si es necesario
    }
}
