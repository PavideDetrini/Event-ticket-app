<?php
    require_once "Database\DB_connection.php";
    include_once "header.php";


    if(!isset($_SESSION['user'])){
        header("Location: index.php");
    }

    if(!empty($pdo)){
        $parameters['id'] = $_SESSION['user'];
        $query = "SELECT * FROM Utenti WHERE ID_Utente LIKE :id;";
        $statement = $pdo -> prepare($query);
        $result = $statement -> execute($parameters);

        if(!$statement){
            echo "ERROR";
        }
        else{
            $userData = $statement -> fetchAll();
?>
            <div class="container text-center">
                <div class="account-info d-flex flex-column justify-content-between">
                    <h1>Informazioni Account</h1>
                    <div class="info-item">
                        <strong>Nome:</strong>
                        <span><?=$userData[0]['Nome'] ?></span>
                    </div>
                    <div class="info-item">
                        <strong>Cognome:</strong>
                        <span><?=$userData[0]['Cognome'] ?></span>
                    </div>
                    <div class="info-item">
                        <strong>Username:</strong>
                        <span><?=$userData[0]['Username'] ?></span>
                    </div>
                    <div class="info-item">
                        <a href="cambia_username.php" class="btn btn-primary mt-2">Modifica</a>
                    </div>
                    <div class="info-item">
                        <strong>Email:</strong>
                        <span><?=$userData[0]['Email'] ?></span>
                    </div>
                    <div class="info-item">
                        <a href="cambia_email.php" class="btn btn-primary mt-2">Modifica</a>
                    </div>
                    <div class="info-item">
                        <a href="cambia_password.php" class="btn btn-primary mt-2">Modifica Password</a>
                    </div>
                </div>
            </div>

<?php
            $query2 = "SELECT Eventi.Descrizione, Eventi.Data, CONCAT(Luoghi.Nome, ', ', Luoghi.Città) AS Luogo
                       FROM Utenti JOIN Biglietti ON Utenti.ID_Utente = Biglietti.Utente
                       JOIN Eventi ON Biglietti.Evento = Eventi.ID_Evento
                       JOIN Luoghi ON Eventi.Luogo = Luoghi.ID_Luogo
                       WHERE Utenti.ID_Utente = ?;";
            $statement = $pdo -> prepare($query2);
            $result = $statement -> execute((array)$userData[0]['ID_Utente']);

            if(!$statement){
                echo "ERROR";
            }
            else{
                $acqusti = $statement -> fetchAll();
                if(!empty($acqusti)){
?>
                    <div class="container-account text-center">
                        <div class="account-info d-flex flex-column justify-content-between">
                            <h1>Cronologia Acquisti</h1>
<?php
                            foreach ($acqusti as $evento){

?>
                                <div class="info-item">
                                    <img src="images\default.jpg">
                                    <p><?= $evento['Descrizione'] . ' ' .  $evento['Luogo']?></p>
                                </div>
<?php
                            }
?>
                        </div>
                    </div>
<?php
                }
            }
        }
    }
?>