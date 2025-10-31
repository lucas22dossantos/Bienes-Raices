<?php

namespace App;

class Propiedad extends ActiveRecord
{
    protected static $tabla = 'propiedades';
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedorid'];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedorid;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('y/m/d');
        $this->vendedorid = $args['vendedores_id'] ?? '';
    }

    public function validar()
    {
        if (!$this->titulo) {
            self::$errores[] = "El campo titulo es obligatorio";
        }
        if (!$this->precio) {
            self::$errores[] = "El campo precio es obligatorio";
        }
        // Validar imagen solo cuando se crea una nueva propiedad
        if (!$this->id && !$this->imagen) {
            self::$errores[] = "El campo de imagen es obligatorio";
        }
        if (!$this->descripcion || strlen($this->descripcion) < 50) {
            self::$errores[] = "El campo descripcion es obligatorio y debe tener al menos 50 caracteres";
        }
        if (!$this->habitaciones) {
            self::$errores[] = "El campo habitaciones es obligatorio";
        }
        if (!$this->wc) {
            self::$errores[] = "El campo baños es obligatorio";
        }
        if (!$this->estacionamiento) {
            self::$errores[] = "El campo estacionamiento es obligatorio";
        }
        if (!$this->vendedorid) {
            self::$errores[] = "El campo vendedor es obligatorio";
        }

        return static::$errores;
    }
}
