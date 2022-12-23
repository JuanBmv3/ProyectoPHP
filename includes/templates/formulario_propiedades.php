<fieldset>
    <legend>Informacion General</legend>

    <label for="titulo">Titulo:</label>
    <input type="text" name="titulo" id="titulo" placeholder="Titulo Propiedad" value="<?php echo s($propiedad->titulo) ?>">

    <label for="precio">Precio:</label>
    <input type="number" name="precio" id="precio" placeholder="Precio Propiedad" value="<?php echo s($propiedad->precio) ?>"> 

    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" name="imagen" >
    
    <?php 
        if($propiedad->imagen){
            echo '<img src="/bienesraices/imagenes/'.$propiedad->imagen.'" class="imagen-small"> ';
        }
    ?>

    <label for="descripcion">Descripcion:</label>
    <textarea name="descripcion" id="descripcion" cols="30" rows="10"><?php echo s($propiedad->descripcion) ?></textarea>

</fieldset>


<fieldset>
    <legend>Información Propiedad</legend>

    <label for="habitaciones">Habitaciones:</label>
    <input type="number" name="habitaciones" id="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($propiedad->habitaciones) ?>">

    <label for="wc">Baños:</label>
    <input type="number" name="wc" id="wc" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($propiedad->wc) ?>">

    <label for="estacionamiento">Estacionamiento:</label>
    <input type="number" name="estacionamiento" id="estacionamiento" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($propiedad->estacionamiento) ?>">

</fieldset>
            
<fieldset>
    <legend>Vendedor</legend>

    <select name="vendedores_id" id="vendedor">

        <?php while($row = mysqli_fetch_assoc($resultadoVendedores)){ ?>
                <option value="<?php echo $row['id']?>" <?php echo $propiedad->id === $row['id'] ? 'selected': '' ?> > <?php echo $row['nombreCompleto'] ?></option> 
        <?php } ?>
        
    </select>
</fieldset>