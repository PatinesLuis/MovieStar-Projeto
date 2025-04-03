<?php
    require_once("templates/header.php");

    require_once("models/movie.php");
    require_once("dao/MovieDAO.php");
    include_once("models/Message.php");

    //pegar o id do filme

    $id = filter_input(INPUT_GET,"id");

    $movie;

    $movieDao = new MovieDAO($conn,$BASE_URL);

    if(empty($id)){
        $message->setMessage("filme não encontrado!","msg-error","index.php");
    }else{
        $movie = $movieDao->findById($id);

        //verifica se o filme existe
        if(!$movie){
            $message->setMessage("filme não encontrado!","msg-error","index.php");
        }
    }

    //checar se o filme é do usuário

    $userOwnsMovie = false;

    if(!empty($userData)){
        if($userData->id === $movie->users_id){
            $userOwnsMovie = true;
        }
    }

    //resgatar as reviws do filme
?>

