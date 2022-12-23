<?php 
    use App\Propiedad;
    use Intervention\Image\ImageManagerStatic as Image;

    require '../../includes/app.php';
    incluirTemplate('header');

    autenticacion();


    // VALIDATE THE ID
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id){
        header('Location: /bienesraices/admin');
    }
    
    // VENDEDORES
    $consultaVendedores = "SELECT id , CONCAT(nombre, ' ', apellido) as nombreCompleto  FROM vendedores";
    $resultadoVendedores = mysqli_query($db, $consultaVendedores);


    //Information for properties

    $propiedad = Propiedad::find($id);
    $imagenPrev = $propiedad->imagen;
    $resultado = '';
    $error = false;

    
    // $consulta= "";
    // $resultadoPropiedades = mysqli_query($db, $consulta);
    // $propiedad = mysqli_fetch_assoc($resultadoPropiedades);
    

    
    // $titulo = $propiedad['titulo'];
    // $precio = $propiedad['precio'];
    // $descripcion = $propiedad['descripcion'];
    // $habitaciones = $propiedad['habitaciones'];
    // $wc = $propiedad['wc'];
    // $estacionamiento = $propiedad['estacionamiento'];
    // $vendedorID = $propiedad['vendedores_id'];
    // $imagenPropiedad = $propiedad['imagen'];


    if($_POST){

        $propiedad = new Propiedad($_POST);
        // $titulo = mysqli_real_escape_string($db,$_POST['titulo']);
        // $precio = mysqli_real_escape_string($db,$_POST['precio']);
        // $descripcion = mysqli_real_escape_string($db,$_POST['descripcion']);
        // $habitaciones = mysqli_real_escape_string($db,$_POST['habitaciones']);
        // $wc = mysqli_real_escape_string($db,$_POST['wc']);
        // $imagen = $_FILES['imagen'];
        // $creado = date("Y-m-d");
        // $estacionamiento = mysqli_real_escape_string($db,$_POST['estacionamiento']);
        // $vendedorID = mysqli_real_escape_string($db,$_POST['vendedor']);

        $error = validarInputs(array_keys($_POST)); 

        if ($error) {
            $resultado = 'Todos los campos son requeridos';
        } else {
            
            // Verify that the images folder exists, if not, create it
            if(!is_dir(IMAGENES_URL)){
                mkdir(IMAGENES_URL);
            }

            // When the variable imagen has the image, the passed image is deleted
            if($_FILES['imagen']['name']){
                //Deleted the image
                //Generate a unique id
                //Rescale the image and uploaded ( Dir = IMAGENES_URL)

                unlink(IMAGENES_URL.'/'.$imagenPrev);
                
                $nombreImagen = md5(uniqid(rand(), true)). ".jpg";

                $image = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 600); // Rescala la imagen
                $propiedad->setImagen($nombreImagen);

                // Subir la imagen
                $image->save(IMAGENES_URL.'/'.$nombreImagen);
                // move_uploaded_file($imagen['tmp_name'], $carpetaimagenes ."/". $nombreImagen);

            }else{
                // Save the previous image
                $propiedad->setImagen($imagenPrev);
            }


            // UPDATE

            if($propiedad->update($id)){
                header('Location: /bienesraices/admin?registrado=2');
            }else{
                $resultado = 'Ocurrio un error, consulta con administrador de la página';
            }


            // $query = "UPDATE propiedades SET titulo = '${titulo}' , precio = '${precio}',          
            //     descripcion = '${descripcion}', habitaciones = ${habitaciones}, wc = ${wc},
            //     estacionamiento = ${estacionamiento}, vendedores_id = '${vendedorID}', imagen='${nombreImagen}'
            //     WHERE id = ${id}
            // ";

            // $resDB = mysqli_query($db, $query);

            // if($resDB){
            //     header('Location: /bienesraices/admin?registrado=2');
            // }

        }
    }

    


 
?>

    <main class="contenedor seccion">
        <h1>Actualizar Propiedad</h1>
        
        <h1 style=" <?php echo $error ? 'color: red' : 'color: green'; ?>"><?php echo $resultado ?></h1>

        <form class="formulario " method="POST"  enctype="multipart/form-data">

            <?php include '../../includes/templates/formulario_propiedades.php' ?>

            <a href="../" class="boton boton-verde">Volver</a>
            <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
            
            
        </form>

    </main>

<?php 

incluirTemplate('footer');
?>