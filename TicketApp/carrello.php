<?php
include_once "header.php";
require "Database\DB_connection.php";
?>
<h1>Il tuo Carrello</h1>

<?php
if(isset($_SESSION['user'])){
?>

<form method="post" action="acquisto.php" id="myForm">
    <?php

    $queryCart = "SELECT * FROM Carrello WHERE Utente = " . $_SESSION["user"];
    $statement = $pdo -> query($queryCart);
    if($statement)
        $resultsCart = $statement -> fetchAll();
    if(!empty($resultsCart)){
        foreach ($resultsCart as $item){
            $queryEvento = "SELECT Descrizione, Prezzo, Numero_Posti_Disponibili, Immagine FROM Eventi WHERE ID_Evento = ?";
            $statement2 = $pdo -> prepare($queryEvento);
            $statement2 -> execute([$item["Evento"]]);
            if($statement2)
                $resultsEvent = $statement2 -> fetchAll();
            ?>
            <div class="card mb-3 ms-2 me-2">
                <div class="row g-0">
                    <div class="col-md-1 align-self-center ms-5">
                        <input class="checkbox-cart" id="checkbox_<?=$item['Evento']?>" type="checkbox" name="acquisti[<?=$item["Evento"]?>]">
                    </div>
                    <div class="col-md-2 align-self-center p-0">
                        <img src="<?=$resultsEvent[0]["Immagine"] ?>" class="img-fluid rounded-start fixed-image imgCarrello" alt="<?=$resultsEvent[0]["Descrizione"] ?>">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body d-flex justify-content-between">
                            <div class="me-5">
                                <h4 class="card-title">Biglietto per: <?=$resultsEvent[0]["Descrizione"] ?></h4>
                                <p class="card-text">Prezzo: <?= $resultsEvent[0]['Prezzo'] ?>€</p>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="col-md-4 me-5">
                                    <input type="number" id="number_<?=$item['Evento']?>" name="acquisti[<?=$item["Evento"]?>]" class="form-control" value="1" min="1" max="<?=$resultsEvent[0]["Numero_Posti_Disponibili"]?>">
                                </div>
                                <div class="col-md-6">
                                    <button class="elimina-cart btn btn-dange" type="button" data-evento="<?=$item['Evento']?>">Rimuovi dal Carrello</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
        }
        ?>
        <button class="submitBtn btn btn-success mt-3" style="display: none;">Acquista ora</button>
        <?php
    }
    else{
        ?>
        <h4 style="text-align: center">Il tuo Carrello è vuoto... <br> Continua a navigare per acquistare biglietti!</h4>
        <?php
    }
    }
    else {
        if(isset($_POST["canc"]))
            unset($_SESSION["NotLog"]);
        ?>
        <div class="div-acquisto">
            <h4>Ricordati che per sfruttare tutte le funzioni del carrello devi eseguire il login</h4>
            <a href="login.php" class="btn btn-primary">Qui per il Login</a>
        </div>
        <?php
        if (isset($_SESSION["NotLog"])) {
            ?>
            <form method="post">
                <div class="div-buttons">
                    <input class="elimina-cart btn btn-danger" type="submit" name="canc" value="Svuota il Carrello">
                </div>
            </form>
            <?php
            foreach ($_SESSION["NotLog"] as $item){
                $queryEvento = "SELECT Descrizione, Numero_Posti_Disponibili, Immagine FROM Eventi WHERE ID_Evento = ?";
                $statement3 = $pdo -> prepare($queryEvento);
                $statement3 -> execute([$item]);
                $resultsEvent = $statement3 -> fetchAll();
                ?>
                <div class="container-cart row align-items-center">
                    <div class="col-md-4">
                        <img class="img-cart img-thumbnail" src="<?=$resultsEvent[0]["Immagine"] ?>" alt="Immagine Evento">
                    </div>
                    <div class="col-md-8">
                        <h4>Biglietto per: <?=$resultsEvent[0]["Descrizione"] ?></h4>
                    </div>
                </div>
                <?php
            }
        }
    }
    ?>
    <script defer src="carrelloScript.js"></script>
    <?php
    include_once "footer.php";
    ?>
