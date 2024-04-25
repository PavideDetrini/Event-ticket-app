<?php
include_once "header.php";
require_once "Database\DB_connection.php";

$arrayCategorie = array();
if(isset($_SESSION['user'])){
    //HOMEPAGE CONSIGLIATA
    if(!empty($pdo)){
        $query = "SELECT Eventi.Descrizione, Eventi.Prezzo, Eventi.ID_Evento, Eventi.Immagine, COUNT(Biglietti.ID_Biglietto) AS Biglietti_Venduti
                  FROM Eventi LEFT JOIN Biglietti ON Eventi.ID_Evento = Biglietti.Evento
                  GROUP BY Eventi.ID_Evento
                  ORDER BY Biglietti_Venduti DESC LIMIT 9;";

        $statement = $pdo->query($query);
        if(!$statement){
            echo "ERROR";
        }
        else{
            $eventiConsigliati = $statement->fetchAll();
            ?>
            <div class="container-slider">
                <h1>Eventi Consigliati</h1>
                <div class="owl-carousel owl-theme owl-loaded text-center">
                    <div class="owl-stage-outer">
                        <div class="owl-stage">
                            <?php
                            foreach ($eventiConsigliati as $evento){
                                ?>
                                <div class="owl-item">
                                    <img class="imgSwiper" src="<?= $evento['Immagine'] ?>">
                                    <a href="prodotto.php?id=<?= $evento['ID_Evento'] ?>"><?= $evento['Descrizione'] . ' ' .  $evento['Prezzo'] ?>€</a>
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
    }
}
if (!empty($pdo)) {
    $query = "SELECT Descrizione_Categoria  FROM CategoriaEventi;";
    $statement = $pdo->query($query);

    if (!$statement){
        echo "ERROR";
    }
    else{
        $categorie = $statement->fetchAll();
        foreach ($categorie as $value){
            foreach ($value as $item){
                array_push($arrayCategorie, $item);
            }
        }
    }
}

foreach ($arrayCategorie as $value){
    array_push($arrayCategorie, $item);
    $query3="SELECT Eventi.Descrizione, Eventi.Prezzo, Eventi.ID_Evento, Eventi.Immagine
             FROM Eventi JOIN CategoriaEventi ON Eventi.Categoria = CategoriaEventi.ID_Categoria
             WHERE CategoriaEventi.Descrizione_Categoria LIKE '$value';";

    $statement3 = $pdo->query($query3);
    $eventi = $statement3->fetchAll();
    ?>
    <div class="container-slider">
        <div class="category-header">
            <h1><?= $value ?></h1>
            <a href="categoria.php?categoria=<?= $value ?>" class="read-more">Per saperne di più</a>
        </div>
        <div class="owl-carousel owl-theme owl-loaded text-center">
            <div class="owl-stage-outer">
                <div class="owl-stage">
                    <?php
                    foreach ($eventi as $evento){
                        ?>
                        <div class="owl-item">
                            <a href="prodotto.php?id=<?= $evento['ID_Evento'] ?>">
                                <img  class="imgSwiper" src="<?= $evento['Immagine'] ?>">
                                <?= $evento['Descrizione'] . ' ' .  $evento['Prezzo'] ?>€
                            </a>
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
include_once "footer.php";
?>
