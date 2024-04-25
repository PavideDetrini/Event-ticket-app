<?php
include_once "header.php";
require "Database\DB_connection.php";
if(!empty($_GET)){
    ?>
    <div class="container-prodotto">
        <!-- <img src="images/default.jpg" width="600" height="337"> -->
        <?php
        if(!empty($pdo)){
            $query = "SELECT * FROM Eventi 
                      JOIN categoriaeventi ON Eventi.Categoria = categoriaeventi.ID_Categoria
                      JOIN luoghi ON Eventi.Luogo = luoghi.ID_Luogo
                      WHERE Eventi.ID_Evento = " . $_GET["id"] . ";";
            $statement = $pdo -> query($query);
            if ($statement){
                $resultsEventi = $statement -> fetchAll();
            }

            foreach ($resultsEventi as $evento){
                $linkImmagine=$evento['Immagine'];
            }

            ?>
            <img  id="imgProdotto" src="<?= $linkImmagine ?>">

            <?php

            $queryCategoria = "SELECT * FROM Eventi WHERE Categoria = " . $resultsEventi[0]["Categoria"] . ";";
            $statement = $pdo -> query($queryCategoria);
            if ($statement){
                $resultsCategoria = $statement -> fetchAll();
            }
        }

        $formatter = new IntlDateFormatter('it_IT', IntlDateFormatter::LONG, IntlDateFormatter::NONE);

        ?>
        <div class="testo">

            <h4><?=$resultsEventi[0]["Descrizione"]?></h4>
            <p><strong>Data</strong>: <?=$formatter->format(strtotime(explode(" ", $resultsEventi[0]["Data"])[0]))?></p>
            <p><strong>Ora: </strong><?=explode(" ", $resultsEventi[0]["Data"])[1]?></p>
            <p><strong>Luogo: </strong><?=$resultsEventi[0]["Nome"] . ", " . $resultsEventi[0]["Città"]?></p>
            <p><strong>Prezzo: </strong><?=$resultsEventi[0]["Prezzo"]?>€</p>
        </div>
        <div>
            <form action="carrello.php" method="post">
                <label for="nPosti">inserire biglietti che si vogliono acquistare</label>
                <input id="nPosti" type="number" name="nPosti" max="<?=$resultsEventi[0]["Numero_Posti"] ?>" min="0">
                <input type="submit" value="acquista ora">

            </form>
            <form method="post">
                <input type="submit" value="aggiungi al carrello">
            </form>
        </div>
    </div>



    <div class="container-slider">
        <div class="category-header">
            <a href="categoria.php?categoria=<?=$resultsEventi[0]["Descrizione_Categoria"]?>">
                <h1>Altri Eventi Simili...</h1>
            </a>
        </div>
        <div class="owl-carousel owl-theme owl-loaded text-center">
            <div class="owl-stage-outer">
                <div class="owl-stage">
                    <?php

                    foreach ($resultsCategoria as $evento){
                        ?>
                        <div class="owl-item">
                            <img class="imgSwiper"  src="<?= $evento['Immagine'] ?>">
                            <a href="prodotto.php?id=<?=$evento['ID_Evento']?>"><?= $evento['Descrizione'] . ' ' .  $evento['Prezzo']?>€</a>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php
}
else{
    echo 'ERROR!';
}
include_once "footer.php";
?>
