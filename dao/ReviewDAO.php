<?php

include_once("models/User.php");
include_once("models/Message.php");
include_once("dao/userDAO.php");

class userDAO implements ReviewDAOInterface{

    private $conn;
    private $url;
    private $message;

    public function __construct(PDO $conn, $url){
        $this->conn = $conn;
        $this->url = $url;
        $this->message = new Message($url);
    }

        public function buildReview($data){
            $reviewObject = new Review();

            $reviewObject->id = $data['id'];
            $reviewObject->rating = $data['rating'];
            $reviewObject->review = $data['review'];
            $reviewObject->users_id = $data['users_id'];
            $reviewObject->movies_id = $data['movies_id'];

            return $reviewObject;
        }

        public function create(Review $review){

        }

        public function getMoviesReview($id){

        }

        public function hasAlreadyReviewed($id, $userId){

        }

        public function getRatings($id){

        }

}