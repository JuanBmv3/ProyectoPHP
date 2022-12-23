<?php

    function conectarDB(): mysqli{
        $db = new mysqli('127.0.0.1', 'root', 'supermegajuan190', 'bienesraices_crud');

        if(!$db){
            echo "Error no se pudo conectar a la BD";

            exit;

        }
        

        return $db;
        
        
    }

?>