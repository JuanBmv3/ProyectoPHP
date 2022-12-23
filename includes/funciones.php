<?php


define('TEMPLATES_URL', __DIR__.'/templates');
define('FUNCIONES_URL', __DIR__.'funciones.php');
define('IMAGENES_URL', __DIR__.'../../imagenes');



function incluirTemplate(string $nombre, bool $inicio = false){

    include  TEMPLATES_URL."/${nombre}.php";
}

function validarInputs(array $inputs): bool{

        // Loop over field names, make sure each one exists and is not empty
        
        foreach($inputs as $field) {
            if (empty($_POST[$field])) {
                return true;
            }
        }

        return false;

}

function autenticacion(){

    if(!$_SESSION['login']){
        header('Location: /bienesraices/login.php');
    }
}


function debuguear($variable){
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

function s($html): string{
    return htmlspecialchars($html);
}

?>