<?php

require_once("models/User.php");
require_once("models/Message.php");
require_once("dao/userDAO.php");
require_once("globals.php");
require_once("db.php");

$message = new Message($BASE_URL);
$userDao = new userDAO($conn, $BASE_URL);

$type = filter_input(INPUT_POST,"type");

if($type == "update"){

    //resgata dados do usuario
    $userData = $userDao->verifyToken();
    

    //recebe dados do post
    $name = filter_input(INPUT_POST, "name");
    $lastname = filter_input(INPUT_POST, "lastname");
    $email = filter_input(INPUT_POST, "email");
    $bio = filter_input(INPUT_POST, "bio");

    //criar novo objeto de usuario
    $user = new User();

    $userData ->name = $name;
    $userData ->lastname = $lastname;
    $userData ->email = $email;
    $userData ->bio = $bio;

    $userDao->update($userData);
}else if($type == "changepassword"){

}else{
    $message->setMessage("informações invalidas", "msg-error","index.php");
}