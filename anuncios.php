<?php 

require 'includes/app.php';
incluirTemplate('header');

?>
    <main class="contenedor seccion">

        <h2>Casas y Depas en Venta</h2>

        <div class="contenedor-anuncios">
        
        <?php 

            $limite = '';
            require 'includes/templates/template_anuncios.php';
        
        ?>
          

        </div> <!--.contenedor-anuncios-->
    </main>
<?php 


incluirTemplate('footer');

?>