<?php

include_once("models/User.php");
include_once("models/Message.php");
include_once("dao/userDAO.php");
include_once("models/Review.php");

class ReviewDAO implements ReviewDAOInterface{

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

            $stmt = $this->conn->prepare(
                "INSERT INTO reviews (rating,review, users_id, movies_id)
                VALUES (
                :rating, :review, :users_id, :movies_id)"
            );

            $stmt->bindParam(":rating", $review->rating);
            $stmt->bindParam(":review", $review->review);
            $stmt->bindParam(":users_id", $review->users_id);
            $stmt->bindParam(":movies_id", $review->movies_id);


            $stmt->execute();

            $this->message->setMessage("Critica adicionado com sucesso com sucesso", "msg-success","index.php");

        }

        public function getMoviesReview($id){

            $reviews = [];

            $stmt = $this->conn->prepare("SELECT * FROM reviews WHERE movies_id = :movies_id");
            $stmt->bindParam(":movies_id", $id);
            $stmt->execute();

            // verifica se retornou algo
            if($stmt->rowCount()> 0){
                $reviewsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $userDao = new UserDAO($this->conn, $this->url);

                foreach($reviewsData as $review){

                    $reviewObject = $this->buildReview($review);
                    
                    //chamar dados do usuario
                    $user = $userDao->findById($reviewObject->users_id);

                    $reviewObject->user = $user;
                    $reviews[] = $reviewObject;
                }

            }
                return $reviews;
            
        }

        public function hasAlreadyReviewed($id, $userId){
            
            $stmt = $this->conn->prepare("SELECT * FROM reviews WHERE movies_id = :movies_id AND 
            users_id = :users_id
            ");

            $stmt->bindPAram(":movies_id", $id);
            $stmt->bindPAram(":users_id", $userId);
            $stmt->execute();

            if($stmt->rowCount()>0){
                return true;
            }else{
                return false;
            }
        }

        public function getRatings($id){

            $stmt = $this->conn->prepare("SELECT * FROM reviews WHERE movies_id = :movies_id");

            $stmt->bindParam(":movies_id", $id);

            $stmt->execute();

            if($stmt->rowCount() > 0){
                $rating = 0;

                $reviews = $stmt->fetchAll();

                foreach($reviews as $review){
                    $rating += $review["rating"];
                }

                $rating = $rating / count($reviews);


            }else{
                $rating = "Não avaliado";
            }

            return $rating;

        }

}