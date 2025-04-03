<?php
    require_once("templates/header.php");

    require_once("models/User.php");
    require_once("dao/UserDAO.php");

  $user = new User();
  $userDao = new UserDao($conn, $BASE_URL);

  $userData = $userDao->verifyToken(true);
?>

    <div id="main-container" class="container-fluid">
            <div class="offset-md-4 col-md-4 new-movie-container">
                <h1 class="page-title">Adicione seu filme</h1>
                <p class="page-description">Adicione sua critica e compartilhe com o mundo</p>
                <form action="<?= $BASE_URL?>movie_process.php" id="add-movie-form" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="type" value= "create">
                    <div class="form-group">
                        <label for="title">Titulo:</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Digite o titulo do filme">
                    </div>
                    <div class="form-group">
                        <label for="image">imagem:</label>
                        <input type="file" name="image" id="image" class="form-control-file">
                    </div>
                    <div class="form-group">
                        <label for="length">Duração:</label>
                        <input type="text" class="form-control" id="length" name="length" placeholder="Duração do filme">
                    </div>
                    <div class="form-group">
                        <label for="category">categoria:</label>
                        <select name="category" id="category" class="form-control">
                            <option value="">Selecione</option>
                            <option value="ação">Ação</option>
                            <option value="comédia">comédia</option>
                            <option value="suspense">suspense</option>
                            <option value="terror">terror</option>
                            <option value="ficção">ficção</option>
                            <option value="drama">drama</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="trailer">trailer:</label>
                        <input type="text" class="form-control" id="trailer" name="trailer" placeholder="Insira o link do trailer">
                    </div>
                    <div class="form-group">
                        <label for="description">descrição:</label>
                        <textarea class="form-control" name="description" row="5" id="description" placeholder="descreva o filme"></textarea>
                    </div>
                    <input type="submit" value="Enviar" class="btn card-btn">
                </form>
            </div>
    </div>

    

<?php
    require_once("templates/footer.php")
?>