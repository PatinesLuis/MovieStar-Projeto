<?php

require_once("models/Movie.php");
require_once("models/Message.php");
require_once("dao/userDAO.php");
require_once("dao/MovieDAO.php");
require_once("globals.php");
require_once("db.php");


$message = new Message($BASE_URL);
$userDao = new userDAO($conn, $BASE_URL);
$movieDAO = new MovieDAO($conn, $BASE_URL);

$type = filter_input(INPUT_POST,"type");

//resgata dados do usuario
$userData = $userDao->verifyToken();

if($type === "create"){

    //RECEBER DADOS DOS INPUT

    $title = filter_input(INPUT_POST,"title");
    $description = filter_input(INPUT_POST,"description");
    $trailer = filter_input(INPUT_POST,"trailer");
    $category = filter_input(INPUT_POST,"category");
    $length = filter_input(INPUT_POST,"length");

    $movie = new Movie();

    //validação minima de dados

    if(!empty($title) && !empty($description) && !empty($category)){

         $movie->title = $title;
         $movie->description = $description; 
         $movie->trailer = $trailer; 
         $movie->category = $category; 
         $movie->length = $length; 
         $movie->user_id = $userData->id;

            // Upload de imagem do filme
      if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

        $image = $_FILES["image"];
        $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
        $jpgArray = ["image/jpeg", "image/jpg"];

        // Checando tipo da imagem
        if(in_array($image["type"], $imageTypes)) {

          // Checa se imagem é jpg
          if(in_array($image["type"], $jpgArray)) {
            $imageFile = imagecreatefromjpeg($image["tmp_name"]);
          } else {
            $imageFile = imagecreatefrompng($image["tmp_name"]);
          }

          // Gerando o nome da imagem
          $imageName = $movie->imageGenerateName();

          imagejpeg($imageFile, "./img/movie/" . $imageName, 100);

          $movie->image = $imageName;

    } else {  
        $message->setMessage("Tipo de imagem inválido", "msg-error", "back");
    }
}

// Salva os dados do filme no banco
$movieDAO->create($movie);
    }else{
        $message->setMessage("Você precisa adicionar pelo menos; titulo, descrição e categoria.", "msg-error","back");
    }

    
}elseif($type === "delete"){
  $id = filter_input(INPUT_POST,"id");

  $movie = $movieDAO->findById($id);

  if($movie){

    //verificar se o filme é do usuario
    if($movie->user_id === $userData->id){
      
      $movieDAO->destroy($movie->id);

  }else{
    $message->setMessage("informações invalidas", "msg-error","index.php");
  }
}

}else{
    $message->setMessage("informações invalidas", "msg-error","index.php");
}