<?php 

$query = "SELECT * FROM propiedades ${limite}";

$resultado = mysqli_query($db, $query);


    while($propiedades = mysqli_fetch_assoc($resultado)){

        $string =  $propiedades['descripcion']; //almaceno
        $array_str = explode(' ',$string);  //transformo el string a  un array
        $descripcion_final = implode(' ', array_slice($array_str,0,15));
        //aqui hago la operacion para obtener solo las palabras que necesito del array string 0 - 15
        

        $resHTLM = '<div class="anuncio">
            <picture>
                <img loading="lazy" src="imagenes/'.$propiedades['imagen'].'" alt="anuncio">
            </picture>

            
            <div class="contenido-anuncio">
                <h3>'.$propiedades['titulo'].'</h3>
                <p>'.$descripcion_final.'...</p>
                <p class="precio">$'.$propiedades['precio'].'</p>

                <ul class="iconos-caracteristicas">
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                        <p>'.$propiedades['wc'].'</p>
                    </li>
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                        <p>'.$propiedades['estacionamiento'].'</p>
                    </li>
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                        <p>'.$propiedades['habitaciones'].'</p>
                    </li>
                </ul>

                <a href="anuncio.php?id='.$propiedades['id'].'" class="boton-amarillo-block">
                    Ver Propiedad
                </a>
            </div><!--.contenido-anuncio-->
        </div><!--anuncio-->';

        echo $resHTLM;
    }

    mysqli_close($db);
?>