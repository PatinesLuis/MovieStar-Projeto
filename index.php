<?php
    require_once("templates/header.php");

    require_once("dao/movieDAO.php");

    $movieDao = new MovieDAO($conn,$BASE_URL);

    $latesMovies = $movieDao->getLatesMovie();


    $actionMovies = [];

    $comedyMovies = [];

?>

    <div id="main-container" class="container-fluid">
        <h2 class="section-title"> Filmes novos</h2>
        <p class="section-description">Veja as criticas dos ultimos filmes adicionados no MovieStar</p>
        <div class="movies-container">
        <?php 
        foreach ($latesMovies as $movie):?>
            
            <?php require("templates/movie_card.php");?>
            <?php endforeach; ?>
            
        </div>

        <h2 class="section-title">Ação</h2>
        <p class="section-description">Veja os melhores filmes de ação</p>
        <div class="movies-container"></div>

        <h2 class="section-title"> Comédia</h2>
        <p class="section-description">Veja os melhores filmes de comedia</p>
        <div class="movies-container"></div>
    </div>

    

<?php
    require_once("templates/footer.php")
?>