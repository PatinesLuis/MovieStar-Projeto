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

    //upload de imagem
        if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
            $image = $_FILES["image"];
            $imageType = ["image/jpeg" , "image/jpg", "image/png"];
            $jpgArray = ["image/jpeg" , "image/jpg"];

            //checagem se é imagem
            if(in_array($image["type"],$imageType)){

                //checar se é pnj

                if(in_array($image["type"], $jpgArray)){
                    $imageFile = imagecreatefromjpeg($image["tmp_name"]);
                }else{
                 //png
                 $imageFile = imagecreatefrompng($image["tmp_name"]);
                }

                $imageName = $user->imageGenerateName();
                imagejpeg($imageFile, "./img/users/" . $imageName, 100);

                $userData->image = $imageName;
                
                

            }else{  
                $message->setMessage("tipo de imagem invalida", "msg-error","back");
            }
        }


    $userDao->update($userData);
}else if($type == "changepassword"){

}else{
    $message->setMessage("informações invalidas", "msg-error","index.php");
}