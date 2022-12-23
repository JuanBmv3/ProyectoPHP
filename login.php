<?php 
    require 'includes/app.php';
    incluirTemplate('header');

    $resultadoHTML = '';

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $required = array('email','password');
        $error = validarInputs($required);

        if($error){
            $resultadoHTML = '<h1 style="color:red; font-weight:bold">Todos los campos son requeridos</h1>';
        }else{
            $email = mysqli_real_escape_string($db,filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
            $password = mysqli_real_escape_string($db,$_POST['password']);
            

            $query = "SELECT * FROM usuarios WHERE email = '${email}'";

            $resultado = mysqli_query($db,$query);

            if($resultado->num_rows){
                $usuario = mysqli_fetch_assoc($resultado);

                $auth = password_verify($password,$usuario['password']);

                if($auth){
                    session_start();

                    $_SESSION['usuario'] = $usuario['email'];
                    $_SESSION['login'] = true;
                    
                    header('Location: /bienesraices/admin');

                }else{
                    $resultadoHTML = '<h1 style="color:red; font-weight:bold">El usuario o password no son correctos</h1>';
                }


            }else{
                $resultadoHTML = '<h1 style="color:red; font-weight:bold">El usuario o password no son correctos</h1>';
                
            }
        }
    }


?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Iniciar Sesión</h1>

        <form class="formulario" method="POST">
            <fieldset>
                <legend>Email y Password</legend>
                <?php 
                    echo $resultadoHTML;
                ?>
            
                <label for="email">Email:</label>
                <input type="email" name="email" placeholder="Coloca tu email">
                
                <label for="password">Password:</label>
                <input type="password" name="password" placeholder="Coloca tu contraseña">

                <input type="submit" class="boton boton-verde" value="Iniciar Sesión">
            </fieldset>


        </form>

    </main>

<?php 

incluirTemplate('footer');
?>