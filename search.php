<?php
    require_once("templates/header.php");

    require_once("dao/movieDAO.php");

    $movieDao = new MovieDAO($conn,$BASE_URL);

    $q = filter_input(INPUT_GET ,"q");
    
    $movies = $movieDao->findByTitle($q)
?>

    <div id="main-container" class="container-fluid">
        <h2 class="section-title"> Você está buscando por <span id="search-result"><?= $q ?></span></h2>
        <p class="section-description">Resultado de busca retornados com base na sua pesquisa.</p>
        <div class="movies-container">
        <?php 
        foreach ($movies as $movie):?>
            
            <?php require("templates/movie_card.php");?>
            <?php endforeach; ?>
           
           <?php 
                if(count($movies) == 0){ ?>
                    <div class="empty-list">Não há filmes para está busca</div>
                <?php } ?>
            
        </div>
    </div>

     

<?php
    require_once("templates/footer.php")
?>