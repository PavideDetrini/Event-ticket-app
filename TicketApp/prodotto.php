<?php
include_once "header.php";
require "Database\DB_connection.php";
if (!empty($_GET)) {
    ?>
    <div>
        <?php
        if (!empty($pdo)) {
            $query = "SELECT * FROM Eventi 
                      JOIN categoriaeventi ON Eventi.Categoria = categoriaeventi.ID_Categoria
                      JOIN luoghi ON Eventi.Luogo = luoghi.ID_Luogo
                      WHERE Eventi.ID_Evento = " . $_GET["id"] . ";";
            $statement = $pdo->query($query);
            if ($statement) {
                $resultsEventi = $statement->fetchAll();
            }

            foreach ($resultsEventi as $evento) {
                $linkImmagine = $evento['Immagine'];
            }

            $queryCategoria = "SELECT * FROM Eventi WHERE Eventi.Data > CURDATE() AND Categoria = " . $resultsEventi[0]["Categoria"] . " AND Eventi.ID_Evento != " . $_GET["id"] . ";";
            $statement = $pdo->query($queryCategoria);
            if ($statement) {
                $resultsCategoria = $statement->fetchAll();
            }
        }
        $formatter = new IntlDateFormatter('it_IT', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
        ?>

        <div class="row mt-4">
            <div class="col-md-6">
                <img class="img-fluid w-100 imgProdotto rounded" src="<?= $linkImmagine ?>">
            </div>
            <div class="col-md-6">
                <div>
                    <h4><?= $resultsEventi[0]["Descrizione"] ?></h4>
                    <p><strong>Data</strong>: <?= $formatter->format(strtotime(explode(" ", $resultsEventi[0]["Data"])[0])) ?></p>
                    <p><strong>Ora: </strong><?= explode(" ", $resultsEventi[0]["Data"])[1] ?></p>
                    <p><strong>Luogo: </strong><?= $resultsEventi[0]["Nome"] . ", " . $resultsEventi[0]["Città"] ?></p>
                    <p><strong>Prezzo: </strong><?= $resultsEventi[0]["Prezzo"] ?>€</p>
                </div>
                <div>
                    <form action="acquisto.php" method="post" class="mb-2">
                        <div class="form-group">
                            <input class="w-25" required id="nPosti" type="number" name="acquisti[<?= $_GET["id"] ?>]" max="<?= $resultsEventi[0]["Numero_Posti"] ?>" min="1" value="1">
                        </div>
                        <button type="submit" class="btn btn-primary">Acquista ora</button>
                    </form>
                    <form method="post">
                        <button type="submit" name="carrello" class="btn btn-primary">Aggiungi al carrello</button>
                    </form>
                    <?php
                    if (isset($_POST["carrello"])) {
                        if (isset($_SESSION["user"])) {
                            $duplicate = "SELECT * FROM Carrello WHERE Utente = " . $_SESSION['user'] . " AND Evento = " . $_GET["id"] . ";";
                            $result = $pdo->query($duplicate);
                            if ($result && $result->rowCount() > 0) {
                                echo "<div class='alert alert-danger mt-2 w-50 text-center'>Il prodotto è già presente nel carrello</div>";
                            } else {
                                $insertCarrello = "INSERT INTO Carrello(Utente, Evento) VALUES (" . $_SESSION['user'] . ", ?)";
                                $statement4 = $pdo->prepare($insertCarrello);
                                $statement4->execute([$_GET["id"]]);
                            }
                        } else {
                            $_SESSION['NotLog'][] = $_GET["id"];
                        }
                    }
                    ?>
                </div>
            </div>
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
                    foreach ($resultsCategoria as $evento) {
                        ?>
                        <div class="owl-item">
                            <a href="prodotto.php?id=<?= $evento['ID_Evento'] ?>">
                                <img class="imgSwiper" src="<?= $evento['Immagine'] ?>">
                            </a>
                            <a class="noDecoration" href="prodotto.php?id=<?= $evento['ID_Evento'] ?>"><?= $evento['Descrizione'] . ' ' . $evento['Prezzo'] ?></a>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
} else {
    echo '<div class="row mt-4"><div class="col"><div class="alert alert-danger" role="alert">ERROR!</div></div></div>';
}
include_once "footer.php";
?>
