<?php
    require_once("templates/header.php");

    require_once("models/User.php");
    require_once("dao/UserDAO.php");
    require_once("dao/MovieDAO.php");

    $user = new User();
    $userDao = new userDAO($conn, $BASE_URL);
    $movieDao = new MovieDAO($conn, $BASE_URL);

    $id = filter_input(INPUT_GET,"id");

    if(empty($id)){

        if(!empty($userData)){

            $id = $userData->id;

        }else{
            $message->setMessage("Usuario não encontrado!", "msg-error","index.php");
        }
    }else{
        $userData = $userDao->findById($id);

        if(!$userData){
            $message->setMessage("Usuario não encontrado!", "msg-error","index.php");
        }
     
        

        if($userData->image == "") {
          $userData->image = "user.png";
        }
    }
    $fullName = $user->getFullName($userData);

    $userMovies = $movieDao->getMoviesByUserId($id);

?>

    <div id="main-container" class="container-fluid">
        <div class="col-md-8 offset-md-2">
            <div class="row profile-container">
                <div class="col-md-12 about-container">
                    <h1 class="page-title"><?= $fullName?></h1>
                    <div id="profile-image-container" class="profile-image" style="background-image: url('<?= $BASE_URL ?>img/users/<?= $userData->image ?>');"></div>
                    <h3 class="about-title">Sobre:</h3>
                    <?php if(!empty($userData->bio)):?>
                    <P class="profile-description"><?= $userData->bio?></P>
                    <?php else:?>
                        <P class="profile-description">O usuário não escreveu nada...</P>
                    <?php endif;?>  
                </div>
                <div class="col-md-12 added-movies-container">
                    <h3>Filmes que enviou:</h3>
                        <div class="movies-container">
                            <?php foreach($userMovies as $movie):?>
                                <?php require ("templates/movie_card.php"); ?>
                            <?php endforeach; ?>
                        <?php if(count($userMovies) === 0): ?>
                            <p class="empty-list">O usuario ainda não enviou filmes</p>
                        <?php endif;?>
                        </div>
                </div>
            </div>
        </div>
    </div>

<?php
    require_once("templates/footer.php");
?>