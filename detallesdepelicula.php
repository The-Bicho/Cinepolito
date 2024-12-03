
<!-- secciòn de detalles -->
<?php
 $ids =array(1,2,3,4,5);
 foreach  ($ids as $id){


 ?>
 <section id="<?=$id?>" class="section-content" >
 <h2 class="text-center">Detalles De Pelicula</h2>
        <div class="movie-header">
            <!-- Poster de la película -->
            <img src="poster-pelicula.jpg" alt="Poster de la Película">

            <!-- Información principal -->
            <div class="movie-details">
                <h2 class="movie-title">Pelicula con el id =<?=$id?></h2>
                <p class="movie-meta">Clasificación: PG-13 | Duración: 120 min</p>
                <p class="movie-meta">Género: Acción, Aventura</p>
            </div>
        </div>

       
        <!-- Sinopsis -->
        <div class="synopsis">
            <h3>Sinopsis</h3>
            <p>
                En un futuro apocalíptico, un grupo de héroes se une para salvar al mundo 
                de una amenaza inminente. Acción, aventura y drama se mezclan en esta épica historia.
            </p>
        </div>

        <!-- Créditos -->
        <div class="credits">
            <h3>Créditos</h3>
            <p><strong>Director:</strong> Jane Doe</p>
            <p><strong>Actores Principales:</strong> John Smith, Emma Brown, Michael Johnson</p>
        </div>

        <!-- Botón de Regreso -->
        <a href="Index.php" class="button">Volver a la Cartelera</a>
    </section>
    <?php
     
    }
 ?>
