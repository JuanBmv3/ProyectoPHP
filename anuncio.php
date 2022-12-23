<?php 

    require 'includes/app.php';
    incluirTemplate('header');

    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    $db = conectarBD();
    $query = "SELECT * FROM propiedades WHERE id = ${id}";

    $resultado = mysqli_query($db, $query);

    if(!$resultado->num_rows){ // Si no contiene rows la consulta
        header('Location: /bienesraices/');
    }

    $propiedad = mysqli_fetch_assoc($resultado);
    





    $resultadoHTML = '
        <main class="contenedor seccion contenido-centrado">
            <h1>'.$propiedad['titulo'].'</h1>

            <picture>
                <img loading="lazy" src="imagenes/'.$propiedad['imagen'].'" alt="imagen de la propiedad">
            </picture>

            <div class="resumen-propiedad">
                <p class="precio">$'.$propiedad['precio'].'</p>
                <ul class="iconos-caracteristicas">
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                        <p>'.$propiedad['wc'].'</p>
                    </li>
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                        <p>'.$propiedad['estacionamiento'].'</p>
                    </li>
                    <li>
                        <img class="icono"  loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                        <p>'.$propiedad['habitaciones'].'</p>
                    </li>
                </ul>

                <p>'.$propiedad['descripcion'].' </p>
            </div>
        </main>';

    echo $resultadoHTML;

    mysqli_close($db);
    incluirTemplate('footer');

?>