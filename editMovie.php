<?php
    require_once("templates/header.php");

    require_once("models/User.php");
    require_once("dao/UserDAO.php");
    require_once("dao/MovieDAO.php");

  $user = new User();
  $userDao = new UserDao($conn, $BASE_URL);

  $userData = $userDao->verifyToken(true);

  $movieDao = new MovieDAO($conn, $BASE_URL);

  $id = filter_input(INPUT_GET,"id");

  if(empty($id)){
    $message->setMessage("filme não encontrado!","msg-error","index.php");
}else{
    $movie = $movieDao->findById($id);

    //verifica se o filme existe
    if(!$movie){
        $message->setMessage("filme não encontrado!","msg-error","index.php");
    }
}

if($movie->image == "") {
    $movie->image = "movie_cover.jpg";
  }
?>

<div id="main-container" class="container-fluid">
           <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 offset-md-1">
                    <h1><?= $movie->title ?></h1>
                    <p class="page-description">Altere os dados do filme no formulário abaixo:</p>
                    <form id="edit-movie-form" action="<?= $BASE_URL?>movie_process.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="type" value= "update">
                    <input type="hidden" name="id" value= "<?=$movie->id?>">
                    <div class="form-group">
                        <label for="title">Titulo:</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Digite o titulo do filme" value="<?=$movie->title?>">
                    </div>
                    <div class="form-group">
                        <label for="image">imagem:</label>
                        <input type="file" name="image" id="image" class="form-control-file">
                    </div>
                    <div class="form-group">
                        <label for="length">Duração:</label>
                        <input type="text" class="form-control" id="length" name="length" placeholder="Duração do filme" value="<?=$movie->length?>">
                    </div>
                    <div class="form-group">
                        <label for="category">categoria:</label>
                        <select name="category" id="category" class="form-control">
                            <option value="">Selecione</option>
                            <option value="ação" <?=$movie->category === "ação" ? "selected" : "" ?>>Ação</option>
                            <option value="comédia" <?=$movie->category === "comédia" ? "selected" : "" ?>>comédia</option>
                            <option value="suspense" <?=$movie->category === "suspense" ? "selected" : "" ?>>suspense</option>
                            <option value="terror"<?=$movie->category === "terror" ? "selected" : "" ?>>terror</option>
                            <option value="ficção"<?=$movie->category === "ficção" ? "selected" : "" ?>>ficção</option>
                            <option value="drama"<?=$movie->category === "drama" ? "selected" : "" ?>>drama</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="trailer">trailer:</label>
                        <input type="text" class="form-control" id="trailer" name="trailer" placeholder="Insira o link do trailer" value="<?=$movie->trailer?>">
                    </div>
                    <div class="form-group">
                        <label for="description">descrição:</label>
                        <textarea class="form-control" name="description" row="5" id="description" placeholder="descreva o filme"><?=$movie->description?></textarea>
                    </div>
                    <input type="submit" value="Editar filme" class="btn card-btn">
                    </form>
                </div>
                <div class="col-md-3">
                    <div class="movie-image-container" style="background-image: url('<?=$BASE_URL?>img/movie/<?= $movie->image?>')"></div>
                </div>
            </div>
           </div>
    </div>

    

<?php
    require_once("templates/footer.php")
?>