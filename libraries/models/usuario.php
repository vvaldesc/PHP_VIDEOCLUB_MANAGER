<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/Ejercicios_UT6_1_Victor_Valdes_Cobos/libraries/models/log.php';

class Usuario {

    // Atributos de la clase Usuario
    private $id;
    private $username;
    private $password;
    private $rol;

    // Método constructor para inicializar el usuario con sus atributos
    /**
     * 
     * @param string $id
     * @param string $username
     * @param string $password
     * @param string $rol
     * @param string $sesion_aux
     * @param boolean $registrarLog
     */
    public function __construct($id, $username=null, $password=null, $rol=null, &$sesion_aux, $registrarInstancia = true) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->rol = $rol;
        if ($registrarInstancia) {
            new Log($id, $username, $error = false) && $this->actualizarSesion($sesion_aux, true);
        }
        //$this->actualizarPost($_POST);
        //$this_>iniciarCookieSesion();
    }
    
    private function toArray(){
        return get_object_vars($this);
    }
    
    public function passwordHasher() {
        return $this->password = hash('sha512', $password);
    }

    public function __toString() {
        return "Usuario[id={$this->id}, username={$this->username}, rol={$this->rol}]";
    }

    /**
     * Uso esta función para actualizar soperglobales que me puedan ser de utilidad
     * a la hora de acceder a información de forma rápida, esta información estará encriptada
     * para que sea mínimamente seguro.
     * 
     * @param array $sesion_aux
     * @param type $tabla
     */
    public function actualizarSesion(&$sesion_aux,$encriptar) {
        //Encriptado
        if($encriptar===true) $this->rol = password_hash($this->rol, PASSWORD_BCRYPT);
        $sesion_aux['rol'] = $this->rol;
    }
    
    public function iniciarCookieSesion(&$sesion_aux) {
        setcookie("nombreSesion", $this->username, time() + 300, "/");
    }
    
    public function actualizarPost(&$post_aux) {
        //Encriptado
        $_POST["password"] = $this->password;
        $_POST["usr"] = $this->username;
    }
    
    public function __destruct() {
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
