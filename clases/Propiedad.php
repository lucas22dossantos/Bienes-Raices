<?php

namespace App;

class Propiedad
{

    // base de datos
    protected static $db;

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

    // Método guardar
    public function guardar($db)
    {
        $stmt = $db->prepare("INSERT INTO propiedades 
            (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, creado, vendedores_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param(
            "sissiiisi",
            $this->titulo,
            $this->precio,
            $this->imagen,
            $this->descripcion,
            $this->habitaciones,
            $this->wc,
            $this->estacionamiento,
            $this->creado,
            $this->vendedorid
        );

        $stmt->execute();

        return $stmt->affected_rows > 0;
    }

    //definir la conexión a la base de datos
    public static function setDB($database)
    {
        self::$db = $database;
    }
}
