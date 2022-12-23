<?php 
    date_default_timezone_set('UTC');
    date_default_timezone_set("America/Mexico_City");

    require '../../includes/app.php';
    incluirTemplate('header');

    use App\Propiedad;
    use Intervention\Image\ImageManagerStatic as Image;

    autenticacion();
   
    //Vendendores
    $consultaVendedores = "SELECT id , CONCAT(nombre, ' ', apellido) as nombreCompleto  FROM vendedores";
    $resultadoVendedores = mysqli_query($db, $consultaVendedores);

    $resultado = '';
    $error = false;
    
    $propiedad = new Propiedad();
    

    if($_POST){

        $propiedad = new Propiedad($_POST);

        

        $error = validarInputs(array_keys($_POST)); 
        
        if(!$_FILES['imagen']['name']){
            $error = true;
        }
        

        if ($error) {
            $resultado = 'Todos los campos son requeridos';
        } else {

            
            if(!is_dir(IMAGENES_URL)){
                mkdir(IMAGENES_URL);
            }

            // generar un nombre unico
            $nombreImagen = md5(uniqid(rand(), true)). ".jpg";


            //Subir imagen
            $image = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 600); // Rescala la imagen
            $propiedad->setImagen($nombreImagen);

            $image->save(IMAGENES_URL.'/'.$nombreImagen);
            

            // INSERTAR

            if($propiedad->guardar()){
                header('Location: /bienesraices/admin?registrado=1');
            }else{
                $resultado = 'Ocurrio un error, consulta con administrador de la página';
            }
        }
    }

?>

    <main class="contenedor seccion">
        <h1>Crear</h1>
        
        <h1 style=" <?php echo $error ? 'color: red' : 'color: green'; ?>"><?php echo $resultado ?></h1>

        <form class="formulario " method="POST" action="crear.php" enctype="multipart/form-data">
            
            <?php include '../../includes/templates/formulario_propiedades.php' ?>
        
            <a href="../" class="boton boton-verde">Volver</a>
            <input type="submit" value="Crear Propiedad" class="boton boton-verde">
            
            
        </form>

    </main>

<?php 

incluirTemplate('footer');
?>