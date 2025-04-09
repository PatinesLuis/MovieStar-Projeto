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
$movieDAO = new MovieDAO($conn, $BASE_URL);

$type = filter_input(INPUT_POST,"POST");

$userData = $userDao->verifyToken();

if($type === "create"){

    $rating = filter_input(INPUT_POST,"rating");
    $review = filter_input(INPUT_POST,"review");
    $movies_id = filter_input(INPUT_POST,"movies_id");

    $reviewObject = new Review;

    $movieData = $movieDao->findById($id);

    


}else{
    $message->setMessage("informações invalidas", "msg-error","index.php");
}