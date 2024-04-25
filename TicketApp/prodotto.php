<?php
    include_once "header.php";
    require "Database\DB_connection.php";
    if(!empty($_GET)){
?>
<div class="container-prodotto">
    <img src="images/default.jpg" width="600" height="337">
    <?php
    $query = "SELECT * FROM Eventi WHERE ID_Evento = " . $_GET["id"];
    $statement = $pdo -> query($query);
    if ($statement){
        $resultsEventi = $statement -> fetchAll();
    }
    $queryLuogo = "SELECT Città, Nome FROM Luoghi WHERE ID_Luogo = " . $resultsEventi[0]["Luogo"];
    $statement2 = $pdo -> query($queryLuogo);
    if ($statement2){
        $resultsLuogo = $statement2 -> fetchAll();
    }
    $queryCategoria = "SELECT * FROM CategoriaEventi JOIN Eventi ON CategoriaEventi.ID_Categoria = Eventi.Categoria WHERE ID_Categoria = " . $resultsEventi[0]["Categoria"];
    $statement3 = $pdo -> query($queryCategoria);
    if ($statement2){
        $resultsCategoria = $statement3 -> fetchAll();
    }


    /*
    echo '<pre>';
    print_r($results);
    echo '</pre>';
    */
    ?>
    <div class="testo">

        <h4><?=$resultsEventi[0]["Descrizione"]?></h4>
        <b>Data: </b><?=explode(" ", $resultsEventi[0]["Data"])[0]?>
        <br>
        <b>Ore: </b><?=explode(" ", $resultsEventi[0]["Data"])[1]?>
        <br>
        <b>Luogo: </b><?=$resultsLuogo[0]["Nome"] . ", " . $resultsLuogo[0]["Città"]?>
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
        <h1>Altri Eventi Simili...</h1>
    </div>
    <div class="owl-carousel owl-theme owl-loaded text-center">
        <div class="owl-stage-outer">
            <div class="owl-stage">
                <?php
                foreach ($resultsCategoria as $evento){
                    ?>
                    <div class="owl-item">
                        <img src="images\default.jpg">
                        <a href="prodotto.php?id=<?=$evento['ID_Evento']?>"><?= $evento['Descrizione'] . ' ' .  $evento['Prezzo']?></a>
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
