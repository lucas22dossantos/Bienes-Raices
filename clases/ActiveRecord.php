<?php

/**
 *Esto es para que reconozcan las propiedades y eviten mostrar advertencias falsas.
 * 
 * @property int|null $id
 * @property string $titulo
 * @property string $precio
 * @property string $imagen
 * @property string $descripcion
 * @property int $habitaciones
 * @property int $wc
 * @property int $estacionamiento
 * @property string $creado
 * @property int $vendedorid
 */

namespace App;

class ActiveRecord
{
    // base de datos
    protected static $db;
    protected static $columnasDB = [];

    protected static $tabla = '';
    // errores
    protected static $errores = [];

    //definir la conexión a la base de datos
    public static function setDB($database)
    {
        self::$db = $database;
    }

    // metodo guardar para actualizar o crear registros
    public function guardar()
    {
        if (!is_null($this->id)) {
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

        $stmt = self::$db->prepare("INSERT INTO " . static::$tabla . " 
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

        if ($stmt->affected_rows > 0) {
            header('Location: /admin?resultado=1');
            exit;
        }

        // return $stmt->affected_rows > 0;
    }

    public function actualizar()
    {
        // Sanitizar los datos
        $atributos = $this->sanitizarDatos();

        // Preparar la consulta SQL
        $stmt = self::$db->prepare("UPDATE " . static::$tabla . " SET 
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

        if ($stmt->affected_rows > 0) {
            header('Location: /admin?resultado=2');
            exit;
        }
    }

    public function eliminar()
    {
        // Elimina la propiedad
        $query = 'DELETE FROM ' . static::$tabla . ' WHERE id = ' . self::$db->escape_string($this->id) . ' LIMIT 1';
        $resultado = self::$db->query($query);

        if ($resultado) {
            $this->borrarImagen();
            header('Location: /admin?resultado=3');
        }
    }

    public function atributos()
    {
        $atributos = [];
        foreach (static::$columnasDB as $columna) {
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
        if (!is_null($this->id)) {
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
        return static::$errores;
    }


    public function validar()
    {
        static::$errores = [];
        return static::$errores;
    }

    // Listar todas los registros
    public static function todas()
    {
        $query = "SELECT * FROM " . static::$tabla . ";";

        return self::consultarSQL($query);
    }

    // buscar una registro por su id
    public static function encontrar($id)
    {
        $consulta = "SELECT * FROM " . static::$tabla . " WHERE id =" . $id . ";";
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
            $array[] = static::crearObjeto($registro);
        }

        //Liberar la memoria
        $resultado->free();

        // Retornarn los resultados
        return $array;
    }

    protected static function crearObjeto($registro)
    {

        $objeto = new static;

        foreach ($registro as $key => $value) {

            if ($key === 'vendedores_id') {
                $objeto->vendedorid = $value;
                continue;
            }
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
