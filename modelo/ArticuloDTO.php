<?php

class ArticuloDTO {
    
    public $id;
    public $nombre;
    public $email; 
    public $telefono;

    public function __construct($id, $nombre, $email, $telefono) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->telefono = $telefono;
    }

    public function toJson() {
        return json_encode($this);
    }
}
?>