<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet" type="text/css">
    <title>Cambia Email</title>
</head>
<body>
<div class="container text-center w-25 mx-auto">
    <h2>Cambia Email</h2>
    <form method="post" action="" autocomplete="off">
        <div class="form-group m-4">
            <input type="text" class="form-control" name="nome" id="nome" value="" placeholder="Nome">
        </div>
        <div class="form-group m-4">
            <input type="text" class="form-control" name="cognome" id="cognome" value="" placeholder="Cognome">
        </div>
        <div class="form-group m-4">
            <input type="email" class="form-control" name="email" id="email" value="" placeholder="Email">
        </div>
        <div class="form-group m-4">
            <input type="email" class="form-control" name="newEmail" id="newEmail" value="" placeholder="Nuova Email">
        </div>
        <div class="form-btn m-2">
            <input type="submit" class="btn btn-primary" name="submit" value="Cambia Email">
        </div>
    </form>

    <?php
    require_once 'DB_connection.php';

    if(isset($_POST['submit'])){
        $nome = $_POST['nome'];
        $cognome = $_POST['cognome'];
        $email = $_POST['email'];
        $newEmail = $_POST['newEmail'];

        $errors = array();
        if(empty($nome) || empty($cognome) || empty($email) || empty($newEmail)){
            array_push($errors, "Tutti i campi sono richiesti");
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            array_push($errors, "Email non valida");
        }
        if(!filter_var($newEmail, FILTER_VALIDATE_EMAIL)){
            array_push($errors, "Nuova email non valida");
        }

        $existEmail = $pdo -> prepare("SELECT * FROM Utenti WHERE Email LIKE :email");
        $existEmail->execute(['email' => $email]);
        if($existEmail->rowCount() <= 0){
            array_push($errors, "Account non esistente");
        }

        $duplicate = $pdo->prepare("SELECT * FROM Utenti WHERE Email = :email AND Email != :current_email");
        $duplicate->execute(['email' => $newEmail, 'current_email' => $email]);

        if($duplicate->rowCount() > 0){
            array_push($errors, "La nuova email è già associata a un altro account");
        }

        if(count($errors) > 0){
            foreach ($errors as $value){
                echo "<div class='container text-center alert alert-danger'>$value</div>";
            }
        }
        else{
            $updateQuery = "UPDATE Utenti SET Email = :new_email WHERE Email = :email";
            $statement = $pdo->prepare($updateQuery);
            $result = $statement->execute(['new_email' => $newEmail, 'email' => $email]);

            if ($result){
                echo "<div class='container text-center alert alert-success'>Email cambiata con successo</div>";
                echo "<a class='btn btn-primary' href='account.php'>Torna all'account</a>";
            }
            else{
                echo "<div class='container text-center alert alert-danger'>Si è verificato un errore durante l'aggiornamento dell'email</div>";
            }
        }
    }
    ?>
</div>
</body>
</html>

