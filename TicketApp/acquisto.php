<?php
include_once "header.php";
require "Database\DB_connection.php";

if(isset($_SESSION['user'])){
?>
    <div class="container">
    <h1 class="mt-5 mb-4">Riepilogo</h1>
    <?php
    if(isset($_POST["acquisti"])){
        $prezzoTot = 0;
        unset($_SESSION["acquisti"]);
        foreach ($_POST["acquisti"] as $key => $value) {
            $_SESSION["acquisti"][$key] = $value;
            $queryEvento = "SELECT Descrizione, Numero_Posti_Disponibili, Prezzo, Immagine FROM Eventi WHERE ID_Evento = ?";
            $statement = $pdo -> prepare($queryEvento);
            $statement -> execute([$key]);
            $resultsEvent = $statement -> fetchAll();
            ?>
            <div class="card mb-3 border border-dark">
                <div class="row g-0">
                    <div class="col-md-4 border-end border-dark img-container d-flex align-items-center justify-content-center">
                        <img src="<?=$resultsEvent[0]["Immagine"] ?>" class="img-fluid rounded-start" alt="Event Image">
                    </div>
                    <div class="col-md-8 d-flex align-items-center">
                        <div class="card-body">
                            <h5 class="card-title"><?=$value ?> <?=$value > 1 ? "biglietti" : "biglietto"?> per: <?=$resultsEvent[0]["Descrizione"] ?></h5>
                            <p class="card-text-acquisto"><b>Costo: </b><?=$resultsEvent[0]["Prezzo"] * $value ?>€</p>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $prezzoTot += $resultsEvent[0]["Prezzo"] * $value;
        }
        ?>
        <div class="card mb-3 border-dark">
            <div class="card-body">
                <h5 class="card-title">Costo Totale: <?=$prezzoTot?>€</h5>
                <form method="post">
                    <input type="submit" value="Compra Tutto" name="confermato" class="btn btn-primary mt-2 mb-0">
                </form>
            </div>
        </div>
        <?php
    } elseif (isset($_POST["confermato"])) {
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
                <div class="alert alert-success" role="alert">
                    Acquisto di: <?=$resultsEvento[0]["Descrizione"]?> è andato a buon fine!
                </div>
                <?php
                $queryCart = "DELETE FROM Carrello WHERE Utente = ? AND Evento = ?";
                $statement3 = $pdo -> prepare($queryCart);
                $statement3 -> execute([$_SESSION["user"], $key]);
            } catch (PDOException $Exception) {
                ?>
                <div class="alert alert-danger" role="alert">
                    Acquisto di: <?=$resultsEvento[0]["Descrizione"]?> non è andato a buon fine...
                </div>
                <?php
            }
        }
    }
}
else{
    header("Location: login.php");
    exit();
}
?>
</div>
