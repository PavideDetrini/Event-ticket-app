<?php
include_once "header.php";
require "Database\DB_connection.php";
?>

<h1>Riepilogo</h1>
<?php
if(isset($_POST["acquisti"])){
    $prezzoTot = 0;
    foreach ($_POST["acquisti"] as $key => $value) {
            $queryEvento = "SELECT Descrizione, Numero_Posti_Disponibili, Prezzo FROM Eventi WHERE ID_Evento = ?";
            $statement = $pdo -> prepare($queryEvento);
            $statement -> execute([$key]);
            $resultsEvent = $statement -> fetchAll();
        ?>
        <div class="div-acquisto">
        <img src="images/default.jpg">
        <h3><?=$value ?> <?=$value > 1 ? " biglietti " : " biglietto "?> per: <?=$resultsEvent[0]["Descrizione"] ?></h3>
        <b>Costo: </b>
        <?php
        $prezzoTot += $resultsEvent[0]["Prezzo"] * $value;
        echo $resultsEvent[0]["Prezzo"] * $value;
        ?>€
        </div>
        <?php
    }

?>
    <div class="div-acquisto">
    <b>Costo Totale: </b><?=$prezzoTot?>€
    <form method="post" action="account.php">
        <input type="submit" value="Compra Tutto" name="confermato">
    </form>
    </div>
    <br>
<?php
}elseif (isset($_POST["confermato"])){
    //$query =
}
?>