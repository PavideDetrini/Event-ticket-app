
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
        $queryEvento = "SELECT Descrizione, Numero_Posti_Disponibili FROM Eventi WHERE ID_Evento = ?";
        $statement2 = $pdo -> prepare($queryEvento);
        $statement2 -> execute([$item["Evento"]]);
        if($statement2)
            $resultsEvent = $statement2 -> fetchAll();
        ?>
        <div class="container-cart">
            <input class="checkbox-cart" id="checkbox_<?=$item['Evento']?>" type="checkbox" name="acquisti[<?=$item["Evento"]?>]">
            <img class="img-cart" src="images/default.jpg">
            <h4>Biglietto per: <?=$resultsEvent[0]["Descrizione"] ?></h4>
            <div style="margin-left: auto">
                <div class="div-buttons">
                    <input type="button" class="check_true" id="button_<?=$item['Evento']?>" value="acquistane ora:">
                    <input type="number" id="number_<?=$item['Evento']?>" name="acquisti[<?=$item["Evento"]?>]"  value="1" min="1" max="<?=$resultsEvent[0]["Numero_Posti_Disponibili"]?>">
                </div>
                <div class="div-buttons">
                    <input class="elimina-cart" type="button" value="Rimuovi dal Carrello" data-evento="<?=$item['Evento']?>">
                </div>
            </div>
        </div>
        <?php
    }
     ?>
            <button class="submitBtn" style="display: none;">Acquista ora</button>
</form>


<?php
        }
    else{
        ?>

    <h4 style="text-align: center">il tuo Carrello per ora è vuoto... <br> continua a navigare per acquistare biglietti!</h4>
<?php
    }
}
    else {
        if(isset($_POST["canc"]))
            unset($_SESSION["NotLog"]);
        ?>
        <div class="div-acquisto">
            <h4>Ricordati che per sfruttare tutte le funzioni del carrello devi eseguire il login</h4>
            <a href="login.php">Qui per il Login</a>
        </div>
        <?php
        if (isset($_SESSION["NotLog"])) {
            ?>
            <form method="post">
                <div class="div-buttons">
                    <input class="elimina-cart" type="submit" name="canc" value="Svuota il Carrello">
                </div>
            </form>
            <?php
            foreach ($_SESSION["NotLog"] as $item){
                $queryEvento = "SELECT Descrizione, Numero_Posti_Disponibili FROM Eventi WHERE ID_Evento = ?";
                $statement3 = $pdo -> prepare($queryEvento);
                $statement3 -> execute([$item]);
                $resultsEvent = $statement3 -> fetchAll();
                ?>
                <div class="container-cart">
                    <img class="img-cart" src="images/default.jpg">
                    <h4>Biglietto per: <?=$resultsEvent[0]["Descrizione"] ?></h4>
                </div>
<?php

            }
            ?>
<?php
        }
    }
    ?>
<script defer src="carrelloScript.js"></script>
<?php
    include_once "footer.php";
?>

