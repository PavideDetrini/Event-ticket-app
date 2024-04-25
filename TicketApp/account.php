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
            <div class="container mt-5">
                <div class="account-info card shadow-sm p-4">
                    <h1 class="text-center mb-4">Informazioni Account</h1>
                    <div class="info-item d-flex align-items-center">
                        <strong>Nome:&nbsp;</strong>
                        <span class="ml-2"><?= $userData[0]['Nome'] ?></span>
                    </div>
                    <div class="info-item d-flex align-items-center">
                        <strong>Cognome:&nbsp;</strong>
                        <span class="ml-2"><?= $userData[0]['Cognome'] ?></span>
                    </div>
                    <div class="info-item d-flex align-items-center">
                        <strong>Username:&nbsp;</strong>
                        <span class="ml-2"><?= $userData[0]['Username'] ?></span>
                        <a href="cambia_username.php" class="btn btn-primary btn-sm ml-auto btn-modify">Modifica</a>
                    </div>
                    <div class="info-item d-flex align-items-center">
                        <strong>Email:&nbsp;</strong>
                        <span class="ml-2"><?= $userData[0]['Email'] ?></span>
                        <a href="cambia_email.php" class="btn btn-primary btn-sm ml-auto btn-modify">Modifica</a>
                    </div>
                    <div class="info-item d-flex justify-content-center">
                        <strong>Password:&nbsp;</strong>
                        <span class="ml-2">********</span>
                        <a href="cambia_password.php" class="btn btn-primary btn-sm ml-auto btn-modify">Modifica</a>
                    </div>
                </div>
            </div>

<?php
            $query2 = "SELECT Eventi.Descrizione, Eventi.Data, CONCAT(Luoghi.Nome, ', ', Luoghi.Città) AS Luogo, Eventi.Immagine
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
                                <div class="card mb-3 border border-dark card-cronologia">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            <img src="<?= $evento['Immagine'] ?>" class="img-fluid rounded-start imgCronologia" alt="<?= $evento['Descrizione'] ?>">
                                        </div>
                                        <div class="col-md-8 d-flex align-items-center">
                                            <div class="card-body d-flex justify-content-between align-items-center w-100">
                                                <div>
                                                    <h5 class="card-title"><?= $evento['Descrizione'] ?></h5>
                                                    <p class="card-text"><?= $evento['Luogo'] ?></p>
                                                    <p class="card-text"><?= $evento['Data'] ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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