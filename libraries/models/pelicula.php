<?php

class Pelicula {

    // Atributos de la clase
    public $id;
    public $titulo;
    public $genero;
    public $pais;
    public $anyo;
    public $cartel;

    // Método constructor para inicializar la película con sus atributos
    public function __construct($id, $titulo, $genero, $pais, $anyo, $cartel) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->genero = $genero;
        $this->pais = $pais;
        $this->anyo = $anyo;
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
