<?php

class PedidoDTO {
    public $cliente;
    public $vendedor;
    public $fecha;
    public $estado;
    public $lineas;

    public function __construct($cliente, $vendedor, $fecha, $estado, $lineas = []) {
        $this->cliente = $cliente;
        $this->vendedor = $vendedor;
        $this->fecha = $fecha;
        $this->estado = $estado;
        $this->lineas = $lineas;
    }

    public function toArray() {
        return [
            "cliente" => $this->cliente,
            "vendedor" => $this->vendedor,
            "fecha" => $this->fecha,
            "estado" => $this->estado,
            "lineas" => $this->lineas
        ];
    }
}
?>
