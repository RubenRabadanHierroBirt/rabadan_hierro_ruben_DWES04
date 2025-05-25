<?php

class VendedorDTO {
    
    public $id;
    public $nombre;
    public $email;

    public function __construct($id, $nombre, $descripcion, $precio) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
    }

    public function toJson() {
        return json_encode($this);
    }
}
?>