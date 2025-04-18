<?php
    require_once("globals.php");
    require_once("db.php");
    require_once("models/Message.php");
    require_once("DAO/userDAO.php");

    $message = new Message($BASE_URL);

    $flashMessage = $message->getMessage();

    if(!empty ($flashMessage["msg"])){
        //limpar msg
        $message->clearMessage();
    }

    $userDao = new UserDAO($conn, $BASE_URL);

    $userData = $userDao->verifyToken(false);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Star</title>
    <link rel="short icon" href="<?= $BASE_URL?>img/moviestar.ico" />
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.css" integrity="sha512-VcyUgkobcyhqQl74HS1TcTMnLEfdfX6BbjhH8ZBjFU9YTwHwtoRtWSGzhpDVEJqtMlvLM2z3JIixUOu63PNCYQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS do projeto -->
     <link rel="stylesheet" href="<?= $BASE_URL?>/css/style.css">
     <!-- font  -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

    <header>
    <nav id="main-navbar" class="navbar navbar-expand-lg">
      <a href="<?= $BASE_URL ?>" class="navbar-brand">
        <img src="<?= $BASE_URL ?>img/logo.svg" alt="MovieStar" id="logo">
        <span id="moviestar-title">MovieStar</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
  <i class="fas fa-bars"></i>
</button>
            <form action="<?= $BASE_URL ?>search.php" method="GET" id="search-form" class="form-inline my-2 my-lg-0">
        <input type="text" name="q" id="search" class="form-control mr-sm-2" type="search" placeholder="Buscar Filmes" aria-label="Search">
                <button class="btn my-2 my-sm-0" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav">
                    <?php if($userData): ?>
                        <li class="nav-item">
                        <a href="<?= $BASE_URL?>newmovie.php" class="nav-link"> 
                            <i class="far fa-plus-square"></i>incluir filme
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $BASE_URL?>dashboard.php" class="nav-link"> meus filmes</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $BASE_URL?>editprofile.php" class="nav-link bold"><?= $userData->name?></a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $BASE_URL?>logout.php" class="nav-link"> Sair</a>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a href="<?= $BASE_URL?>auth.php" class="nav-link"> entrar / cadastrar</a>
                    </li>
                    <?php endif ?>
                    
                </ul>
            </div>
        </nav>
    </header>

<?php if(!empty($flashMessage["msg"])): ?>
    <div class="msg-container">
        <p class="msg <?= $flashMessage['type'] ?>"><?= $flashMessage['msg'] ?></p>
    </div>
<?php endif;?>


