<?php

class VendedorDTO {
    
    public $id;
    public $nombre;
    public $email;

    public function __construct($id, $nombre, $email) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
    }

    public function toJson() {
        return json_encode($this);
    }
}
?>