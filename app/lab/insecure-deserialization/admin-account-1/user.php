<?php

class User {
    private $username;
    private $password;

    public function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    public function getUsername() {
        return $this->username;
    }

    // Implementa otras funciones necesarias

    public function is_valid_signature() {
        // Implementa la validación de la firma aquí
        // Devuelve true si la firma es válida, false de lo contrario
    }
}


?>