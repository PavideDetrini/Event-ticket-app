<?php
include_once "header.php";
require "Database\DB_connection.php";
?>

    <h1>Riepilogo</h1>
<?php
if(isset($_POST["acquisti"])){
    $prezzoTot = 0;
    unset($_SESSION["acquisti"]);
    foreach ($_POST["acquisti"] as $key => $value) {
        $_SESSION["acquisti"][$key] = $value;
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
        <form method="post">
            <input type="submit" value="Compra Tutto" name="confermato">
        </form>
    </div>
    <br>
    <?php
}elseif (isset($_POST["confermato"])){
    foreach ($_SESSION["acquisti"] as $key => $value){
        $queryEvent = "SELECT Descrizione FROM Eventi WHERE ID_Evento = ?";
        $statement2 = $pdo -> prepare($queryEvent);
        $statement2 -> execute([$key]);
        $resultsEvento = $statement2 -> fetchAll();
        try {
            $queryUpd = "Update Eventi SET Numero_Posti_Disponibili = Numero_Posti_Disponibili - ? WHERE ID_Evento = ?";
            $statement = $pdo -> prepare($queryUpd);
            $statement -> execute([$value, $key]);
            for ($i = 0; $i < $value; $i++) {
                $queryBigl = "INSERT INTO Biglietti(Utente, Evento) VALUE (". $_SESSION["user"] . ", ?)";
                $statement1 = $pdo -> prepare($queryBigl);
                $statement1 -> execute([$key]);
            }
            ?>
            <h3>Acquisto di: " <?=$resultsEvento[0]["Descrizione"]?> " è andato a buon fine!</h3>
            <br>
            <?php
            $queryCart = "DELETE FROM Carrello WHERE Utente = ? AND Evento = ?";
            $statement3 = $pdo -> prepare($queryCart);
            $statement3 -> execute([$_SESSION["user"], $key]);
        }catch (PDOException $Exception){
            ?>
            <h3>Acquisto di: " <?=$resultsEvento[0]["Descrizione"]?> " non è andato a buon fine...</h3>
            <br>
            <?php
        }
    }
}
?>