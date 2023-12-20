<?php

class Pelicula {

    // Atributos de la clase
    private $id;
    private $titulo;
    private $genero;
    private $pais;
    private $anyo;
    private $cartel;

    // Método constructor para inicializar la película con sus atributos
    public function __construct($id, $titulo, $genero, $pais, $anyo, $cartel) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->genero = $genero;
        $this->pais = $pais;
        $this->anyo = $anyo;
        $this->cartel = $cartel;
    }
    
    public function toArray(){
        return get_object_vars($this);
    }
    
        // Getter y Setter para 'id'
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    // Getter y Setter para 'titulo'
    public function getTitulo() {
        return $this->titulo;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    // Getter y Setter para 'genero'
    public function getGenero() {
        return $this->genero;
    }

    public function setGenero($genero) {
        $this->genero = $genero;
    }

    // Getter y Setter para 'pais'
    public function getPais() {
        return $this->pais;
    }

    public function setPais($pais) {
        $this->pais = $pais;
    }

    // Getter y Setter para 'anyo'
    public function getAnyo() {
        return $this->anyo;
    }

    public function setAnyo($anyo) {
        $this->anyo = $anyo;
    }

    // Getter y Setter para 'cartel'
    public function getCartel() {
        return $this->cartel;
    }

    public function setCartel($cartel) {
        $this->cartel = $cartel;
    }

    // Otros métodos de la clase (si es necesario)
    public function toString() {
        return "ID: {$this->id}, Título: {$this->titulo}, Género: {$this->genero}, País: {$this->pais}, Año: {$this->anyo}";
    }

    public function __destruct() {
        // Código de limpieza, si es necesario
    }
}
