<?php

namespace App;

class Propiedad
{

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacinamiento;
    public $creador;
    public $vendedorId;

    public function __construct($args = [])
    {
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacinamiento = $args['estacinamiento'] ?? '';
        $this->creador = $args['creador'] ?? '';
        $this->vendedorId = $args['vendedor_id'] ?? '';
    }
}
