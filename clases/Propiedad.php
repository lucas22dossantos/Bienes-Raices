<?php

namespace App;

class Propiedad
{

    // base de datos
    protected static $db;
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedorid'];

    // errores
    protected static $errores = [];

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

    //definir la conexión a la base de datos
    public static function setDB($database)
    {
        self::$db = $database;
    }

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

    // metodo guardar para actualizar o crear registros
    public function guardar()
    {
        if (isset($this->id)) {
            //actualizamos
            $this->actualizar();
        } else {
            //creamos un nuevo registro
            $this->crear();
        }
    }

    // Método crear para insertar un nuevo registro en la base de datos
    public function crear()
    {

        //sanitizar los datos
        $atributos = $this->sanitizarDatos();

        $stmt = self::$db->prepare("INSERT INTO propiedades 
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

    public function actualizar()
    {
        // Sanitizar los datos
        $atributos = $this->sanitizarDatos();

        // Preparar la consulta SQL
        $stmt = self::$db->prepare("UPDATE propiedades SET 
        titulo = ?, 
        precio = ?, 
        imagen = ?, 
        descripcion = ?, 
        habitaciones = ?, 
        wc = ?, 
        estacionamiento = ?, 
        creado = ?, 
        vendedores_id = ? 
        WHERE id = ? 
        LIMIT 1");

        // Enlazar los parámetros
        $stmt->bind_param(
            "sissiiisii",
            $this->titulo,
            $this->precio,
            $this->imagen,
            $this->descripcion,
            $this->habitaciones,
            $this->wc,
            $this->estacionamiento,
            $this->creado,
            $this->vendedorid,
            $this->id
        );

        // Ejecutar la consulta
        $stmt->execute();

        // Retornar true si se actualizó al menos una fila
        return $stmt->affected_rows > 0;
    }

    public function eliminar()
    {
        // Elimina la propiedad
        $query = 'DELETE FROM propiedades WHERE id = ' . self::$db->escape_string($this->id) . ' LIMIT 1';
        $resultado = self::$db->query($query);

        if ($resultado) {
            $this->borrarImagen();
            header('Location: /admin?resultado=3');
        }
    }

    public function atributos()
    {
        $atributos = [];
        foreach (self::$columnasDB as $columna) {
            if ($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarDatos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->real_escape_string($value);
        }
        return $sanitizado;
    }

    // subida de archivo
    public function setImagen($imagen)
    {
        // Elimina la imagen previa
        if (isset($this->id)) {
            $this->borrarImagen();
        }

        // Asignar el nombre de la imagen al atributo
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }

    public function borrarImagen()
    {
        // Elimina la imagen previa
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if ($existeArchivo) {
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }

    // validacion
    public static function getErrores()
    {
        return self::$errores;
    }


    public function validar()
    {
        if (!$this->titulo) {
            self::$errores[] = "El campo titulo es obligatorio";
        }
        if (!$this->precio) {
            self::$errores[] = "El campo precio es obligatorio";
        }
        if (!$this->imagen) {
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


        return self::$errores;
    }

    // Listar todas los registros
    public static function todas()
    {
        $query = "SELECT * FROM propiedades";

        return self::consultarSQL($query);
    }

    // buscar una registro por su id
    public static function encontrar($id)
    {
        $consulta = "SELECT * FROM propiedades WHERE id =" . $id . ";";
        $resultado = self::consultarSQL($consulta);
        // return !empty($resultado) ? $resultado[0] : null;
        return array_shift($resultado);
    }


    public static function consultarSQL($query)
    {
        // consultar la base de datos
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = self::crearObjeto($registro);
        }

        //Liberar la memoria
        $resultado->free();

        // Retornarn los resultados
        return $array;
    }

    protected static function crearObjeto($registro)
    {
        $objeto = new self;

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }


    // sincronizar el objeto en memoria con los cambios realizados por el usuario
    public function sincronizar($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}
