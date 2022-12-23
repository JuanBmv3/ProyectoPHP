<?php
    require '../includes/app.php';
    incluirTemplate('header');
    autenticacion();
    
    use App\Propiedad;

    // Muestra las propiedades
    $propiedades = Propiedad::all();
    

    // Si se registro...
    $registrado;
    $registrado =  $_GET['registrado'] ?? null;




    // PARA ELIMINAR


    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){


        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);


        if($id){

            //Find the row
            //$propiedad obtiene todos los parametros en su clase.
            $propiedad = Propiedad::find($id); 
            
            //Delete row : parameter -> id
           

            // $resultado = mysqli_query($db, $query);
            // $propiedad = mysqli_fetch_assoc($resultado);
            // $query = "DELETE FROM propiedades where id = ${id}";
            // $resultado = mysqli_query($db, $query);

            if( $propiedad->delete()){
                header('Location: /bienesraices/admin?registrado=3');
            }
            
        }
    }


?>
    <style>
        table.propiedades{
            margin-top: 4rem;
            width: 100%;
            border-spacing: 0;
        }

        thead{
            background-color: green;
        }

        thead th{
            color: white;
            padding: 2rem;
            border-right: 1px solid black;
        }
        .imagen-tabla{
            width: 15rem;
            display: inline;
        }

        tbody th:first-child{
            color: green;
            border-bottom: 2px solid green;
        }
        

        tbody th{
            color: gray;
            border-bottom: 2px solid white;
            padding-bottom: 15px;
        }

       
       

    </style>
    <main class="contenedor seccion">
        <h1>Administrador de Bienes Raices</h1>

        
        <?php if( intval($registrado) === 1){ 
            echo '<h2 style="color: green; font-weight: bold" >El registro se ha creado </h2>';
        }else if( intval($registrado) === 2){
            echo '<h2 style="color: green; font-weight: bold" >El registro se ha actualizado </h2>';
        }else if( intval($registrado) === 3){
            echo '<h2 style="color: green; font-weight: bold" >El registro se ha borrado </h2>';
        }?>

        <a href="propiedades/crear.php" style="border-radius:15px" class="boton boton-verde">Nueva Propiedad</a>

        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($propiedades as $propiedad){ 
                    $resultadoHTML = '<tr>
                                        <th>'.$propiedad->id.'</th>
                                        <th>'.$propiedad->titulo. '</th>
                                        <th> <img class="imagen-tabla" src="../imagenes/'.$propiedad->imagen. '" /> </th>
                                        <th>'.$propiedad->precio. '</th>
                                        <th> 
                                            <form method = "POST" >
                                            <input type="hidden" name="id" value="'.$propiedad->id.'">
                                                <input type="submit" style="background-color: red; border-radius:15px;" class="boton-amarillo-block" value="Eliminar" />
                                            </form>
                                            <a href="propiedades/actualizar.php?id='.$propiedad->id.'"; style="border-radius:15px" class="boton-amarillo-block">Actualizar</a>
                                        </th>
                                        
                                    </tr>';

                    echo $resultadoHTML;
                } ?>
            </tbody>
        </table>
        
    </main>

   
<?php 

incluirTemplate('footer');
?>