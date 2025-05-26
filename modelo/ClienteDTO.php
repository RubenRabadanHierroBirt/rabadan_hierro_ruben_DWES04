<?php

class ClienteDTO {
    
    public $id;
    public $nombre;
    public $email;
    public $direccion;

    public function __construct($id, $nombre, $email, $direccion) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->direccion = $direccion;
    }

    public function toJson() {
        return json_encode($this);
    }
}
?>