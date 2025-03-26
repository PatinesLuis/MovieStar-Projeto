<?php
    require_once("templates/header.php");

    require_once("DAO/userDAO.php");
    require_once("models/user.php");

    $user = new User();
    $userDao = new UserDAO($conn, $BASE_URL);

    $userData = $userDao->verifyToken(true);

    $fullname = $user->getFullName($userData);

    if($userData->image == ""){
        $userData->image = "user.png";
    }

?>

    <div id="main-container" class="container-fluid">
        
    <div class="col-md-12">
        <form action="<?= $BASE_URL?>users_process.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="" name="type" value="update">
            <div class="row">
                <div class="col-md-4">
                    <h1><?=$fullname?></h1>
                    <p class="page-description">ALtere seus dados no formulário abaixo</p>
                    <div class="form-group">
                        <label for="name">Nome:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Digite seu nome" value="<?= $userData->name?>">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Sobrenome:</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Digite seu nome" value="<?= $userData->lastname?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" readonly class="form-control disabled" id="email" name="email" placeholder="Digite seu nome" value="<?= $userData->email?>">
                    </div>

                    <input type="submit"  class="btn form-btn" value="alterar">

                </div>

                <div class="col-md-4">
                    <div id="profile-image-container" style="background-image: url('<?= $BASE_URL?>
                    img/users/<?= $userData->image?>')"> 
                    <div class="form-group">
                        <label for="image">Foto:</label>
                        <input type="file" class="form-control-file" name="image">
                    </div>
                    <div class="form-group">
                        <label for="bio">Sobre você:</label>
                       <textarea class="form-control" name="bio" id="bio" rows="5" placeholder="Conte sobre você"><?= $userData->bio?></textarea>
                    </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
    </div>

    

<?php
    require_once("templates/footer.php")
?>