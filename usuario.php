<?php

    require 'includes/app.php';

    $email = "correo@gmail.com";
    $password = "123456";

    $passwordHash = password_hash($password, PASSWORD_BCRYPT);


    $query = "INSERT INTO usuarios (email, password) VALUES ('${email}','${passwordHash}'); ";
    
    mysqli_query($db , $query);
?>