<?php 

namespace App;

class ActiveRecord{


    //BD
    protected static $db;
    protected static $tabla = '';
    
    public $titulo;
    public $id;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedores_id;

    public static function setDB($database){
        self::$db = $database;
    }
    
    public function __construct($args = []){ 
        $this->id = $args['id'] ?? '';
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date("Y-m-d");
        $this->vendedores_id = $args['vendedores_id'] ?? '';
    }

    public function guardar(){

        $atributos = $this->sanitizarAtributos();
     
        $keys = join(', ' , array_keys($atributos));
        $values = join("', '" , array_values($atributos));

        $query = "INSERT INTO propiedades (${keys}) VALUES ('${values}') ";
        $resultado = self::$db->query($query);

        return $resultado;


        
    }

    //Subir archivos
    public function setImagen ($imagen){

        if($imagen){
            $this->imagen = $imagen;
        }
    }

    

    public function sanitizarAtributos(){
        unset($this->id);
        $sanitizado = [];

        foreach( $this as $key => $value ){
            $sanitizado[$key] = self::$db->escape_string($value);
        }

        return $sanitizado;
    }

    public static function all(){
        
        $query = "SELECT * FROM " . static::$tabla;
        
        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    public static function consultarSQL($query){

        $resultado = self::$db->query($query);

        $array = [];

        while($registro = $resultado->fetch_assoc()){
            $array[] = self::crearObjeto($registro);
        }

        $resultado->free();

        return $array;
    }

    protected static function crearObjeto($registro){
        $objeto = new self();

        foreach ($registro as $key => $value) {
            if(property_exists($objeto, $key)){
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    public static function find($id){

        $query = "SELECT * FROM propiedades where id = ${id}";
        $resultado = self::consultarSQL($query);

        return array_shift($resultado);

    }

    public function update($id){
        $atributos = $this->sanitizarAtributos();

        unset($atributos['creado']);   
        
        $query = "UPDATE propiedades SET ";
        
        foreach ($atributos as $key => $value){
            $query .= $key . "='" . $value .  "',";
        }

        $query = substr($query, 0, -1);

        $query .= " WHERE id = " . self::$db->escape_string($id);
        
        return  self::$db->query($query);
 
    }

    public function delete(){

        $query = "DELETE FROM propiedades WHERE id = " . self::$db->escape_string($this->id);
        
        

        if(file_exists(IMAGENES_URL.'/'.$this->imagen)){
            unlink(IMAGENES_URL.'/'.$this->imagen);
        }

        return self::$db->query($query);
    
    }
}