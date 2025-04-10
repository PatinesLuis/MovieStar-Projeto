<?php
require_once("globals.php");
require_once("db.php");
require_once("models/Movie.php");
require_once("models/Message.php");
require_once("models/Review.php");
require_once("dao/userDAO.php");
require_once("dao/MovieDAO.php");
require_once("dao/ReviewDAO.php");


$message = new Message($BASE_URL);
$userDao = new userDAO($conn, $BASE_URL);
$movieDao = new MovieDAO($conn, $BASE_URL);
$reviewDao = new ReviewDAO($conn, $BASE_URL);

$type = filter_input(INPUT_POST, "type");

$userData = $userDao->verifyToken();

if($type === "create"){

    $rating = filter_input(INPUT_POST,"rating");
    $review = filter_input(INPUT_POST,"review");
    $movies_id = filter_input(INPUT_POST,"movies_id");

    $reviewObject = new Review();

    $movieData = $movieDao->findById($movies_id);

    

    //verificar se o filme existe
    if($movieData){
        //verificar dados minimos
        if(!empty($rating) && !empty($review) && !empty($movies_id)){

            $reviewObject->rating = $rating;
            $reviewObject->review = $review;
            $reviewObject->movies_id = $movies_id;
            $reviewObject->users_id = $userData->id; // <-- Aqui é a correção

            $reviewDao->create($reviewObject);


        }else{
            $message->setMessage("você precisa inserir a nota e um comentário", "msg-error","back");
        }

    }else{
        $message->setMessage("informações invalidas 1", "msg-error","index.php");
    }

    


}else{
    $message->setMessage("informações invalidas 2", "msg-error","index.php");
}